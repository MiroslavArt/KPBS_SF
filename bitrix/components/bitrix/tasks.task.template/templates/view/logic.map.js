{"version":3,"sources":["logic.js"],"names":["BX","namespace","Tasks","Component","TasksTaskTemplate","extend","sys","code","methods","construct","this","callConstruct","initFileView","query","Util","Query","url","checkListChanged","showCloseConfirmation","analyticsData","bindEvents","Dispatcher","bindEvent","id","onButtonClick","bind","option","edit","addCustomEvent","proxy","syncTags","bindControl","passCtx","onImportantButtonClick","onSaveButtonClick","onCancelButtonClick","createTemplateMenu","onSubTemplateAddClick","errors","alert","then","reload","onSliderClose","Event","EventEmitter","subscribe","eventData","action","data","allowedActions","util","in_array","toggleFooterWrap","event","CheckListInstance","checkListSlider","optionManager","slider","getSlider","denyAction","showChecklistCloseSliderPopup","checklistCloseSliderPopup","PopupWindow","titleBar","message","content","closeIcon","buttons","PopupWindowButton","text","className","events","click","close","show","node","priority","PRIORITY","newPriority","callRemote","ID","result","isSuccess","toggleClass","tags","length","tmpTags","each","tag","push","NAME","name","SE_TAG","UI","Notification","Center","notify","window","location","controlAll","area","top","viewElementBind","type","isElementNode","getAttribute","isSaving","activateLoading","saveCheckList","e","TASK_LIMIT_EXCEEDED","preventDefault","InfoHelper","self","treeStructure","getTreeStructure","args","items","getRequestData","templateId","userId","USER_ID","params","Object","assign","checklistCount","getDescendantsCount","run","traversedItems","getData","TRAVERSED_ITEMS","keys","forEach","nodeId","item","findChild","fields","getId","setId","saveStableTreeStructure","deactivateLoading","execute","popup","rerender","onPopupClose","destroy","footer","saveButton","classWait","classActive","hasClass","addClass","removeClass","menuItemsList","delimiter","tabId","onclick","getMenuWindow","layout","setShowCompleted","getShowCompleted","handleTaskOptions","setShowOnlyMine","getShowOnlyMine","menu","PopupMenu","create","closeByEsc","offsetLeft","getBoundingClientRect","width","angle","popupWindow","call"],"mappings":"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","file":"logic.map.js"}