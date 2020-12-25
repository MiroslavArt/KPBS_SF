{"version":3,"sources":["editprocess.js"],"names":["BX","namespace","Disk","Document","EditProcess","parameters","this","objectId","attachedObjectId","serviceCode","service","popupConfirm","onAfterSave","modalWindow","type","isFunction","prototype","start","buildModalWindow","loadServiceDescription","then","openEditConfirm","bind","openModal","util","add_url_param","action","isActive","isShown","link","width","height","location","popup","window","addEventListener","event","origin","data","reason","setDataForCommit","closeEditConfirm","closeModal","close","e","getDataForCommit","dataForCommit","getService","promise","Promise","fulfill","ajax","runAction","response","documentService","buildLinkToCommit","uri","links","edit","uf","replace","remove_url_param","document_action","save","commit","console","log","status","UI","Viewer","Instance","showModalWithStatusAction","originalIsLocked","InformationPopups","showWarningLockedDocument","getUrlToShowObjectInGrid","forkedObject","id","call","fakePromise","idDoc","method","dataType","url","editSessionId","sessid","bitrix_sessid","buildLinkToDiscard","urlHelper","getUrlDiscardFile","discard","onsuccess","getViewerZindex","getClass","getZindex","getConfirmMessages","title","message","name","text","saveButton","saveDialog","create","props","className","children","PopupWindowManager","content","overlay","buttons","PopupWindowCustomButton","events","click","actionModal","showActionModal","showLoaderIcon","autoHide","onbeforeunload","closeByEsc","zIndex","onPopupClose","destroy","show","ajaxDocUrl","ajaxUfDocUrl","normalizeServiceName","toLowerCase","getUrlViewFile","addToLinkParam","getUrlCheckView","getUrlStartPublishBlank","getUrlCommitBlank","targetFolderId","getUrlRenameFile","getUrlCopyToMe","getUrlEditFile","getUrlCommitFile","getUrlDiscardBlankFile","value","length","indexOf"],"mappings":"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","file":"editprocess.map.js"}