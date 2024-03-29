<?php


namespace kpbs\custom;

use Bitrix\Main\Type;
use \Bitrix\Crm\CompanyTable;
use \Bitrix\Crm\DealTable;

class filldatawarehouse
{
    public static function executefilling()
    {
        \Bitrix\Main\Diag\Debug::writeToFile(date("Y.m.d G:i:s") ."agent", "agent", "__miros.log");
        \Bitrix\Main\Loader::includeModule('crm');
        /*\Bitrix\Main\Loader::includeModule('main');
        if(\CModule::IncludeModule("crm"))
        {
            \Bitrix\Main\Diag\Debug::writeToFile(date("Y.m.d G:i:s") ."modulecrm", "modulecrm", "__miros.log");
        }*/

        $kbuf = \COption::GetOptionString('kpbs.custom', 'kb_id');
        $cnuf = \COption::GetOptionString('kpbs.custom', 'cn_id');
        $cluf = \COption::GetOptionString('kpbs.custom', 'cl_id');
        $list = \COption::GetOptionString('kpbs.custom', 'ib_id');

        $curdate = date("d.m.Y");
        $curmonthdate = date("d.m");
        $curkv = intval((date('m')+2)/3);
        $curyear = date('Y');
        $curweekday = date("w");
        $curweek = date("W");
        $terminatedate = date("d.m.Y", strtotime('31.12.2020'));
        $add = new \CIBlockElement();
        // заносим пульс
        /*if($curweekday == 6) {
            $toDate = new Type\DateTime();
            $fromDate = Type\DateTime::createFromTimestamp(mktime(0, 0, 0, date('n'), date('j') - 7));
            $interval = 'day';
            $sectionField = 'CRM';

            $usersData = \Bitrix\Intranet\UStat\UStat::getUsersGraphData(1, $fromDate, $toDate, $interval, $sectionField);
            $usersRating = $usersData['rating']['top'];
            foreach ($usersRating as $rating) {
                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'CRMactivity',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ' => $curdate,
                        'MENEDZHER' => $rating['USER_ID'],
                        'ZNACHENIE_POKAZATELYA' => $rating['ACTIVITY']
                    ]
                ];
                $id = $add->Add($data);
            }
        }*/

        $filter = Array
        (
            "ACTIVE" => "Y",
            "!ID" => 61
        );

        $rsUser = \CUser::GetList(($by="ID"), ($order="desc"), $filter);
        // заносим прочие показатели
        while ($arResUser = $rsUser->Fetch()) {
            $kvavg = 0;
            $kvcurr = 0;
            $kvopen = 0;
            $countdeals = 0;
            $countmoddeals = 0;
            $countopen = 0;
            // анализ сделок
            $arResDeals = array();
            $crmactivity = 0;

            $arFilter = array('ASSIGNED_BY_ID'=> $arResUser['ID'], 'CLOSED'=>'Y', '>CLOSEDATE'=>$terminatedate);
            $arSelect = array('ID', 'ASSIGNED_BY_ID', 'CLOSED', 'CLOSEDATE', 'DATE_MODIFY',  $kbuf);
            //$obResDeal = CCrmDeal::GetListEx(false,$arFilter,false,false,$arSelect);
            $obResDeal = DealTable::getList([
                'filter' => $arFilter,
                'select' => $arSelect
            ]);


            //\Bitrix\Main\Diag\Debug::writeToFile($obResDeal, date("Y.m.d G:i:s") ."deals", "__miros.log");
            while ($arResDealfirst = $obResDeal->Fetch()) {
                array_push($arResDeals, $arResDealfirst);
            }

            $arFilter = array('ASSIGNED_BY_ID'=> $arResUser['ID'], 'CLOSED'=>'N');
            $arSelect = array('ID', 'ASSIGNED_BY_ID', 'CLOSED', 'CLOSEDATE', 'DATE_MODIFY',  $kbuf);
            //$obResDeal = CCrmDeal::GetListEx(false,$arFilter,false,false,$arSelect);
            $obResDeal = DealTable::getList([
                'filter' => $arFilter,
                'select' => $arSelect
            ]);

            while ($arResDealsecond = $obResDeal->Fetch()) {
                array_push($arResDeals, $arResDealsecond);
            }

            foreach ($arResDeals as $arResDeal) {
                if($arResDeal['CLOSED']!='Y') {
                    $kvcurr += $arResDeal[$kbuf];
                    $kvopen += $arResDeal[$kbuf];
                    $countdeals++;
                    $countopen++;
                } else {
                    $kv = intval((date('m', strtotime($arResDeal['CLOSEDATE'])) + 2)/3);
                    $year = date("Y.", strtotime($arResDeal['CLOSEDATE']));
                    if ($year ==$curyear && $kv==$curkv) {
                        $kvcurr += $arResDeal[$kbuf];
                        $countdeals++;
                    }
                }

                if($curweekday == 5) {
                    $compdate = strtotime('-3 days');
                    if(strtotime($arResDeal['DATE_MODIFY']) > $compdate) {
                        $countmoddeals++;
                    }
                } elseif($curweekday == 2) {
                    $compdate = strtotime('-4 days');
                    if(strtotime($arResDeal['DATE_MODIFY']) > $compdate) {
                        $countmoddeals++;
                    }
                }

            }
            if($countdeals>0) {
                $kvavg = round($kvcurr / $countdeals,2);
            }



            // анализ компаний
            $cntnetwork = 0;
            $cntlevel = 0;
            $countcnt = 0;
            $arFilter = array('ASSIGNED_BY_ID'=> $arResUser['ID']);
            $arSelect = array('ID', 'ASSIGNED_BY_ID', $cnuf, $cluf);
            //$obResCompany = CCrmCompany::GetListEx(false,$arFilter,false,false,$arSelect);
            $obResCompany = CompanyTable::getList([
                'filter' => $arFilter,
                'select' => $arSelect
            ]);
            while ($arResCompany = $obResCompany->Fetch()) {
                $countcnt++;
                $cntnetwork += $arResCompany[$cnuf];
                $cntlevel += $arResCompany[$cluf];
            }


            //crmactivity
            if($curweekday == 6) {
                $toDate = new Type\DateTime();
                $fromDate = Type\DateTime::createFromTimestamp(mktime(0, 0, 0, date('n'), date('j') - 7));
                $interval = 'day';
                $sectionField = 'CRM';

                $usersData = \Bitrix\Intranet\UStat\UStat::getUsersGraphData($arResUser['ID'], $fromDate, $toDate, $interval, $sectionField);

                foreach($usersData['data'] as $userating) {
                    $crmactivity += $userating['CRM'];
                }
            }

            // заполнение показателей
            if($countdeals > 0) {
                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'KVcurr',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ'=> $curdate,
                        'MENEDZHER'=> $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA'=> $kvcurr
                    ]
                ];
                $id = $add->Add($data);

                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'KVavg',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ'=> $curdate,
                        'MENEDZHER'=> $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA'=> $kvavg
                    ]
                ];
                $id = $add->Add($data);

                if($curmonthdate == '01.01' || $curmonthdate == '01.04' || $curmonthdate == '01.07' ||
                    $curmonthdate == '01.10') {
                    $data = [
                        'IBLOCK_ID' => $list,
                        'ACTIVE' => 'Y',
                        'NAME' => 'KVq',
                        'PROPERTY_VALUES' => [
                            'DATA_POKAZ'=> $curdate,
                            'MENEDZHER'=> $arResUser['ID'],
                            'ZNACHENIE_POKAZATELYA'=> $kvopen
                        ]
                    ];
                    $id = $add->Add($data);
                }

            }
            if ($countopen>0 && $countmoddeals>0) {
                $qualact = round($countmoddeals / $countopen,2);
                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'QualAct',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ'=> $curdate,
                        'MENEDZHER'=> $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA'=> $qualact
                    ]
                ];
                $id = $add->Add($data);
            }

            if ($countcnt>0) {
                $cntlevelavg = round($cntlevel / $countcnt,2);
                $cntnetwavg = round($cntnetwork / $countcnt,2);
                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'CNTLev',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ'=> $curdate,
                        'MENEDZHER'=> $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA'=> $cntlevelavg
                    ]
                ];
                $id = $add->Add($data);

                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'CNTNet',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ'=> $curdate,
                        'MENEDZHER'=> $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA'=> $cntnetwavg
                    ]
                ];
                $id = $add->Add($data);
            }

            if($crmactivity>0) {
                $data = [
                    'IBLOCK_ID' => $list,
                    'ACTIVE' => 'Y',
                    'NAME' => 'CRMactivity',
                    'PROPERTY_VALUES' => [
                        'DATA_POKAZ' => $curdate,
                        'MENEDZHER' => $arResUser['ID'],
                        'ZNACHENIE_POKAZATELYA' => $crmactivity
                    ]
                ];
                $id = $add->Add($data);
            }
        }
        return '\kpbs\custom\filldatawarehouse::executefilling();';
    }
}