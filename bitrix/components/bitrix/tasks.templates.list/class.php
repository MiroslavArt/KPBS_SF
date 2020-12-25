<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Grid;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Filter;
use Bitrix\Tasks\Manager;
use Bitrix\Tasks\Util\Restriction\Bitrix24Restriction\Limit\TaskLimit;

Loc::loadMessages(__FILE__);

CBitrixComponent::includeComponentClass("bitrix:tasks.base");

class TasksTemplatesListComponent extends TasksBaseComponent
{
	protected function checkParameters()
	{
		static::tryParseIntegerParameter($this->arParams['USER_ID'], $this->userId);
		static::tryParseStringParameter(
			$this->arParams['PATH_TO_USER_TASKS_TEMPLATES'],
			'/company/personal/user/#user_id#/tasks/templates/'
		);
		static::tryParseStringParameter(
			$this->arParams['PATH_TO_USER_TASKS_TEMPLATE'],
			'/company/personal/user/#user_id#/tasks/templates/template/#action#/#template_id#/'
		);
		static::tryParseStringParameter($this->arParams['PATH_TO_USER_PROFILE'], '/company/personal/user/#user_id#/');
		static::tryParseStringParameter($this->arParams['PATH_TO_GROUP'], '/workgroups/group/#group_id#/');

		static::tryParseStringParameter($this->arParams['NEED_GROUP_BY_GROUPS'], 'Y');

		static::tryParseStringParameter($this->arParams['FILTER_ID'], 'TASKS_TEMPLATES_FILTER_ID');
		static::tryParseStringParameter($this->arParams['GRID_ID'], $this->arParams['FILTER_ID']);

		return $this->errors->checkNoFatals();
	}


	public static function getAllowedMethods()
	{
		// todo
		return array(
			'processGroupActions'
		);
	}

	protected function doPreAction()
	{
		$this->arResult['IS_SEARCH_MODE'] = $this->getFilterFieldData('FILTER_APPLIED', false) == true;

		// sub template

		return parent::doPreAction(); // TODO: Change the autogenerated stub
	}


	public static function processGroupActions($action, $ids, $isAllSelected=false)
	{
		if($isAllSelected)
		{
			$result = true;

			$userId = \Bitrix\Tasks\Util\User::getId();
			$mgrResult = Manager\Task\Template::getList($userId, ['select' => ['ID'], 'filter' => []]);
			$ids = array_column($mgrResult['DATA'], 'ID');

			switch($action)
			{
				case 'delete':
					$result = \CTaskTemplates::DeleteBatch($ids);
				break;
			}

			return $result;
		}
		
		$request = static::getRequest(true);

		$auxParams = array(
			'QUERY_TYPE' => static::QUERY_TYPE_AJAX,
			'CLASS_NAME' => static::getComponentClassName(),
			'REQUEST'    => $request
		);

		$arParams = [];
		$errors = new \Bitrix\Tasks\Util\Error\Collection();

		$plan = new \Bitrix\Tasks\Dispatcher\ToDo\Plan();
		$todo = [];

		$arguments = [];
		
		foreach ($ids as $id)
		{
			$arguments['id'] = $id;

			$todo[] = array(
				'OPERATION'  => 'task.template.'.mb_strtolower($action),
				'ARGUMENTS'  => $arguments,
				'PARAMETERS' => $arParams
			);
		}
		$plan->import($todo);

		static::dispatch($plan, $errors, $auxParams, $arParams);

		return $errors->checkNoFatals();
	}

	private function getFilterFieldData($field, $default = null)
	{
		static $filterData;

		if (!$filterData)
		{
			$filterData = $this->getFilterOptions()->getFilter($this->getFilterFields());
		}

		return array_key_exists($field, $filterData) ? $filterData[$field] : $default;
	}

	/**
	 * @return Filter\Options
	 */
	private function getFilterOptions()
	{
		static $instance = null;

		if (!$instance)
		{
			return new Filter\Options($this->arParams['FILTER_ID']);
		}

		return $instance;
	}

