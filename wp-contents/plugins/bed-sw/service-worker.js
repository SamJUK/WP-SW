// Service Worker Logic
(function(){
    
    // IF THE SERVICE WORKER IS DISABLED RETURN EARLY
    // WE CANT JUST REMOVE THE CALL FROM THE HTML SINCE
    // THE SERVICE WORKER HAS THE ABILITY TO CACHE THE HTML
    // FOR OFFLINE USAGE / BANDWIDTH SAVING REASONS
    return false;
    


    var FILESTOCACHE = ["\/a-homepage-section\/","\/about\/","\/asd\/","\/blog\/","\/contact\/","\/","\/sample-page\/","\/?post_type=post&p=1"];

    var dataCacheName = "my-site-v3";
    var cacheName = dataCacheName;
})();