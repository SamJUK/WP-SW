// Service Worker Logic
(function(){
    /* BEDSW--IF{isDisabled} */
    // IF THE SERVICE WORKER IS DISABLED RETURN EARLY
    // WE CANT JUST REMOVE THE CALL FROM THE HTML SINCE
    // THE SERVICE WORKER HAS THE ABILITY TO CACHE THE HTML
    // FOR OFFLINE USAGE / BANDWIDTH SAVING REASONS
    return false;
    /* BEDSW--ENDIF{isDisabled} */


    var FILESTOCACHE = /* BEDSW--VAR{filesToCache} */;

    var dataCacheName = /* BEDSW--VAR{cacheName} */;
    var cacheName = dataCacheName;
})();