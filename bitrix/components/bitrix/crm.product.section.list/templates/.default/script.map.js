{"version":3,"file":"script.min.js","sources":["script.js"],"names":["BX","CrmProductSectionManager","this","_id","_settings","_dialogs","prototype","initialize","id","settings","getSetting","name","defaultval","getMessage","messages","addSection","dlg","PopupWindow","autoHide","draggable","offsetLeft","offsetTop","bindOptions","forceBindPosition","closeByEsc","closeIcon","top","right","titleBar","events","onPopupShow","onPopupClose","delegate","destroy","onPopupDestroy","content","_prepareSectionAddDialogContent","buttons","_prepareSectionAddDialogButtons","show","nameElem","focus","select","tab","create","row","insertRow","ttl","insertCell","innerHTML","cnt","appendChild","props","type","value","style","width","result","push","PopupWindowButton","text","className","click","_hanleSectionAddDialogSave","PopupWindowButtonLink","popupWindow","close","form","actionField","nameField","nameInput","isNotEmptyString","alert","length","showWait","submit","renameSection","_prepareSectionRenameDialogContent","_prepareSectionRenameDialogButtons","_hanleSectionRenameDialogSave","idField","getDefault","_default","items","self"],"mappings":"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"}