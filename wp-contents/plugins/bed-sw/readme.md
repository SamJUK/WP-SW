# BED-SW

#### Service Worker Template
The service worker template is found in the plugin's root folder under `${root}/build/sw-template.js`
This file is used as a template to generate `${root/service-worker.js}`

**If statements**
If you want to write a if statement based on a php variable during compilation (e.g `isServiceWorkerEnabled`)
You can write it as below; Where MY_EXPOSED_VARIABLE_IS_TRUE is a variable that is exposed in the `fetchTemplateData` 
method of the build script.

Example
```javascript
    /* BEDSW--IF{MY_EXPOSED_VARIABLE_IS_TRUE} */
    
    // My code goes here
    ...
    
    /* BEDSW--ENDIF{MY_EXPOSED_VARIABLE_IS_TRUE} */
```


**Variable Substitution**
Dynamic php values in the js file during compilation is like so, where cacheName is a variable exposed in the `fetchTemplateData` 
method of the build script. 

Example
```javascript
var dataCacheName = /* BEDSW--VAR{cacheName} */;
```