	private function getFilterFields()
	{
		return [
			'ID' => [
				'id'   => 'ID',
				'name' => Loc::getMessage('TASKS_TEMPLATE_ID'),
				'type' => 'number'
			],

			'TITLE' => array(
				'id'   => 'TITLE',
				'name' => Loc::getMessage('TASKS_TEMPLATE_TITLE'),
				'type' => 'string'
			),

			'RESPONSIBLE' => [
				'id'       => 'RESPONSIBLE',
				'name'     => Loc::getMessage('TASKS_TEMPLATE_RESPONSIBLE_ID'),
				'params'   => ['multiple' => 'Y'],
				'type'     => 'custom_entity',
				'selector' => array(
					'TYPE' => 'user',
					'DATA' => array(
						'ID'       => 'user',
						'FIELD_ID' => 'RESPONSIBLE'
					)
				)
			],

			'CREATED_BY' => [
				'id'       => 'CREATED_BY',
				'name'     => Loc::getMessage('TASKS_TEMPLATE_CREATED_BY'),
				'params'   => ['multiple' => 'Y'],
				'type'     => 'custom_entity',
				'selector' => array(
					'TYPE' => 'user',
					'DATA' => array(
						'ID'       => 'user',
						'FIELD_ID' => 'CREATED_BY'
					)
				)
			],

			'GROUP_ID'    => [
				'id'       => 'GROUP_ID',
				'name'     => Loc::getMessage('TASKS_TEMPLATE_GROUP_ID'),
				'params'   => ['multiple' => 'Y'],
				'type'     => 'custom_entity',
				'selector' => [
					'TYPE' => 'group',
					'DATA' => [
						'ID'       => 'group',
						'FIELD_ID' => 'GROUP_ID'
					]
				]
			],
			'TAGS'        => [
				'id'   => 'TAGS',
				'name' => Loc::getMessage('TASKS_TEMPLATE_TAGS')
			],
			'TPARAM_TYPE' => [
				'id'    => 'TPARAM_TYPE',
				'name'  => Loc::getMessage('TASKS_TEMPLATE_FOR_NEW_USER'),
				'type'  => 'list',
				'items' => array(
					1 => Loc::getMessage('TASKS_TEMPLATES_YES'),
					2 => Loc::getMessage('TASKS_TEMPLATES_NO'),
				)
			],
			'REGULAR'     => [
				'id'    => 'REGULAR',
				'name'  => Loc::getMessage('TASKS_TEMPLATE_REGULAR'),
				'type'  => 'list',
				'items' => array(
					1 => Loc::getMessage('TASKS_TEMPLATES_YES'),
					2 => Loc::getMessage('TASKS_TEMPLATES_NO'),
				)
			],
		];
	}

	protected function doPostAction()
	{
		return parent::doPostAction(); // TODO: Change the autogenerated stub
	}

	protected function getData()
	{
		$this->getGridOptions()->resetExpandedRows();

		$this->arParams['UF'] = $this->getUF();
		$this->arResult['GRID']['HEADERS'] = $this->getGridHeaders();
		$this->arResult['GRID']['DATA'] = $this->getGridData();

		$this->arResult['FILTER']['FIELDS'] = $this->getFilterFields();
		$this->arResult['FILTER']['PRESETS'] = $this->getFilterPresets();
	}

	protected function getAuxData()
	{
		$this->arResult['TASK_LIMIT_EXCEEDED'] = TaskLimit::isLimitExceeded();
	}

	/**
	 * @return Grid\Options
	 */
	private function getGridOptions()
	{
		static $instance = null;

		if (!$instance)
		{
			return new Grid\Options($this->arParams['GRID_ID']);
		}

		return $instance;
	}

	/**
	 * @return \Bitrix\Tasks\Util\UserField|array|null|string
	 */
	private function getUF()
	{
		$uf = \Bitrix\Tasks\Item\Task\Template::getUserFieldControllerClass();

		$scheme = $uf::getScheme();
		unset($scheme['UF_TASK_WEBDAV_FILES']);

		return $scheme;
	}

