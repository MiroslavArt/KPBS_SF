{"version":3,"sources":["script.js"],"names":["BX","namespace","Socialnetwork","User","Profile","arParams","this","ajaxPath","siteId","languageId","otpDays","showOtpPopup","otpRecoveryCodes","profileUrl","passwordsUrl","popupHint","codesUrl","init","prototype","buttons","push","PopupWindowButton","text","message","className","events","click","proxy","location","href","PopupWindowButtonLink","PopupWindowManager","create","autoHide","offsetLeft","offsetTop","overlay","draggable","restrict","closeByEsc","content","show","ready","delegate","initHint","confirm","changeUserActivity","userId","userActive","parseInt","ajax","url","method","dataType","data","user_id","active","sessid","bitrix_sessid","site_id","json","onsuccess","result","window","reload","DeleteErrorPopup","error","showExtranet2IntranetForm","email","Bitrix24Extranet2IntranetForm","zIndex","titleBar","closeIcon","right","top","popup","form","submit","popupWindow","setContent","close","onAfterPopupShow","post","lang","USER_ID","IS_EMAIL","reinvite","isExtranet","bindObj","InviteAccessPopup","deactivateUserOtp","numDays","action","deferUserOtp","activateUserOtp","showOtpDaysPopup","bind","handler","self","daysObj","i","onclick","event","item","PopupMenu","showLink","btn","wrapper","parentNode","input","querySelector","link","inpWidth","linkWidth","style","width","addClass","offsetWidth","display","setTimeout","opacity","select","nodeId","node","setAttribute","id","proxy_context","getAttribute","showHint","hideHint","PopupWindow","lightShadow","darkMode","bindOptions","position","onPopupClose","destroy","attrs","html","setAngle","offset"],"mappings":"AAAAA,GAAGC,UAAU,yBAEbD,GAAGE,cAAcC,KAAKC,QAAU,WAE/B,IAAIA,EAAU,SAASC,GAEtBC,KAAKC,SAAW,GAChBD,KAAKE,OAAS,GACdF,KAAKG,WAAa,GAClBH,KAAKI,WACLJ,KAAKK,aAAe,MACpBL,KAAKM,iBAAmB,MACxBN,KAAKO,WAAa,GAClBP,KAAKQ,aAAe,GACpBR,KAAKS,aAEL,UAAWV,IAAa,SACxB,CACCC,KAAKC,SAAWF,EAASE,SACzBD,KAAKE,OAASH,EAASG,OACvBF,KAAKG,WAAaJ,EAASI,WAC3BH,KAAKI,QAAUL,EAASK,QACxBJ,KAAKK,aAAeN,EAASM,cAAgB,IAAM,KAAO,MAC1DL,KAAKM,iBAAmBP,EAASO,kBAAoB,IAAM,KAAO,MAClEN,KAAKO,WAAaR,EAASQ,WAC3BP,KAAKQ,aAAeT,EAASS,aAC7BR,KAAKU,SAAWX,EAASW,SAG1BV,KAAKW,QAGNb,EAAQc,UAAUD,KAAO,WAExB,GAAIX,KAAKK,aACT,CACC,IAAIQ,KAEJ,GAAIb,KAAKM,iBACT,CACCO,EAAQC,KAAK,IAAIpB,GAAGqB,mBACnBC,KAAOtB,GAAGuB,QAAQ,mBAClBC,UAAY,6BACZC,QAAWC,MAAQ1B,GAAG2B,MAAM,WAE3BC,SAASC,KAAOvB,KAAKU,UACnBV,UAGLa,EAAQC,KAAK,IAAIpB,GAAGqB,mBAClBC,KAAOtB,GAAGuB,QAAQ,qCAClBC,UAAY,6BACZC,QAAWC,MAAQ1B,GAAG2B,MAAM,WAE3BC,SAASC,KAAOvB,KAAKQ,cACnBR,SAEJ,IAAIN,GAAG8B,uBACNR,KAAMtB,GAAGuB,QAAQ,iCACjBC,UAAW,kCACXC,QAAUC,MAAS1B,GAAG2B,MAAM,WAE3BC,SAASC,KAAOvB,KAAKO,YACnBP,UAILN,GAAG+B,mBAAmBC,OAAO,0BAA2B,MACvDC,SAAU,MACVC,WAAY,EACZC,UAAW,EACXC,QAAU,KACVC,WAAYC,SAAS,MACrBC,WAAY,MACZC,QAAS,2EAA6ExC,GAAGuB,QAAQ,iCAAmCjB,KAAKM,iBAAmBZ,GAAGuB,QAAQ,yCAA2C,IAAM,wJAA0JvB,GAAGuB,QAAQ,iCAAmC,eAChaJ,QAASA,IACPsB,OAGJzC,GAAG0C,MAAM1C,GAAG2C,SAAS,WACpBrC,KAAKsC,SAAS,4BACZtC,QAGJF,EAAQc,UAAU2B,QAAU,WAE3B,GAAIA,QAAQ7C,GAAGuB,QAAQ,yBACtB,OAAO,UAEP,OAAO,OAGTnB,EAAQc,UAAU4B,mBAAqB,SAASC,EAAQC,GAEvD,IAAK1C,KAAKuC,UACT,OAAO,MAER,IAAKI,SAASF,KAAYC,EACzB,OAAO,MAERhD,GAAGkD,MACFC,IAAK7C,KAAKC,SACV6C,OAAQ,OACRC,SAAU,OACVC,MACCC,QAASR,EACTS,OAASR,EACTS,OAAQzD,GAAG0D,gBACXC,QAASrD,KAAKE,OACdoD,KAAM,GAEPC,UAAW,SAAUD,GAEpB,GAAIA,EAAKE,QAAU,UACnB,CACCC,OAAOnC,SAASoC,aAGjB,CACC,IAAIC,EAAmBjE,GAAG+B,mBAAmBC,OAAO,eAAgB1B,MACnEkC,QAAS,MAAMoB,EAAKM,MAAM,OAC1BhC,WAAW,GACXC,UAAU,EACVF,SAAS,OAGVgC,EAAiBxB,YAMrBrC,EAAQc,UAAUiD,0BAA4B,SAASpB,EAAQqB,GAE9D,IAAIA,EAAQA,EAAQ,KAAO,MAE3BL,OAAOM,8BAAgCrE,GAAG+B,mBAAmBC,OAAO,sBAAuB,MAC1FC,SAAU,MACVqC,OAAQ,EACRpC,WAAY,EACZC,UAAW,EACXC,QAAU,KACVC,WAAYC,SAAS,MACrBC,WAAY,KACZgC,SAAUvE,GAAGuB,QAAQ6C,EAAQ,mBAAqB,cAClDI,WAAaC,MAAQ,OAAQC,IAAM,QACnCvD,SACC,IAAInB,GAAGqB,mBACNC,KAAOtB,GAAGuB,QAAQ,eAClBC,UAAY,6BACZC,QAAWC,MAAQ,WAElB,IAAIiD,EAAQrE,KACZ,IAAIsE,EAAO5E,GAAG,0BAEd,GAAG4E,EACF5E,GAAGkD,KAAK2B,OAAOD,EAAM5E,GAAG2C,SAAS,SAASmB,GACzCa,EAAMG,YAAYC,WAAWjB,UAOjC,IAAI9D,GAAG8B,uBACNR,KAAMtB,GAAGuB,QAAQ,qBACjBC,UAAW,kCACXC,QAAUC,MAAQ,WAEjBpB,KAAKwE,YAAYE,aAIpBxC,QAAS,+CACTf,QACCwD,iBAAkB,WAEjB3E,KAAKyE,WAAW,yCAAyC/E,GAAGuB,QAAQ,gBAAgB,UACpFvB,GAAGkD,KAAKgC,KACP,2CAECC,KAAMnF,GAAGuB,QAAQ,eACjBoC,QAAS3D,GAAGuB,QAAQ,YAAc,GAClC6D,QAASrC,EACTsC,SAAUjB,EAAQ,IAAM,KAEzBpE,GAAG2C,SAAS,SAASmB,GAEnBxD,KAAKyE,WAAWjB,IAEjBxD,WAML+D,8BAA8B5B,QAG/BrC,EAAQc,UAAUoE,SAAW,SAASvC,EAAQwC,EAAYC,GAEzD,IAAKvC,SAASF,GACb,OAAO,MAERyC,EAAUA,GAAW,KAErB,IAAIF,EAAW,qBAAuBC,GAAc,IAAM,YAAc,IAAMxC,EAE9E/C,GAAGkD,KAAKgC,KACP,4CAECC,KAAM7E,KAAKG,WACXkD,QAASrD,KAAKE,OACd8E,SAAUA,EACV7B,OAAQzD,GAAG0D,iBAEZ1D,GAAG2C,SAAS,SAASmB,GAEpB,IAAI2B,EAAoBzF,GAAG+B,mBAAmBC,OAAO,gBAAiBwD,GACrEhD,QAAS,MAAMxC,GAAGuB,QAAQ,yBAAyB,OACnDW,WAAW,GACXC,UAAU,EACVF,SAAS,OAGVwD,EAAkBhD,QAChBnC,QAKLF,EAAQc,UAAUwE,kBAAoB,SAAS3C,EAAQ4C,GAEtD,IAAK1C,SAASF,GACb,OAAO,MAER/C,GAAGkD,MACFE,OAAQ,OACRC,SAAU,OACVF,IAAK7C,KAAKC,SACV+C,MAECP,OAAQA,EACRU,OAAQzD,GAAG0D,gBACXiC,QAASA,EACTC,OAAQ,cAET/B,UAAW,SAASD,GAEnB,GAAIA,EAAKM,MACT,MAIA,CACCtC,SAASoC,cAMb5D,EAAQc,UAAU2E,aAAe,SAAS9C,EAAQ4C,GAEjD,IAAK1C,SAASF,GACb,OAAO,MAER/C,GAAGkD,MACFE,OAAQ,OACRC,SAAU,OACVF,IAAK7C,KAAKC,SACV+C,MAECP,OAAQA,EACRU,OAAQzD,GAAG0D,gBACXiC,QAASA,EACTC,OAAQ,SAET/B,UAAW,SAASD,GAEnB,GAAIA,EAAKM,MACT,MAIA,CACCtC,SAASoC,cAMb5D,EAAQc,UAAU4E,gBAAkB,SAAS/C,GAE5C,IAAKE,SAASF,GACb,OAAO,MAER/C,GAAGkD,MACFE,OAAQ,OACRC,SAAU,OACVF,IAAK7C,KAAKC,SACV+C,MAECP,OAAQA,EACRU,OAAQzD,GAAG0D,gBACXkC,OAAQ,YAET/B,UAAW,SAASD,GAEnB,GAAIA,EAAKM,MACT,MAIA,CACCtC,SAASoC,cAMb5D,EAAQc,UAAU6E,iBAAmB,SAASC,EAAMjD,EAAQkD,GAE3D,IAAKhD,SAASF,GACb,OAAO,MAERkD,EAAWA,GAAW,QAAW,QAAU,aAC3C,IAAIC,EAAO5F,KAEX,IAAI6F,KACJ,IAAK,IAAIC,KAAK9F,KAAKI,QACnB,CACCyF,EAAQ/E,MACPE,KAAMhB,KAAKI,QAAQ0F,GACnBT,QAASS,EACTC,QAAS,SAASC,EAAOC,GAExBjG,KAAKwE,YAAYE,QAEjB,GAAIiB,GAAW,aACdC,EAAKR,kBAAkB3C,EAAQwD,EAAKZ,cAEpCO,EAAKL,aAAa9C,EAAQwD,EAAKZ,YAKnC3F,GAAGwG,UAAU/D,KAAK,uBAAwBuD,EAAMG,GAC3ChE,UAAU,GACbD,WAAW,KAKd9B,EAAQc,UAAUuF,SAAW,SAASC,GAErC,IAAIC,EAAUD,EAAIE,WAClB,IAAIC,EAAQF,EAAQG,cAAc,gBAClC,IAAIC,EAAOJ,EAAQG,cAAc,eACjC,IAAIE,EAAUC,EAEdJ,EAAMK,MAAMC,MAAQ,OACpBnH,GAAGoH,SAAST,EAAS,2BACrBK,EAAWH,EAAMQ,YACjBJ,EAAYF,EAAKM,YACjBX,EAAIQ,MAAMI,QAAU,OAEpBC,WAAW,WAEVR,EAAKG,MAAMI,QAAU,OACrBT,EAAMK,MAAMC,MAAQF,EAAY,MAC9B,IAEHM,WAAW,WAEVV,EAAMK,MAAMM,QAAU,EACtBX,EAAMK,MAAMC,MAAQH,EAAW,MAC7B,KAEHhH,GAAGgG,KAAKa,EAAO,gBAAiB,WAE/BA,EAAMY,YAIRrH,EAAQc,UAAU0B,SAAW,SAAS8E,GAErC,IAAIC,EAAO3H,GAAG0H,GACd,GAAIC,EACJ,CACCA,EAAKC,aAAa,UAAWD,GAC7B3H,GAAGgG,KAAK2B,EAAM,YAAa3H,GAAG2B,MAAM,WACnC,IAAIkG,EAAK7H,GAAG8H,cAAcC,aAAa,WACvC,IAAIzG,EAAOtB,GAAG8H,cAAcC,aAAa,aACzCzH,KAAK0H,SAASH,EAAI7H,GAAG8H,cAAexG,IAClChB,OACHN,GAAGgG,KAAK2B,EAAM,WAAa3H,GAAG2B,MAAM,WACnC,IAAIkG,EAAK7H,GAAG8H,cAAcC,aAAa,WACvCzH,KAAK2H,SAASJ,IACZvH,SAILF,EAAQc,UAAU8G,SAAW,SAASH,EAAI7B,EAAM1E,GAE/C,GAAIhB,KAAKS,UAAU8G,GACnB,CACCvH,KAAKS,UAAU8G,GAAI7C,QAGpB1E,KAAKS,UAAU8G,GAAM,IAAI7H,GAAGkI,YAAY,0BAA2BlC,GAClEmC,YAAa,KACblG,SAAU,MACVmG,SAAU,KACVlG,WAAY,EACZC,UAAW,EACXkG,aAAcC,SAAU,OACxBhE,OAAQ,IACR7C,QACC8G,aAAe,WAAYjI,KAAKkI,YAEjChG,QAAUxC,GAAGgC,OAAO,OAASyG,OAAUvB,MAAQ,qCAAuCwB,KAAMpH,MAE7FhB,KAAKS,UAAU8G,GAAIc,UAAUC,OAAO,GAAIN,SAAU,WAClDhI,KAAKS,UAAU8G,GAAIpF,OAEnB,OAAO,MAGRrC,EAAQc,UAAU+G,SAAW,SAASJ,GAErCvH,KAAKS,UAAU8G,GAAI7C,QACnB1E,KAAKS,UAAU8G,GAAM,MAGtB,OAAOzH,EAhbwB","file":"script.map.js"}