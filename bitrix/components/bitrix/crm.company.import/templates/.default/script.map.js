{"version":3,"sources":["script.js"],"names":["crmImportStep","step","form_id","selectTab","arDisable","Array","splice","bxForm","eval","SelectTab","elDisable","ShowDisabledTab","BX","className","crmImportAjax","importUrl","ajax","url","util","add_url_param","import","method","dataType","data","onsuccess","parseInt","style","display","height","i","tableRow","create","tableRowColumn","props","colSpan","innerHTML","appendChild","ii","type","isArray","iii","text","href","isNotEmptyString","disabled","hidden","complete_import","onfailure","CrmFileImportConfig","this","_id","_settings","_dupControlTypeDescr","_dupControlTypes","prototype","initialize","id","settings","dupControlPrefix","getSetting","key","hasOwnProperty","element","toLowerCase","bind","delegate","_onDupControlTypeChange","name","defaultval","e","window","event","target","getEventTarget","value","htmlspecialchars","self","namespace","Crm","CompanyImportSampleLink","Math","random","toString","substring","getSample","formElement","checkbox","querySelector","checked","impRq","location","items","delete","destroy"],"mappings":"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","file":""}