	private function getGridHeaders()
	{
		$list = [
			'ID'                            => [
				'id'       => 'ID',
				'name'     => GetMessage('TASKS_TEMPLATE_ID'),
				'editable' => false,
				'default'  => false,
				'sort'     => 'ID',
			],
			'TASKS_TEMPLATE_TITLE'          => [
				'id'       => 'TASKS_TEMPLATE_TITLE',
				'name'     => GetMessage('TASKS_TEMPLATE_TITLE'),
				'editable' => false,
				'default'  => true,
				'shift'    => true,
				'sort'     => 'TITLE',
			],
			'TASKS_TEMPLATE_DEADLINE_AFTER' => [
				'id'       => 'TASKS_TEMPLATE_DEADLINE_AFTER',
				'name'     => GetMessage('TASKS_TEMPLATE_DEADLINE_AFTER'),
				'editable' => false,
				'default'  => true,
				'sort'     => 'DEADLINE',
			],
			'TASKS_TEMPLATE_RESPONSIBLE_ID' => [
				'id'       => 'TASKS_TEMPLATE_RESPONSIBLE_ID',
				'name'     => GetMessage('TASKS_TEMPLATE_RESPONSIBLE_ID'),
				'editable' => false,
				'default'  => true,
				'sort'     => 'responsible_last_name'
			],
			'TASKS_TEMPLATE_CREATED_BY'     => [
				'id'       => 'TASKS_TEMPLATE_CREATED_BY',
				'name'     => GetMessage('TASKS_TEMPLATE_CREATED_BY'),
				'editable' => false,
				'default'  => true,
				'sort'     => 'creator_last_name'
			],
			'TASKS_TEMPLATE_GROUP_ID'       => [
				'id'       => 'TASKS_TEMPLATE_GROUP_ID',
				'name'     => GetMessage('TASKS_TEMPLATE_GROUP_ID'),
				'editable' => false,
				'default'  => false,
				'sort'     => 'group_id'
			],
			'TASKS_TEMPLATE_TAGS'           => [
				'id'       => 'TASKS_TEMPLATE_TAGS',
				'name'     => GetMessage('TASKS_TEMPLATE_TAGS'),
				'editable' => false,
				'default'  => false
			],
			'TASKS_TEMPLATE_FOR_NEW_USER'   => [
				'id'       => 'TASKS_TEMPLATE_FOR_NEW_USER',
				'name'     => GetMessage('TASKS_TEMPLATE_FOR_NEW_USER'),
				'editable' => false,
				'default'  => false
			],
			'TASKS_TEMPLATE_REGULAR'        => [
				'id'       => 'TASKS_TEMPLATE_REGULAR',
				'name'     => GetMessage('TASKS_TEMPLATE_REGULAR'),
				'editable' => false,
				'default'  => false
			]
		];

		foreach ($this->getUF() as $ufName => $ufItem)
		{
			$list[$ufName] = [
				'id'          => $ufName,
				'name'        => $ufItem['EDIT_FORM_LABEL'],
				'sort'        => false,
				'first_order' => 'desc',
				'editable'    => false
			];
		}

		return $list;
	}

	private function getGridData()
	{
		$filter = $this->processFilter();

		if (!$this->arResult['IS_SEARCH_MODE'])
		{
			$filter['BASE_TEMPLATE_ID'] = 0;
		}

		if (isset($this->arParams['BASE_TEMPLATE_ID']))
		{
			if ($filter['BASE_TEMPLATE_ID'] <= 0)
			{
				$filter['BASE_TEMPLATE_ID'] = $this->arParams['BASE_TEMPLATE_ID'];
			}
		}

		if (\Bitrix\Main\Grid\Context::isInternalRequest() &&
			check_bitrix_sessid() &&
			$_REQUEST['action'] == \Bitrix\Main\Grid\Actions::GRID_GET_CHILD_ROWS)
		{
			if (!empty($_REQUEST['parent_id']))
			{
				$filter['BASE_TEMPLATE_ID'] = $_REQUEST['parent_id'];
			}
		}

		$parameters = array('ERRORS' => $this->errors);

		//region NAV
		$navPageSize = $this->getPageSize();
		//endregion

		$getListParameters = [
			'order'  => $this->getOrder(),
			'select' => ['*', 'BASE_TEMPLATE_ID', 'UF_*'],
			'filter' => $filter,
		];

		$getListParameters['NAV_PARAMS'] = [
			'nPageSize'          => $navPageSize,
			'bDescPageNumbering' => false,
			'NavShowAll'         => false,
			'bShowAll'           => false,
			'showAlways'         => false,
			'SHOW_ALWAYS'        => false
		];

		if (array_key_exists('clear_nav', $_REQUEST) && $_REQUEST['clear_nav'] == 'Y')
		{
			$getListParameters['NAV_PARAMS']['iNumPage'] = 1;
		}

		$mgrResult = Manager\Task\Template::getList($this->userId, $getListParameters, $parameters);


		//region NAV
		$this->arResult['NAV_OBJECT'] = $mgrResult['OBJ_RES'];
		$this->arResult['NAV_OBJECT']->NavStart($navPageSize, false);
//		$this->arResult['PAGE_SIZES'] = $this->pageSizes;

		$this->arResult['TOTAL_RECORD_COUNT'] = $this->arResult['NAV_OBJECT']->NavRecordCount;
		//endregion

		return $mgrResult['DATA'];
	}

