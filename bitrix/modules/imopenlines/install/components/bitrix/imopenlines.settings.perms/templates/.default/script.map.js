{"version":3,"sources":["script.js"],"names":["BX","ViPermissionEdit","element","this","elements","main","accessTable","accessTableBody","accessTableLastRow","ajaxUrl","init","prototype","querySelector","bindHandlers","Access","Init","other","disabled","deleteRoleNodes","querySelectorAll","deleteAccessNodes","addAccessNodes","selectRoleNodes","i","length","removeEventListener","handleDeleteRoleClick","bind","addEventListener","handleDeleteAccessClick","handleAddAccessClick","handleSelectRoleChange","addCustomEvent","delegate","event","getEventId","document","location","reload","e","preventDefault","stopPropagation","target","roleId","dataset","self","elementsToRemove","confirm","message","confirmed","showWait","ajax","url","method","dataType","data","action","sessid","bitrix_sessid","onsuccess","closeWait","ERROR","notify","remove","onfailure","selectedAccessCodes","rowCount","rows","accessCode","SetSelected","ShowForm","callback","providerName","accessName","provider","id","GetProviderName","name","renderNewAccessCode","roleAccessCode","value","tableRow","template","innerHTML","__replaceAll","PROVIDER","NAME","ACCESS_CODE","newElement","create","html","insertBefore","title","text","result","popupId","popupWindow","PopupWindow","content","titleBar","closeByEsc","buttons","PopupWindowButton","className","events","click","close","type","isFunction","PopupWindowButtonLink","show","isPlainObject","replace","match","variable","offset","hasOwnProperty"],"mappings":"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","file":"script.map.js"}