"use strict";

//.remove polyfill
Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}
// classlist polyfill
/*! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js */
"document"in self&&("classList"in document.createElement("_")&&(!document.createElementNS||"classList"in document.createElementNS("http://www.w3.org/2000/svg","g"))||!function(t){"use strict";if("Element"in t){var e="classList",n="prototype",i=t.Element[n],s=Object,r=String[n].trim||function(){return this.replace(/^\s+|\s+$/g,"")},o=Array[n].indexOf||function(t){for(var e=0,n=this.length;n>e;e++)if(e in this&&this[e]===t)return e;return-1},c=function(t,e){this.name=t,this.code=DOMException[t],this.message=e},a=function(t,e){if(""===e)throw new c("SYNTAX_ERR","The token must not be empty.");if(/\s/.test(e))throw new c("INVALID_CHARACTER_ERR","The token must not contain space characters.");return o.call(t,e)},l=function(t){for(var e=r.call(t.getAttribute("class")||""),n=e?e.split(/\s+/):[],i=0,s=n.length;s>i;i++)this.push(n[i]);this._updateClassName=function(){t.setAttribute("class",this.toString())}},u=l[n]=[],h=function(){return new l(this)};if(c[n]=Error[n],u.item=function(t){return this[t]||null},u.contains=function(t){return~a(this,t+"")},u.add=function(){var t,e=arguments,n=0,i=e.length,s=!1;do t=e[n]+"",~a(this,t)||(this.push(t),s=!0);while(++n<i);s&&this._updateClassName()},u.remove=function(){var t,e,n=arguments,i=0,s=n.length,r=!1;do for(t=n[i]+"",e=a(this,t);~e;)this.splice(e,1),r=!0,e=a(this,t);while(++i<s);r&&this._updateClassName()},u.toggle=function(t,e){var n=this.contains(t),i=n?e!==!0&&"remove":e!==!1&&"add";return i&&this[i](t),e===!0||e===!1?e:!n},u.replace=function(t,e){var n=a(t+"");~n&&(this.splice(n,1,e),this._updateClassName())},u.toString=function(){return this.join(" ")},s.defineProperty){var f={get:h,enumerable:!0,configurable:!0};try{s.defineProperty(i,e,f)}catch(p){void 0!==p.number&&-2146823252!==p.number||(f.enumerable=!1,s.defineProperty(i,e,f))}}else s[n].__defineGetter__&&i.__defineGetter__(e,h)}}(self),function(){"use strict";var t=document.createElement("_");if(t.classList.add("c1","c2"),!t.classList.contains("c2")){var e=function(t){var e=DOMTokenList.prototype[t];DOMTokenList.prototype[t]=function(t){var n,i=arguments.length;for(n=0;i>n;n++)t=arguments[n],e.call(this,t)}};e("add"),e("remove")}if(t.classList.toggle("c3",!1),t.classList.contains("c3")){var n=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(t,e){return 1 in arguments&&!this.contains(t)==!e?e:n.call(this,t)}}"replace"in document.createElement("_").classList||(DOMTokenList.prototype.replace=function(t,e){var n=this.toString().split(" "),i=n.indexOf(t+"");~i&&(n=n.slice(i),this.remove.apply(this,n),this.add(e),this.add.apply(this,n.slice(1)))}),t=null}());

//prmise polyfill
!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?n():"function"==typeof define&&define.amd?define(n):n()}(0,function(){"use strict";function e(e){var n=this.constructor;return this.then(function(t){return n.resolve(e()).then(function(){return t})},function(t){return n.resolve(e()).then(function(){return n.reject(t)})})}function n(){}function t(e){if(!(this instanceof t))throw new TypeError("Promises must be constructed via new");if("function"!=typeof e)throw new TypeError("not a function");this._state=0,this._handled=!1,this._value=undefined,this._deferreds=[],u(e,this)}function o(e,n){for(;3===e._state;)e=e._value;0!==e._state?(e._handled=!0,t._immediateFn(function(){var t=1===e._state?n.onFulfilled:n.onRejected;if(null!==t){var o;try{o=t(e._value)}catch(f){return void i(n.promise,f)}r(n.promise,o)}else(1===e._state?r:i)(n.promise,e._value)})):e._deferreds.push(n)}function r(e,n){try{if(n===e)throw new TypeError("A promise cannot be resolved with itself.");if(n&&("object"==typeof n||"function"==typeof n)){var o=n.then;if(n instanceof t)return e._state=3,e._value=n,void f(e);if("function"==typeof o)return void u(function(e,n){return function(){e.apply(n,arguments)}}(o,n),e)}e._state=1,e._value=n,f(e)}catch(r){i(e,r)}}function i(e,n){e._state=2,e._value=n,f(e)}function f(e){2===e._state&&0===e._deferreds.length&&t._immediateFn(function(){e._handled||t._unhandledRejectionFn(e._value)});for(var n=0,r=e._deferreds.length;r>n;n++)o(e,e._deferreds[n]);e._deferreds=null}function u(e,n){var t=!1;try{e(function(e){t||(t=!0,r(n,e))},function(e){t||(t=!0,i(n,e))})}catch(o){if(t)return;t=!0,i(n,o)}}var c=setTimeout;t.prototype["catch"]=function(e){return this.then(null,e)},t.prototype.then=function(e,t){var r=new this.constructor(n);return o(this,new function(e,n,t){this.onFulfilled="function"==typeof e?e:null,this.onRejected="function"==typeof n?n:null,this.promise=t}(e,t,r)),r},t.prototype["finally"]=e,t.all=function(e){return new t(function(n,t){function o(e,f){try{if(f&&("object"==typeof f||"function"==typeof f)){var u=f.then;if("function"==typeof u)return void u.call(f,function(n){o(e,n)},t)}r[e]=f,0==--i&&n(r)}catch(c){t(c)}}if(!e||"undefined"==typeof e.length)throw new TypeError("Promise.all accepts an array");var r=Array.prototype.slice.call(e);if(0===r.length)return n([]);for(var i=r.length,f=0;r.length>f;f++)o(f,r[f])})},t.resolve=function(e){return e&&"object"==typeof e&&e.constructor===t?e:new t(function(n){n(e)})},t.reject=function(e){return new t(function(n,t){t(e)})},t.race=function(e){return new t(function(n,t){for(var o=0,r=e.length;r>o;o++)e[o].then(n,t)})},t._immediateFn="function"==typeof setImmediate&&function(e){setImmediate(e)}||function(e){c(e,0)},t._unhandledRejectionFn=function(e){void 0!==console&&console&&console.warn("Possible Unhandled Promise Rejection:",e)};var l=function(){if("undefined"!=typeof self)return self;if("undefined"!=typeof window)return window;if("undefined"!=typeof global)return global;throw Error("unable to locate global object")}();"Promise"in l?l.Promise.prototype["finally"]||(l.Promise.prototype["finally"]=e):l.Promise=t});