	protected function getOrder()
	{
		$gridSort = [];
		$sortResult = ['group_id' => 'asc'];

		$request = \Bitrix\Main\Context::getCurrent()->getRequest();
		if ($request->get('by') != null)
		{
			$sortResult[$request->get('by')] = $request->get('order') ? $request->get('order') : 'asc';
			$this->getGridOptions()->setSorting($request->get('by'), $sortResult[$request->get('order')]);
			$this->getGridOptions()->save();
		}
		else
		{
			$gridSort = $this->getGridOptions()->GetSorting(
				array(
					'sort' => array('DEADLINE' => 'desc,nulls', 'ID' => 'asc'),
					'vars' => array('by' => 'by', 'order' => 'order')
				)
			);
			$gridSort = $gridSort['sort'];
		}

		$sortResult = array_merge($sortResult, $gridSort);

		if (!array_key_exists('ID', $sortResult))
		{
			$sortResult['ID'] = 'asc';
		}

		foreach ($sortResult as $key => &$value)
		{
			if (in_array($key, array('DEADLINE')))
			{
				$value = $value.',nulls';
			}
		}

		return $sortResult;
	}

	private function processFilter()
	{
		static $arrFilter = [];

		if (empty($arrFilter))
		{
			if ($this->getFilterFieldData('FIND'))
			{
				$arrFilter['SEARCH_INDEX'] = $this->getFilterFieldData('FIND');
			}

			if ($this->getFilterFieldData('FILTER_APPLIED', false) != true)
			{
				return $arrFilter;
			}

			foreach ($this->getFilterFields() as $item)
			{
				switch ($item['type'])
				{
					default:
						$field = $this->getFilterFieldData($item['id']);
						if ($field)
						{
							if ($this->getFilterFieldData('FOR_NEW_USER', 0) == 1)
							{
								$arrFilter['RESPONSIBLE'][] = 0;
							}
							else if (is_numeric($field) && $item['id'] != 'TITLE')
							{
								$arrFilter[$item['id']] = $field;
							}
							else
							{
								$arrFilter['%'.$item['id']] = $field;
							}
						}
						break;
					case 'date':
						if ($this->getFilterFieldData($item['id'].'_from'))
						{
							$arrFilter['>='.$item['id']] = $this->getFilterFieldData($item['id'].'_from');
						}
						if ($this->getFilterFieldData($item['id'].'_to'))
						{
							$arrFilter['<='.$item['id']] = $this->getFilterFieldData($item['id'].'_to');
						}
						break;
					case 'number':
						if ($this->getFilterFieldData($item['id'].'_from'))
						{
							$arrFilter['>='.$item['id']] = $this->getFilterFieldData($item['id'].'_from');
						}
						if ($this->getFilterFieldData($item['id'].'_to'))
						{
							$arrFilter['<='.$item['id']] = $this->getFilterFieldData($item['id'].'_to');
						}

						if (array_key_exists('>='.$item['id'], $arrFilter) &&
							array_key_exists('<='.$item['id'], $arrFilter) &&
							$arrFilter['>='.$item['id']] == $arrFilter['<='.$item['id']])
						{
							$arrFilter[$item['id']] = $arrFilter['>='.$item['id']];
							unset($arrFilter['>='.$item['id']], $arrFilter['<='.$item['id']]);
						}

						break;

					case 'custom_entity':
					case 'list':
						if ($this->getFilterFieldData($item['id']))
						{
							if ($item['id'] == 'REGULAR')
							{
								$arrFilter['REPLICATE'][] = $this->getFilterFieldData($item['id'], 0) == 1 ? 'Y' : 'N';
							}
							else if ($item['id'] == 'TPARAM_TYPE')
							{
								$arrFilter['TPARAM_TYPE'][] = $this->getFilterFieldData($item['id'], 0) == 1 ? 1 : 0;
							}
							else
							{
								$val = $this->getFilterFieldData($item['id']);
								if (is_array($val))
								{
									$arrFilter[$item['id']] = $val;

								}
								else
								{
									$arrFilter[$item['id']][] = $val;
								}
							}
						}
						break;
				}
			}
		}

		return $arrFilter;
	}

	private function getPageSize()
	{
		$navParams = $this->getGridOptions()->getNavParams(['nPageSize' => 50]);

		return (int)$navParams['nPageSize'];
	}

	private function getFilterPresets()
	{
		return [
			'filter_tasks_templates_active_regular' => array(
				'name'    => Loc::getMessage('TASKS_PRESET_ACTIVE_REGULAR'),
				'default' => false,
				'fields'  => array(
					'REGULAR' => 1
				)
			),
			'filter_tasks_templates_new_user'       => array(
				'name'    => Loc::getMessage('TASKS_PRESET_NEW_USER'),
				'default' => false,
				'fields'  => array(
					'TPARAM_TYPE' => 1
				)
			),
		];
	}

}