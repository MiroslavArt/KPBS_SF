{"version":3,"file":"script.min.js","sources":["script.js"],"names":["BX","CrmSendSaveEditor","this","_settings","_currentMailbox","prototype","initialize","settings","form","getForm","mailboxLst","findChild","tag","attr","name","bind","delegate","_handleMailboxChange","sslChbx","type","_handleSslClick","createLeadChbx","_adjustRowVisibility","checked","_handleCreateLeadClick","_layout","getSetting","defaultval","document","getElementById","mailboxFld","id","value","CrmSendSaveMailbox","create","layout","SERVER_TYPE","mailboxSettings","i","length","setting","selectedIndex","options","ssl","port","chbx","element","visible","row","findParent","style","display","_default","createDefault","self","getDefault","_editor","editor","_display","elem","_displayHeaders","offset","headers","findChildren","class","_findText","_findCheckbox","_findPassword","_findSelect","_setupText","val","_setupCheckbox","toString","toUpperCase","_setupPassword","_setupSelect","items","remove","item","t","v","isString","option","createElement","text","add","serverType"],"mappings":"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"}