//fetch library
!function(t){"use strict";if(!t.fetch){var e={searchParams:"URLSearchParams"in t,iterable:"Symbol"in t&&"iterator"in Symbol,blob:"FileReader"in t&&"Blob"in t&&function(){try{return new Blob,!0}catch(t){return!1}}(),formData:"FormData"in t,arrayBuffer:"ArrayBuffer"in t};if(e.arrayBuffer)var r=["[object Int8Array]","[object Uint8Array]","[object Uint8ClampedArray]","[object Int16Array]","[object Uint16Array]","[object Int32Array]","[object Uint32Array]","[object Float32Array]","[object Float64Array]"],o=function(t){return t&&DataView.prototype.isPrototypeOf(t)},n=ArrayBuffer.isView||function(t){return t&&r.indexOf(Object.prototype.toString.call(t))>-1};f.prototype.append=function(t,e){t=a(t),e=h(e);var r=this.map[t];this.map[t]=r?r+","+e:e},f.prototype.delete=function(t){delete this.map[a(t)]},f.prototype.get=function(t){return t=a(t),this.has(t)?this.map[t]:null},f.prototype.has=function(t){return this.map.hasOwnProperty(a(t))},f.prototype.set=function(t,e){this.map[a(t)]=h(e)},f.prototype.forEach=function(t,e){for(var r in this.map)this.map.hasOwnProperty(r)&&t.call(e,this.map[r],r,this)},f.prototype.keys=function(){var t=[];return this.forEach(function(e,r){t.push(r)}),u(t)},f.prototype.values=function(){var t=[];return this.forEach(function(e){t.push(e)}),u(t)},f.prototype.entries=function(){var t=[];return this.forEach(function(e,r){t.push([r,e])}),u(t)},e.iterable&&(f.prototype[Symbol.iterator]=f.prototype.entries);var i=["DELETE","GET","HEAD","OPTIONS","POST","PUT"];b.prototype.clone=function(){return new b(this,{body:this._bodyInit})},c.call(b.prototype),c.call(w.prototype),w.prototype.clone=function(){return new w(this._bodyInit,{status:this.status,statusText:this.statusText,headers:new f(this.headers),url:this.url})},w.error=function(){var t=new w(null,{status:0,statusText:""});return t.type="error",t};var s=[301,302,303,307,308];w.redirect=function(t,e){if(-1===s.indexOf(e))throw new RangeError("Invalid status code");return new w(null,{status:e,headers:{location:t}})},t.Headers=f,t.Request=b,t.Response=w,t.fetch=function(t,r){return new Promise(function(o,n){var i=new b(t,r),s=new XMLHttpRequest;s.onload=function(){var t,e,r={status:s.status,statusText:s.statusText,headers:(t=s.getAllResponseHeaders()||"",e=new f,t.replace(/\r?\n[\t ]+/g," ").split(/\r?\n/).forEach(function(t){var r=t.split(":"),o=r.shift().trim();if(o){var n=r.join(":").trim();e.append(o,n)}}),e)};r.url="responseURL"in s?s.responseURL:r.headers.get("X-Request-URL");var n="response"in s?s.response:s.responseText;o(new w(n,r))},s.onerror=function(){n(new TypeError("Network request failed"))},s.ontimeout=function(){n(new TypeError("Network request failed"))},s.open(i.method,i.url,!0),"include"===i.credentials?s.withCredentials=!0:"omit"===i.credentials&&(s.withCredentials=!1),"responseType"in s&&e.blob&&(s.responseType="blob"),i.headers.forEach(function(t,e){s.setRequestHeader(e,t)}),s.send(void 0===i._bodyInit?null:i._bodyInit)})},t.fetch.polyfill=!0}function a(t){if("string"!=typeof t&&(t=String(t)),/[^a-z0-9\-#$%&'*+.\^_`|~]/i.test(t))throw new TypeError("Invalid character in header field name");return t.toLowerCase()}function h(t){return"string"!=typeof t&&(t=String(t)),t}function u(t){var r={next:function(){var e=t.shift();return{done:void 0===e,value:e}}};return e.iterable&&(r[Symbol.iterator]=function(){return r}),r}function f(t){this.map={},t instanceof f?t.forEach(function(t,e){this.append(e,t)},this):Array.isArray(t)?t.forEach(function(t){this.append(t[0],t[1])},this):t&&Object.getOwnPropertyNames(t).forEach(function(e){this.append(e,t[e])},this)}function d(t){if(t.bodyUsed)return Promise.reject(new TypeError("Already read"));t.bodyUsed=!0}function y(t){return new Promise(function(e,r){t.onload=function(){e(t.result)},t.onerror=function(){r(t.error)}})}function l(t){var e=new FileReader,r=y(e);return e.readAsArrayBuffer(t),r}function p(t){if(t.slice)return t.slice(0);var e=new Uint8Array(t.byteLength);return e.set(new Uint8Array(t)),e.buffer}function c(){return this.bodyUsed=!1,this._initBody=function(t){if(this._bodyInit=t,t)if("string"==typeof t)this._bodyText=t;else if(e.blob&&Blob.prototype.isPrototypeOf(t))this._bodyBlob=t;else if(e.formData&&FormData.prototype.isPrototypeOf(t))this._bodyFormData=t;else if(e.searchParams&&URLSearchParams.prototype.isPrototypeOf(t))this._bodyText=t.toString();else if(e.arrayBuffer&&e.blob&&o(t))this._bodyArrayBuffer=p(t.buffer),this._bodyInit=new Blob([this._bodyArrayBuffer]);else{if(!e.arrayBuffer||!ArrayBuffer.prototype.isPrototypeOf(t)&&!n(t))throw new Error("unsupported BodyInit type");this._bodyArrayBuffer=p(t)}else this._bodyText="";this.headers.get("content-type")||("string"==typeof t?this.headers.set("content-type","text/plain;charset=UTF-8"):this._bodyBlob&&this._bodyBlob.type?this.headers.set("content-type",this._bodyBlob.type):e.searchParams&&URLSearchParams.prototype.isPrototypeOf(t)&&this.headers.set("content-type","application/x-www-form-urlencoded;charset=UTF-8"))},e.blob&&(this.blob=function(){var t=d(this);if(t)return t;if(this._bodyBlob)return Promise.resolve(this._bodyBlob);if(this._bodyArrayBuffer)return Promise.resolve(new Blob([this._bodyArrayBuffer]));if(this._bodyFormData)throw new Error("could not read FormData body as blob");return Promise.resolve(new Blob([this._bodyText]))},this.arrayBuffer=function(){return this._bodyArrayBuffer?d(this)||Promise.resolve(this._bodyArrayBuffer):this.blob().then(l)}),this.text=function(){var t,e,r,o=d(this);if(o)return o;if(this._bodyBlob)return t=this._bodyBlob,e=new FileReader,r=y(e),e.readAsText(t),r;if(this._bodyArrayBuffer)return Promise.resolve(function(t){for(var e=new Uint8Array(t),r=new Array(e.length),o=0;o<e.length;o++)r[o]=String.fromCharCode(e[o]);return r.join("")}(this._bodyArrayBuffer));if(this._bodyFormData)throw new Error("could not read FormData body as text");return Promise.resolve(this._bodyText)},e.formData&&(this.formData=function(){return this.text().then(m)}),this.json=function(){return this.text().then(JSON.parse)},this}function b(t,e){var r,o,n=(e=e||{}).body;if(t instanceof b){if(t.bodyUsed)throw new TypeError("Already read");this.url=t.url,this.credentials=t.credentials,e.headers||(this.headers=new f(t.headers)),this.method=t.method,this.mode=t.mode,n||null==t._bodyInit||(n=t._bodyInit,t.bodyUsed=!0)}else this.url=String(t);if(this.credentials=e.credentials||this.credentials||"omit",!e.headers&&this.headers||(this.headers=new f(e.headers)),this.method=(r=e.method||this.method||"GET",o=r.toUpperCase(),i.indexOf(o)>-1?o:r),this.mode=e.mode||this.mode||null,this.referrer=null,("GET"===this.method||"HEAD"===this.method)&&n)throw new TypeError("Body not allowed for GET or HEAD requests");this._initBody(n)}function m(t){var e=new FormData;return t.trim().split("&").forEach(function(t){if(t){var r=t.split("="),o=r.shift().replace(/\+/g," "),n=r.join("=").replace(/\+/g," ");e.append(decodeURIComponent(o),decodeURIComponent(n))}}),e}function w(t,e){e||(e={}),this.type="default",this.status=void 0===e.status?200:e.status,this.ok=this.status>=200&&this.status<300,this.statusText="statusText"in e?e.statusText:"OK",this.headers=new f(e.headers),this.url=e.url||"",this._initBody(t)}}("undefined"!=typeof self?self:this);

// Base64 encoding
!function(e,t){"function"==typeof define&&define.amd?define([],function(){t(e)}):t(e)}("undefined"!=typeof exports?exports:typeof window!=="undefined"?window:typeof self!=="undefined"?self:this,function(e){var t="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",n=/^(?:[A-Za-z\d+\/]{4})*?(?:[A-Za-z\d+\/]{2}(?:==)?|[A-Za-z\d+\/]{3}=?)?$/;e.__Base64__=Object.freeze(Object.create(null,{encode:{value:function(e){return function(e){for(var n,r,o,c,i="",a=0,d=(e=String(e)).length%3;a<e.length;){if((r=e.charCodeAt(a++))>255||(o=e.charCodeAt(a++))>255||(c=e.charCodeAt(a++))>255)throw new TypeError("Failed to execute 'btoa' on 'Window': The string to be encoded contains characters outside of the Latin1 range.");i+=t.charAt((n=r<<16|o<<8|c)>>18&63)+t.charAt(n>>12&63)+t.charAt(n>>6&63)+t.charAt(63&n)}return d?i.slice(0,d-3)+"===".substring(d):i}(encodeURIComponent(e).replace(/%([0-9A-F]{2})/g,function(e,t){return String.fromCharCode("0x"+t)}))}},decode:{value:function(e){return decodeURIComponent(escape(function(e){if(e=String(e).replace(/[\t\n\f\r ]+/g,""),!n.test(e))throw new TypeError("Failed to execute 'atob' on 'Window': The string to be decoded is not correctly encoded.");e+="==".slice(2-(3&e.length));for(var r,o,c,i="",a=0;a<e.length;)r=t.indexOf(e.charAt(a++))<<18|t.indexOf(e.charAt(a++))<<12|(o=t.indexOf(e.charAt(a++)))<<6|(c=t.indexOf(e.charAt(a++))),i+=64===o?String.fromCharCode(r>>16&255):64===c?String.fromCharCode(r>>16&255,r>>8&255):String.fromCharCode(r>>16&255,r>>8&255,255&r);return i}(e)))}}}))});

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };



//'use strict';
(function(window) {
    var globalConfigData;
    var globalChargeData;
    var globalMeta;
    var globalSubaccounts;
    var globalTheme;
    var globalBillingDetails;
    var globalClosePopup;
    var globalButtonClicked;
    var globalIsHostedPage;
    var afterCallbackRedirectTimeout;
    var modaliframe;
    var API_URL;
    var localData;
    var loadState = 'none';
    var iframeAlreadyShown = false;
    var hideIframe = function (){};
    var deferredShowIframe = function (){};
    var showSpinner = function (){};
    var modalframesource = ''
    var originsource = ''
    var readyToReceive = false;
    var latestPublicKey = null;
    var publicKeyUpgradesMap = {};
    var publicKeyHandlersMap = {};
    var API_BASE_URL = 'https://api.ravepay.co';
    var V2_BASE_URL = 'https://checkout.flutterwave.com';
    var V3_BASE_URL = 'https://checkout-v3-ui-prod.f4b-flutterwave.com';

    var w = window;

    function initiateUpgradeRequirementCheck(config) {
        return new Promise(function _shouldUpgrade(resolve) {
            var merchantKey;

            try {
                if (config.PBFPubKey) {
                    latestPublicKey = merchantKey = config.PBFPubKey;

                    if (
                        !(merchantKey in publicKeyUpgradesMap) ||
                        publicKeyUpgradesMap[merchantKey] === null
                    ) {
                        publicKeyUpgradesMap[merchantKey] = fetch(API_BASE_URL + '/v2/checkout/upgrade', {
                            method: 'POST',
                            headers: {'Content-Type': 'application/json'},
                            body: JSON.stringify({ public_key: merchantKey })
                        }).then(function _readResponse(response) {
                            return response.json();
                        }).then(function _getUpgradeRequirement(response) {
                            publicKeyUpgradesMap[merchantKey] = [
                                !!response.data.upgrade
                            ];

                            try {
                                publicKeyUpgradesMap[merchantKey].push(
                                    new URL(response.data.custom).origin
                                );
                            } catch (e) {}

                            return publicKeyUpgradesMap[merchantKey];
                        }).catch(function _handleErrors() {
                            return publicKeyUpgradesMap[merchantKey] = null;
                        }).then(resolve);
                    } else {
                        resolve(publicKeyUpgradesMap[merchantKey])
                    }

                    return;
                }
            } catch (e) {}

            resolve();
        });
    }

    function getIframeDomain() {
        var url = [].concat(publicKeyUpgradesMap[latestPublicKey]);
        return url[1] || (url[0] === true ? V3_BASE_URL : V2_BASE_URL);
    }

    function closePopup(fromCloseMethod, cancelled) {
        try {
            w.removeEventListener(
                "message",
                publicKeyHandlersMap[latestPublicKey]
            );

            publicKeyHandlersMap[latestPublicKey] = null;
        } catch (e) {}

        readyToReceive = false;

        if (fromCloseMethod === false && globalConfigData && globalConfigData.onclose) {
            globalConfigData.onclose(cancelled === true);
        }

        hideIframe();
        hideSpinner();
    }

    globalClosePopup = closePopup;

    //message handlers
    var message_handlers = {};

    message_handlers.txfailed = function (d) {
        readyToReceive = false;

        setTimeout(function() {
            hideIframe();
            if (globalConfigData && globalConfigData.onTransactionFailed) {
                globalConfigData.onTransactionFailed(d.data);
            }
        }, 15 * 1000);
    };

    message_handlers.cannotloadiframe = function (d) {
        readyToReceive = false;
        var data = JSON.parse(JSON.stringify(globalChargeData));
        document.location = modalframesource.src + generateQueryString(data) || document.location;
    };

    message_handlers.readytorecieve = function(d) {
        readyToReceive = true;
        originsource = d.origin
        d.source.postMessage(
            {
                name: "updategotten",
                meta: globalMeta,
                subaccounts: globalSubaccounts,
                theme: globalTheme,
                billing: globalBillingDetails,
                applepay: (function canDoApplePay() {
                    try {
                        return (
                            "ApplePaySession" in window &&
                            window.ApplePaySession.canMakePayments() === true
                        )
                    } catch (e) { return false }
                })()
            },
            d.origin
        );
    };

    message_handlers.switch_hosted_pay = function (d) {
        window.open(d.data.link, '_blank');
    };

    var loadtimeout_settimeouthandler;

    function handleLoadTimeout(timeout_callback, wait) {
        loadtimeout_settimeouthandler = setTimeout(function () {
            closePopup();
            try {
                timeout_callback();
            } catch (e) {}
        }, wait);
    }

    message_handlers.allcontentloaded = function(d) {
        //clearTimeout for waiting
        clearTimeout(loadtimeout_settimeouthandler);
        loadState = "loaded";
        if(!iframeAlreadyShown){
            deferredShowIframe();
        }

        d.source.postMessage(
            {
                name: "clickreport",
                time: globalButtonClicked
            },
            d.origin
        );

        //document.body.removeChild( document.getElementsByClassName('spinner-container')[0]);

        hideSpinner();

        if (globalConfigData && globalConfigData.onopen) {
            globalConfigData.onopen();
        }

        function icheckNext(err, msg) {
            d.source.postMessage(
                {
                    name: "icheckcomplete",
                    check_error: err,
                    check_error_message: msg
                },
                d.origin
            );
        }
        if (globalConfigData && globalConfigData.onintegritycheck) {
            globalConfigData.onintegritycheck(d.data.hash, icheckNext);
        } else {
            icheckNext();
        }
    };

    message_handlers.charge_complete = function (d) {
        readyToReceive = false;
        if (globalConfigData && globalConfigData.chargecomplete) {
            globalConfigData.chargecomplete(d.data.type, d.data.data);
        }
    };

    message_handlers.charge_init = function (d) {
        if (globalConfigData && globalConfigData.chargeinit) {
            globalConfigData.chargeinit(d.data.type, d.data.timestamp);
        }
    };

    message_handlers.opop = message_handlers.vbvcomplete = function(d) {
        readyToReceive = false;

        if (afterCallbackRedirectTimeout) {
            clearTimeout(afterCallbackRedirectTimeout);
        }

        if (globalConfigData && globalConfigData.callback){
            logCallbackEvent(d.data, true).finally(function() {
                globalConfigData.callback(d.data);
            });
        }
        // delay by at least a second
        // only redirect when we are not on a hosted page
        afterCallbackRedirectTimeout = setTimeout(function () {
            if (
                !globalIsHostedPage &&
                globalConfigData &&
                globalConfigData.redirect_url &&
                d.data.success
            ) {
                var method = +globalConfigData.redirect_post ? 'POST' : 'GET';

                if (method === 'GET' && +globalConfigData.redirect_no_json) {
                    logCallbackEvent(d.data, true).finally(function() {
                        window.location.href = globalConfigData.redirect_url;
                    });
                    return;
                }

                var $form = document.createElement('form');
                var $textarea = document.createElement('textarea');
                var hideStyle = 'position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;';

                $textarea.setAttribute('name', 'resp');
                $textarea.setAttribute('hidden', 'hidden');
                $textarea.setAttribute('readonly', 'readonly');
                $textarea.style = hideStyle;
                $textarea.value = JSON.stringify(d.data);

                $form.setAttribute('method', method);
                $form.setAttribute('action', globalConfigData.redirect_url);
                $form.setAttribute('hidden', 'hidden');
                $form.style = hideStyle;

                $form.appendChild($textarea);
                document.body.appendChild($form);

                logCallbackEvent(d.data, true).finally(function() {
                    $form.submit();
                });
            }
        }, 1000); // end set timeout
    }

    message_handlers.closeiframe = function(d) {
        closePopup(false, d.data.data.cancelled);
        if (window.top && window.top !== self) {
            window.top.postMessage({ name: 'closeiframe' }, '*');
        }
    };

    message_handlers.modalready = function(d) {
        if (window.top && window.top !== self) {
            window.top.postMessage({ name: 'modalready' }, '*');
        }

        document.body.style.overflow = "hidden";
        modalframesource.style.opacity = "1";
        modalframesource.style.pointerEvents = "";
        modalframesource.style.zIndex = "2147483647";
    };

    // message_handlers.modalready = function(d) {
    //     document.body.style.overflow = "hidden";
    //     modaliframe.style.opacity = "1";
    //     modaliframe.style.pointerEvents = "";
    //     modaliframe.style.zIndex = "2147483647";
    // };

    //document.addEventListener("DOMContentLoaded", function(event) {
    function generateQueryString(obj) {
        var str = [];
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                var v = obj[prop];
                v = encodeURIComponent(v);
                str.push(prop + "=" + v);
            }
        }
        return "__=" + __Base64__.encode(str.join("&"));
    }

    var showIframe;

    function hideSpinner() {
        if (showSpinner) {
            var spinner = document.getElementById('rve_spinner_container_0999');
            spinner && document.body.removeChild(spinner);
        }
    }

    function loadIframe (data, is_hide) {
        // show the spinner
        showSpinner = function () {
            var spinnerContainer = document.createElement("div");
            var spinner = document.createElement("div");
            spinnerContainer.setAttribute("class", "spinner-container");
            spinnerContainer.setAttribute("id", "rve_spinner_container_0999");
            spinner.setAttribute("class", "spinner");
            var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute("width", "40px");
            svg.setAttribute("height", "40px");
            svg.setAttribute("viewBox", "0 0 60 60");
            var path = document.createElementNS(
                "http://www.w3.org/2000/svg",
                "path"
            );
            path.style.fill = "#f5a623";
            path.style.fillRule = "evenodd";
            path.setAttribute(
                "d",
                "M59.972 26a37.616 37.616 0 0 0-.71-3.455 30.092 30.092 0 0 0-1.446-4.26 30.682 30.682 0 0 0-4.809-7.849 29.483 29.483 0 0 0-7.594-6.389A29.733 29.733 0 0 0 36.292.551C34.63.216 32.956.015 31.255.002a39.08 39.08 0 0 0-3.964.16 30.369 30.369 0 0 0-9.898 2.747 30.882 30.882 0 0 0-7.34 4.848A30.286 30.286 0 0 0 4.4 14.495C2.7 17.28 1.427 20.32.73 23.509c-.562 2.545-.83 5.17-.696 7.782.12 2.532.509 5.063 1.272 7.488a30.823 30.823 0 0 0 1.782 4.5 30.367 30.367 0 0 0 2.464 4.112 30.149 30.149 0 0 0 6.67 6.764 29.967 29.967 0 0 0 18.779 5.827 29.845 29.845 0 0 0 9.724-1.942 29.06 29.06 0 0 0 8.237-4.862c1.232-1.045 2.33-2.224 3.362-3.47 1.045-1.259 1.982-2.585 2.76-4.018a29.445 29.445 0 0 0 1.714-3.817c.24-.643.469-1.286.656-1.956.2-.71.348-1.446.482-2.17.201-1.138.281-2.317.174-3.469-.093.51-.174 1.005-.294 1.5a14.602 14.602 0 0 1-.55 1.688c-.428 1.165-.964 2.29-1.473 3.416a36.09 36.09 0 0 1-2.25 4.125 28.98 28.98 0 0 1-1.353 1.996c-.482.643-1.031 1.259-1.58 1.862a23.257 23.257 0 0 1-3.617 3.268 26.913 26.913 0 0 1-4.3 2.585c-3.026 1.473-6.335 2.357-9.683 2.652a27.72 27.72 0 0 1-10.22-1.018 27.424 27.424 0 0 1-8.72-4.393 27.441 27.441 0 0 1-6.455-6.939c-1.808-2.719-3.054-5.786-3.737-8.987a26.897 26.897 0 0 1-.402-2.532c-.08-.723-.147-1.46-.174-2.196a26.23 26.23 0 0 1 .281-4.581c.496-3.295 1.568-6.47 3.228-9.363a26.813 26.813 0 0 1 5.64-6.885 26.563 26.563 0 0 1 7.607-4.701 25.887 25.887 0 0 1 5.01-1.46 24.97 24.97 0 0 1 2.611-.362c.429-.04.844-.04 1.273-.08.174 0 .348.013.522.013 2.906-.053 5.826.322 8.599 1.192a25.15 25.15 0 0 1 8.237 4.42 25.798 25.798 0 0 1 6.295 7.475 27.988 27.988 0 0 1 2.934 7.795c.134.63.24 1.26.348 1.889a2.11 2.11 0 0 0 .91 1.433c1.045.696 2.505.228 3.014-.897.174-.389.228-.804.161-1.193z"
            );
            svg.appendChild(path);
            svg.classList.add("svg-spinner");
            spinner.appendChild(svg);
            spinnerContainer.appendChild(spinner);
            document.body.appendChild(spinnerContainer);

            var pageStyle = document.createElement("style");
            if (pageStyle) {
                pageStyle.appendChild(
                    document.createTextNode(
                        ".spinner-container{height:100%;width:100%;position:fixed;top:0;left:0;background-color:rgba(225,225,225,.95); z-index:9999999}.svg-spinner{-webkit-animation:spin 500ms infinite linear;animation:spin 500ms infinite linear}.spinner{margin-top:-20px; margin-left:-20px; position:fixed; top:50%; left:50%;}@-webkit-keyframes spin {from { -webkit-transform: rotate(0deg);}to { -webkit-transform: rotate(360deg); }}@keyframes spin{from {transform:rotate(0deg);}to {transform:rotate(360deg);}}"
                    )
                );
                document.getElementsByTagName("head")[0].appendChild(pageStyle);
            }
        };

        modalframesource = document.createElement('iframe');
        modalframesource.setAttribute('style', 'position:fixed;top:0;left:0;z-index:-1;border:none;opacity:0;pointer-events:none;width:100%;height:100%;');
        modalframesource.setAttribute('allowTransparency', 'true');
        modalframesource.setAttribute("width", "100%");
        modalframesource.setAttribute("height", "100%");
        modalframesource.setAttribute('name', 'checkout');

        if (!is_hide) {
            // modalframesource.setAttribute('width', '100%');
            // modalframesource.setAttribute('height', '100%');
            document.body.style.overflow = "";
            modalframesource.style.opacity = "1";
            modalframesource.style.pointerEvents = "";
            modalframesource.style.zIndex = "2147483647";
        }
        else {
            loadState = 'loading';
            // modalframesource.setAttribute('width', '0%');
            // modalframesource.setAttribute('height', '0%');
            modalframesource.style.opacity = "0";
            modalframesource.style.pointerEvents = "none";
            modalframesource.style.zIndex = "-1";

            showIframe = function (){
                iframeAlreadyShown = true;
                // modalframesource.setAttribute('width', '100%');
                // modalframesource.setAttribute('height', '100%');
                document.body.style.overflow = "hidden";
                modalframesource.style.opacity = "1";
                modalframesource.style.pointerEvents = "";
                modalframesource.style.zIndex = "2147483647";
            }

            hideIframe = function (){
                iframeAlreadyShown = false;
                modalframesource.style.opacity = "0";
                modalframesource.style.pointerEvents = "none";
                modalframesource.style.zIndex = "-1";
                document.body.style.overflow = "";
                initialize();
            }
        }

        //loadState

        modalframesource.setAttribute('id', 'flwpugpaidid');
        modalframesource.src = getIframeDomain() + '/?';

        if (document.body) {

            // If iframe already exists on the page, remove it from the body
            if (document.querySelector('#flwpugpaidid')) {
                document.querySelector('#flwpugpaidid').remove()
            }

            document.body.appendChild(modalframesource);
        }


    }

    function extractAttributes(element, attributes) {
        var obj = {};
        attributes.forEach(function(attrib) {
            var aa = element.getAttribute("data-" + attrib);
            if (aa) obj[attrib] = aa;
        });
        return obj;
    }

    function extractMetaInfo(element) {
        var attributes = element.attributes;
        var atrlen = attributes.length;
        var metas = [];
        for (var x = 0; x < atrlen; x++) {
            var attrib = attributes[x];
            if (attrib.name.match(/^data-meta-/)) {
                metas.push({
                    metaname: attrib.name.replace("data-meta-", ""),
                    metavalue: attrib.value
                });
            }
        }

        //=== Handle sideffects\\
        x = null;
        atrlen = null;
        //======================\\
        return metas;
    }

    function addQueryToIframe(data, callback) {
        modaliframe = document.getElementById("flwpugpaidid");

        if (data.loadtimeout) {
            handleLoadTimeout(data.onloadtimeout, data.loadtimeout);
        }

        globalConfigData = data;

        //this inadvertently strips all functions, the inner stringify that is. Accidental genius maybe?
        var _data = JSON.parse(JSON.stringify(data));

        delete _data.callback; //callback is not required as a query string to pass
        delete _data.onclose; //onclose is not required as a query string to pass
        delete _data.onpaymentinit;
        delete _data.onvalidateotpinit;
        delete _data.meta;
        delete _data.theme;
        delete _data.billing;

        //delete _data.onintegritycheck;

        _data.init_url = encodeURIComponent(window.location.href);


        // console.log(readyToReceive);

        if (window.location.href.includes(API_BASE_URL + '/flwv3-pug/getpaidx/api/hosted_pay/')) {
            modalframesource.src = modalframesource.src + generateQueryString(_data);
        }

        else if (data.hosted_payment || globalIsHostedPage === 1) {
            modalframesource.src = modalframesource.src + generateQueryString(_data);
        }
        else {

            var win = window.frames.checkout;
            var postmessagesource = getIframeDomain();

            if (!readyToReceive) {
                modalframesource = document.createElement('iframe');
                modalframesource.setAttribute('style', 'position:fixed;top:0;left:0;z-index:-1;border:none;opacity:0;pointer-events:none;width:100%;height:100%;');
                modalframesource.setAttribute('allowTransparency', 'true');
                modalframesource.setAttribute("width", "100%");
                modalframesource.setAttribute("height", "100%");
                modalframesource.setAttribute('name', 'checkout');
                modalframesource.style.opacity = "1";
                modalframesource.style.pointerEvents = "";
                modalframesource.style.zIndex = "2147483647";
                document.body.style.overflow = "hidden";


                modalframesource.src = getIframeDomain() + '/?' + generateQueryString(_data);

                // If iframe already exists on the page, remove it from the body
                if (document.querySelector('#flwpugpaidid')) {
                    document.querySelector('#flwpugpaidid').remove()
                }

                document.body.appendChild(modalframesource)
            }
            else {
                win.postMessage(
                    {
                        name: "config",
                        configdata: generateQueryString(_data),
                    },
                    '*'
                );
            }

        }

    }
    var anchors = document.querySelectorAll(".flwpug_getpaid");
    var anlen = anchors.length;

    function logCallbackEvent(data, redirects) {
        var action = "callback";
        var comment = "Triggered merchant callback";
        var object = "CALLBACK";

        if(redirects === true) {
            action = "redirect";
            object = "REDIRECT_URL";
            comment = "Redirecting to merchant";
        }

        var tx = data.tx || data.transactionobject || (data.data && data.data.tx || data.data.transactionobject);

        //Log events
        var auditID = tx && tx.modalauditid;
        var actor = tx && tx.customer && tx.customer.email;

        // Event params:
        var event_params = {};
        event_params.label = auditID;
        event_params.modalauditid = auditID;
        event_params.actor = actor;
        event_params.action = action;
        event_params.context = /Mobi/.test(navigator.userAgent) ? 'mobile' : 'web';
        event_params.comment = comment;
        event_params.object = object;
        event_params.token = 'flw_event_wt_e5fe4da063edacb29ec19f';

        event_params.date = Date.now();

        if (tx) {
            event_params.data = tx;
        }

        return fetch('https://flw-events-ge.herokuapp.com/event/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json'},
            body: JSON.stringify(event_params)
        })
    }

    function initialize() {
        if (anlen) {
            for (var i = 0; i < anlen; i++) {
                var ahref = anchors[i];
                if (ahref) {
                    var iframeData = {};
                    iframeData = extractAttributes(ahref, [
                        "PBFPubKey",
                        "txref",
                        "amount",
                        "customer_email",
                        "customer_phone",
                        "customer_lastname",
                        "customer_firstname",
                        "currency",
                        "country",
                        "customer_fullname",
                        "callback",
                        "onclose",
                        "onvalidateotpinit",
                        "onpaymentinit",
                        "redirect_url",
                        "pay_button_text",
                        "custom_title",
                        "custom_description",
                        "custom_logo",
                        "custom_narration",
                        "default_account",
                        "payment_method",
                        "exclude_banks",
                        "settlement_token",
                        "recurring_stop",
                        "integrity_hash",
                        "checkout_hash",
                        "payload_hash",
                        "redirect_post",
                        "redirect_no_json",
                        "payment_page",
                        "payment_plan",
                        "campaign_id",
                        "subaccounts_id",
                        "subaccounts_transaction_charge_type",
                        "subaccounts_transaction_split_ratio",
                        "subaccounts_transaction_charge",
                        "subaccounts",
                        "payment_options",
                        "disable_pwb",
                        "hosted_payment",
                        "include_discount_amount",
                        "mobilemoney_network",
                        "bank_transfer_expiry",
                        "custom_expires"
                    ]);

                    //globalMeta = extractMetaInfo(ahref);
                    iframeData.meta = extractMetaInfo(ahref);

                    if (iframeData.subaccounts) {
                        iframeData.subaccounts = JSON.parse(iframeData.subaccounts);
                    }

                    if (iframeData.subaccounts_id) {
                        iframeData.subaccounts = [{
                            id: iframeData.subaccounts_id,
                            transaction_split_ratio: iframeData.subaccounts_transaction_split_ratio,
                            transaction_charge_type: iframeData.subaccounts_transaction_charge_type,
                            transaction_charge: iframeData.subaccounts_transaction_charge,
                        }]

                        delete iframeData.subaccounts_transaction_split_ratio
                        delete iframeData.subaccounts_transaction_charge_type
                        delete iframeData.subaccounts_transaction_charge
                        delete iframeData.subaccounts_id
                    }

                    var paybutton = document.createElement("button");
                    paybutton.innerText = iframeData.pay_button_text || "PAY NOW";
                    ahref.innerText = "";

                    paybutton.setAttribute(
                        "style",
                        "color:#fff;background-color:#0a2740;border-color:#142a3e;/*padding:10px;*/display:inline-block;padding:6px12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1pxsolidtransparent;border-radius:4px;"
                    );

                    paybutton.setAttribute("type", "button");

                    paybutton.addEventListener("click", function (e) {
                        window.getpaidSetup(iframeData);
                    });
                    ahref.appendChild(paybutton);
                }
            }
        }

        // loadIframe(null, true);
    }

    initialize();

    window.addEventListener('beforeunload', function () {
        if (afterCallbackRedirectTimeout) {
            clearTimeout(afterCallbackRedirectTimeout);
        }

        // if (readyToReceive !== false) {
        //     var win = window.frames.checkout;
        //     win && win.postMessage({ name: 'forceclose' }, '*');
        // }
    });

    function _getpaidSetup(config) {

        globalChargeData = config;

        if (globalChargeData && !globalChargeData.onclose) {
            globalChargeData.onclose = (function () {
                var location = document.location;
                return function () { document.location = location; }
            }());
        }

        globalButtonClicked = Date.now();
        if (config.hosted_payment == 1 && !config.is_hosted_page) {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute(
                "action",
                V2_BASE_URL + "/hosted/pay"
            );
            console.log(config)
            for (var c in config) {
                if (c === "meta") {
                    config[c].forEach(function(m, mi) {
                        var i = document.createElement("input");
                        i.setAttribute("type", "hidden");
                        i.setAttribute("name", c + "[" + mi + "][metaname]");
                        i.setAttribute("value", m.metaname);
                        form.appendChild(i);
                        var i = document.createElement("input");
                        i.setAttribute("type", "hidden");
                        i.setAttribute("name", c + "[" + mi + "][metavalue]");
                        i.setAttribute("value", m.metavalue);
                        form.appendChild(i);
                    });
                }
                else if (c === 'theme' || c === 'billing' && Object.prototype.toString.call(config[c]) === '[object Object]') {
                    Object.keys(config[c]).forEach(function (prop) {
                        var i = document.createElement("input");
                        i.setAttribute("type", "hidden");
                        i.setAttribute("name", c + "[" + prop + "]");
                        i.setAttribute("value", config[c][prop]);
                        form.appendChild(i);
                    });
                }
                else if (c === 'subaccounts') {
                    config[c].forEach(function(m, mi) {
                        var i = document.createElement("input");
                        i.setAttribute("type", "hidden");
                        i.setAttribute("name", c + "[" + mi + "][id]");
                        i.setAttribute("value", m.id);
                        form.appendChild(i);
                        if (m.transaction_charge_type) {
                            var i = document.createElement("input");
                            i.setAttribute("type", "hidden");
                            i.setAttribute("name", c + "[" + mi + "][transaction_charge_type]");
                            i.setAttribute("value", m.transaction_charge_type);
                            form.appendChild(i);
                        }

                        if (m.transaction_charge) {
                            var i = document.createElement("input");
                            i.setAttribute("type", "hidden");
                            i.setAttribute("name", c + "[" + mi + "][transaction_charge]");
                            i.setAttribute("value", m.transaction_charge);
                            form.appendChild(i);
                        }

                        if (m.transaction_split_ratio) {
                            var i = document.createElement("input");
                            i.setAttribute("type", "hidden");
                            i.setAttribute("name", c + "[" + mi + "][transaction_split_ratio]");
                            i.setAttribute("value", m.transaction_split_ratio);
                            form.appendChild(i);
                        }

                    });
                }
                else {
                    if (
                        !~["string", "number", "boolean"].indexOf(
                            _typeof(config[c])
                        )
                    )
                        continue;
                    var i = document.createElement("input");
                    i.setAttribute("type", "hidden");
                    i.setAttribute("name", c);
                    i.setAttribute("value", config[c]);
                    form.appendChild(i);
                }
            }
            document.body.appendChild(form);
            form.submit();
            return;
        }

        globalIsHostedPage = config.is_hosted_page;
        delete config.is_hosted_page;
        globalMeta = config.meta;
        globalSubaccounts = config.subaccounts;
        globalTheme = config.theme;
        globalBillingDetails = config.billing;

        loadIframe(config, true);

        addQueryToIframe(config);
        if (loadState == "loaded") {
            showIframe();
        }
        else {
            showSpinner();
            deferredShowIframe = function (){
                showIframe();
            }
        }
    };

    window.getpaidSetup = function(config) {
        var _initialized = initiateUpgradeRequirementCheck(config);
        var _closed = false;

        _initialized.then(function() {
            if (config.PBFPubKey === latestPublicKey && _closed !== true) {
                publicKeyHandlersMap[latestPublicKey] = function _handler(evt) {
                    var name = evt && evt.data && evt.data.name;

                    if (name && message_handlers[name]) {
                        _closed === true
                            ? globalClosePopup(true, false)
                            : message_handlers[name](evt);
                    }
                };

                w.addEventListener(
                    "message",
                    publicKeyHandlersMap[latestPublicKey]
                );

                _getpaidSetup(config);
            }
        });

        return {
            close: (function() {
                try {
                    if (config.PBFPubKey === latestPublicKey) {
                        _closed = true;
                        globalClosePopup(true, false);
                    }
                } catch (e) {}
            }).bind(null)
        };
    };
    // Execute the showIframe function
    // showIframe();

})(window);

