/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 62);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(4);
var isBuffer = __webpack_require__(11);

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  extend: extend,
  trim: trim
};


/***/ }),
/* 1 */,
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(0);
var normalizeHeaderName = __webpack_require__(13);

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(5);
  } else if (typeof process !== 'undefined') {
    // For node use HTTP adapter
    adapter = __webpack_require__(5);
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(3)))

/***/ }),
/* 3 */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var settle = __webpack_require__(14);
var buildURL = __webpack_require__(16);
var parseHeaders = __webpack_require__(17);
var isURLSameOrigin = __webpack_require__(18);
var createError = __webpack_require__(6);
var btoa = (typeof window !== 'undefined' && window.btoa && window.btoa.bind(window)) || __webpack_require__(19);

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();
    var loadEvent = 'onreadystatechange';
    var xDomain = false;

    // For IE 8/9 CORS support
    // Only supports POST and GET calls and doesn't returns the response headers.
    // DON'T do this for testing b/c XMLHttpRequest is mocked, not XDomainRequest.
    if ("development" !== 'test' &&
        typeof window !== 'undefined' &&
        window.XDomainRequest && !('withCredentials' in request) &&
        !isURLSameOrigin(config.url)) {
      request = new window.XDomainRequest();
      loadEvent = 'onload';
      xDomain = true;
      request.onprogress = function handleProgress() {};
      request.ontimeout = function handleTimeout() {};
    }

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    request.open(config.method.toUpperCase(), buildURL(config.url, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request[loadEvent] = function handleLoad() {
      if (!request || (request.readyState !== 4 && !xDomain)) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        // IE sends 1223 instead of 204 (https://github.com/axios/axios/issues/201)
        status: request.status === 1223 ? 204 : request.status,
        statusText: request.status === 1223 ? 'No Content' : request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      reject(createError('timeout of ' + config.timeout + 'ms exceeded', config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(20);

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(config.url)) && config.xsrfCookieName ?
          cookies.read(config.xsrfCookieName) :
          undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (config.withCredentials) {
      request.withCredentials = true;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(15);

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(10);

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var bind = __webpack_require__(4);
var Axios = __webpack_require__(12);
var defaults = __webpack_require__(2);

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(utils.merge(defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(8);
axios.CancelToken = __webpack_require__(26);
axios.isCancel = __webpack_require__(7);

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(27);

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),
/* 11 */
/***/ (function(module, exports) {

/*!
 * Determine if an object is a Buffer
 *
 * @author   Feross Aboukhadijeh <https://feross.org>
 * @license  MIT
 */

// The _isBuffer check is for Safari 5-7 support, because it's missing
// Object.prototype.constructor. Remove this eventually
module.exports = function (obj) {
  return obj != null && (isBuffer(obj) || isSlowBuffer(obj) || !!obj._isBuffer)
}

function isBuffer (obj) {
  return !!obj.constructor && typeof obj.constructor.isBuffer === 'function' && obj.constructor.isBuffer(obj)
}

// For Node v0.10 support. Remove this eventually.
function isSlowBuffer (obj) {
  return typeof obj.readFloatLE === 'function' && typeof obj.slice === 'function' && isBuffer(obj.slice(0, 0))
}


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var defaults = __webpack_require__(2);
var utils = __webpack_require__(0);
var InterceptorManager = __webpack_require__(21);
var dispatchRequest = __webpack_require__(22);

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = utils.merge({
      url: arguments[0]
    }, arguments[1]);
  }

  config = utils.merge(defaults, {method: 'get'}, this.defaults, config);
  config.method = config.method.toLowerCase();

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(6);

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  // Note: status is not exposed by XDomainRequest
  if (!response.status || !validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }
  error.request = request;
  error.response = response;
  return error;
};


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
  (function standardBrowserEnv() {
    var msie = /(msie|trident)/i.test(navigator.userAgent);
    var urlParsingNode = document.createElement('a');
    var originURL;

    /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
    function resolveURL(url) {
      var href = url;

      if (msie) {
        // IE needs attribute set twice to normalize properties
        urlParsingNode.setAttribute('href', href);
        href = urlParsingNode.href;
      }

      urlParsingNode.setAttribute('href', href);

      // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
      return {
        href: urlParsingNode.href,
        protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
        host: urlParsingNode.host,
        search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
        hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
        hostname: urlParsingNode.hostname,
        port: urlParsingNode.port,
        pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
                  urlParsingNode.pathname :
                  '/' + urlParsingNode.pathname
      };
    }

    originURL = resolveURL(window.location.href);

    /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
    return function isURLSameOrigin(requestURL) {
      var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
      return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
    };
  })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return function isURLSameOrigin() {
      return true;
    };
  })()
);


/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


// btoa polyfill for IE<10 courtesy https://github.com/davidchambers/Base64.js

var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';

function E() {
  this.message = 'String contains an invalid character';
}
E.prototype = new Error;
E.prototype.code = 5;
E.prototype.name = 'InvalidCharacterError';

function btoa(input) {
  var str = String(input);
  var output = '';
  for (
    // initialize result and counter
    var block, charCode, idx = 0, map = chars;
    // if the next str index does not exist:
    //   change the mapping table to "="
    //   check if d has no fractional digits
    str.charAt(idx | 0) || (map = '=', idx % 1);
    // "8 - idx % 1 * 8" generates the sequence 2, 4, 6, 8
    output += map.charAt(63 & block >> 8 - idx % 1 * 8)
  ) {
    charCode = str.charCodeAt(idx += 3 / 4);
    if (charCode > 0xFF) {
      throw new E();
    }
    block = block << 8 | charCode;
  }
  return output;
}

module.exports = btoa;


/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
  (function standardBrowserEnv() {
    return {
      write: function write(name, value, expires, path, domain, secure) {
        var cookie = [];
        cookie.push(name + '=' + encodeURIComponent(value));

        if (utils.isNumber(expires)) {
          cookie.push('expires=' + new Date(expires).toGMTString());
        }

        if (utils.isString(path)) {
          cookie.push('path=' + path);
        }

        if (utils.isString(domain)) {
          cookie.push('domain=' + domain);
        }

        if (secure === true) {
          cookie.push('secure');
        }

        document.cookie = cookie.join('; ');
      },

      read: function read(name) {
        var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
        return (match ? decodeURIComponent(match[3]) : null);
      },

      remove: function remove(name) {
        this.write(name, '', Date.now() - 86400000);
      }
    };
  })() :

  // Non standard browser env (web workers, react-native) lack needed support.
  (function nonStandardBrowserEnv() {
    return {
      write: function write() {},
      read: function read() { return null; },
      remove: function remove() {}
    };
  })()
);


/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);
var transformData = __webpack_require__(23);
var isCancel = __webpack_require__(7);
var defaults = __webpack_require__(2);
var isAbsoluteURL = __webpack_require__(24);
var combineURLs = __webpack_require__(25);

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Support baseURL config
  if (config.baseURL && !isAbsoluteURL(config.url)) {
    config.url = combineURLs(config.baseURL, config.url);
  }

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers || {}
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(0);

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(8);

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony default export */ __webpack_exports__["default"] = ({
  template: '#vue_cilindro_seguimiento',
  dt_tbl_seguimiento_cilindro: null,
  tbl_seguimiento_cilindro: null,
  data: function data() {
    return {
      print_url: CURRENT_URL,
      filtros: {
        cilindro_id: getCilindro(),
        query: '',
        success_date: true,
        fecha_desde: moment([2018, 1, 1]).format('YYYY-MM-DD'),
        fecha_hasta: moment().format('YYYY-MM-DD'),
        filtro_date: 'interval'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv, ov) {
      console.log('xxxx');
    }
  },
  methods: {
    onSubmit_frmAplicarFiltro: function onSubmit_frmAplicarFiltro() {
      var desde = moment(this.filtros.fecha_desde);
      var hasta = moment(this.filtros.fecha_hasta);
      this.filtros.success_date = true;
      if (desde.isValid() && hasta.isValid() && desde.unix() <= hasta.unix()) {
        if (desde.unix() < hasta.unix()) {
          this.filtros.filtro_date = 'interval';
        } else if (desde.unix() == hasta.unix()) {
          this.filtros.filtro_date = 'same';
        } else {
          toastr.warning('Fechas no válidas para la búsqueda x', 'Revisar');
          this.filtros.success_date = false;
        }
      } else {
        toastr.warning('Fechas no válidas para la búsqueda', 'Revisar');
        this.filtros.success_date = false;
      }

      if (this.filtros.success_date) this.dt_tbl_seguimiento_cilindro.draw();
    }
  },
  mounted: function mounted() {
    var _this = this;

    console.log(this);
    this.tbl_seguimiento_cilindro = $('#tbl_seguimiento_cilindro');
    // var temp_url = new URL(CURRENT_URL);

    // if (!temp_url.searchParams.has('e'))
    // 	temp_url.searchParams.append('e', 'pdf')
    // if (!temp_url.searchParams.has('d'))
    // 	temp_url.searchParams.append('d', this.filtros.fecha_desde)
    // if (!temp_url.searchParams.has('h'))
    // 	temp_url.searchParams.append('h', this.filtros.fecha_hasta)
    // if (!temp_url.searchParams.has('m'))
    // 	temp_url.searchParams.append('m', this.filtros.filtro_date)

    // this.print_url = temp_url.toString()

    // $('#guia_recibo').typeahead({
    //     highlight : true,
    //     hint: false,
    //     minLength: 1,
    //   },
    //   {
    //     async :true,
    //     name: 'buscar-guia-recibo',
    //     display: function(d){
    //       return d.nombre
    //     },
    //     source: function(q, cb, asy) {
    //       // let result = []
    //       if (q.trim() != '') {
    //         axios.get(BASE_URL + '/api/propietarios?qq=' + q).then(res => {
    //           // console.log(res.data)
    //           // return res.data
    //           asy(res.data)
    //           // return res.data
    //         })

    //         // let regex = new RegExp(q, 'i');
    //         // cb(_this.listaBancos.filter(v => {
    //         //   return regex.test(v.banco_name)
    //         // }))
    //       }

    //     }
    //   })
    // .bind('typeahead:select', this.fnTargetCliente)
    // .bind('typeahead:autocomplete', this.fnTargetCliente)
    this.dt_tbl_seguimiento_cilindro = this.tbl_seguimiento_cilindro.DataTable({
      data: [],
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/cilindro/seguimiento',
        data: function data(d) {
          d.buscar = _this.filtros.query;
          if (_this.filtros.success_date) {
            d.cilindro_id = _this.filtros.cilindro_id;
            d.filtro_date = _this.filtros.filtro_date;
            d.buscar = _this.filtros.query;
            d.desde = _this.filtros.fecha_desde;
            d.hasta = _this.filtros.fecha_hasta;
          }
        }
      },
      serverSide: true,
      // rowCallback: function (r, d) {
      //   // console.log(this)
      //   console.log(r)
      //   console.log(d)
      //   if (+d.anulado == 1) {
      //     r.classList.add("mystyle")
      //   }
      //   // if ()
      // },
      dom: '<"table-responsive"t>p',
      // order: [[0, "desc"]],
      // bSort: false,
      columns: [{ data: 'salida' }, { data: 'guia_correlativo' }, { data: 'entrada' }, { data: 'recibo_correlativo' }],
      columnDefs: [
        // {targets: [7], className: 'text-right'}
      ]
    }).on('draw', function () {
      var g = _this.dt_tbl_seguimiento_cilindro.ajax.params();
      delete g.length;
      delete g.start;
      _this.print_url = BASE_URL + '/home/cilindro/seguimiento?' + $.param(g) + '&export=pdf';
    });
  }
});

/***/ }),
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */,
/* 43 */,
/* 44 */,
/* 45 */,
/* 46 */,
/* 47 */,
/* 48 */,
/* 49 */,
/* 50 */,
/* 51 */,
/* 52 */,
/* 53 */,
/* 54 */,
/* 55 */,
/* 56 */,
/* 57 */,
/* 58 */,
/* 59 */,
/* 60 */,
/* 61 */,
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(63);


/***/ }),
/* 63 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__listar_js__ = __webpack_require__(64);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__registro_js__ = __webpack_require__(65);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__seguimiento_js__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__seguimientotres_js__ = __webpack_require__(66);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__situacion_js__ = __webpack_require__(67);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');





// import VueRouter from 'vue-router'
// Vue.use(VueRouter)
// const router = new VueRouter({
//   // mode: 'history',
//   routes: [
//     { path: '/', component: listar},
//     { path: '/registro', component: registro },
//     { path: '/:id/editar', component: registro, name: 'editar' }
//   ]
// });
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// const app_r = new Vue(registro)

var app = new Vue({
  el: '#vue_cilindros',
  components: {
    listar: __WEBPACK_IMPORTED_MODULE_0__listar_js__["a" /* default */],
    registro: __WEBPACK_IMPORTED_MODULE_1__registro_js__["a" /* default */],
    seguimiento: __WEBPACK_IMPORTED_MODULE_2__seguimiento_js__["default"],
    seguimientotres: __WEBPACK_IMPORTED_MODULE_3__seguimientotres_js__["a" /* default */],
    situacion: __WEBPACK_IMPORTED_MODULE_4__situacion_js__["a" /* default */]
    // router
  } });

/***/ }),
/* 64 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);


/* harmony default export */ __webpack_exports__["a"] = ({
  template: '#vue_cilindros_listar',
  name: 'listar',
  data: function data() {
    return {
      cilindros: [],
      dt_tbl_cilindros: null,
      tbl_cilindros: null,
      filtros: {
        fn: 'default',
        situacion: [0, 1, 2, 3],
        query: ''
      }
    };
  },

  methods: {
    getSituacion: function getSituacion(num) {
      switch (+num) {
        case 0:
          return { name: 'extraviado', color: 'success' };
        case 1:
          return { name: 'fabrica', color: 'success' };
        case 2:
          return { name: 'transporte', color: 'success' };
        case 3:
          return { name: 'cliente', color: 'primary' };
      }
      return 'no_definido';
    },
    getCargado: function getCargado(num) {
      switch (+num) {
        case 0:
          return { attr: 'V', color: 'warning' };
        case 1:
          return { attr: 'R', color: 'primary' };
        case 2:
          return { attr: 'C', color: 'success' };
      }
      return { attr: 'X', color: 'default' };
    },
    getDefectuoso: function getDefectuoso(num) {
      switch (+num) {
        case 0:
          return 'D';
        case 1:
          return 'N';
      }
      return 'X';
    },
    fnOnSubmit_AplicarFiltro: function fnOnSubmit_AplicarFiltro() {
      // if (gdw.success) {
      // this.frmFilter = gdw.dw
      // dt_tbl_cilindros.page.len(this.filter.selNroFilas)
      document.getElementById('txt_buscar').select();
      this.dt_tbl_cilindros.draw();
      // }
    },

    // getDataWhere () {
    //   let dataWhere = { fn: 'default', data: {} }

    //   let res = {success: false, dw: null}

    //   if (this.filter.radCancelados != this.filter.radDeudores) {
    //     if (this.filter.radCancelados) dataWhere.data.estado = 1
    //     if (this.filter.radDeudores) dataWhere.data.estado = 0
    //   } else dataWhere.data.estado = -1

    //   if (this.txt_fecha_inicio === this.txt_fecha_fin) {
    //     dataWhere.fn = 'filter_single_date'
    //     res.success = true
    //   } else if (moment(this.txt_fecha_fin) > moment(this.txt_fecha_inicio)) {
    //     dataWhere.fn = 'filter_interval_date'
    //     res.success = true
    //   } else {
    //     this.txt_fecha_inicio = this.txt_fecha_fin
    //   }

    //   if (res.success) {
    //     dataWhere.data.fecha_inicio = this.txt_fecha_inicio
    //     dataWhere.data.fecha_fin = this.txt_fecha_fin
    //     dataWhere.data.id_cliente = this.filter.txtIdCliente
    //     dataWhere.data.tipo_doc = this.filter.selTipoDocFilter
    //     // dataWhere.data.tipo_doc = this.filter.selNroFilas
    //   }
    //   res.dw = dataWhere
    //   return res
    // },
    fnOnClick_btnAcciones: function fnOnClick_btnAcciones(e) {
      var dataset = e.currentTarget.dataset;
      switch (dataset.accion) {
        case 'detalles':
          break;
        case 'eliminar':
          break;
      }
    }
  },
  created: function created() {
    console.log('componente cargado');
    // axios.get(BASE_URL + '/api/cilindro').then(res => {
    //   console.log(res)
    //   this.cilindros = res.data
    // })
  },
  mounted: function mounted() {
    var _this = this;

    // axios.get(BASE_URL + '/home/cilindro?type=json').then(res => {
    // console.log(res.data)
    // this.cilindros = res.data
    this.tbl_cilindros = $('#tbl_cilindros');
    this.dt_tbl_cilindros = this.tbl_cilindros.DataTable({
      data: this.cilindros,
      dom: '<"table-responsive"t>p',
      pageLength: 10,
      responsive: true,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/cilindro?type=json',
        data: function data(d) {
          d.custom_filter = _this.filtros;
        }
      },
      serverSide: true,
      columns: [{ data: 'serie', render: function render(d, t, r) {
          return d.toUpperCase();
        } }, { data: 'capacidad' }, { data: 'propietario.nombre', render: function render(d, t, r) {
          return d.toUpperCase();
        } }, { data: 'presion' }, { data: 'situacion', render: function render(d, t, r) {
          var cargado = _this.getCargado(r.cargado);

          var span = '<span class="badge badge-' + _this.getSituacion(d).color + ' rounded-2">' + _this.getSituacion(d).name + '</span>\n                        <span class="badge badge-' + cargado.color + ' rounded-2">' + cargado.attr + '</span>\n                        ';
          if (r.defectuoso == 1) span += '<span class="badge badge-danger rounded-2">D</span>';
          return span;
        } }, { data: 'cil_id', render: function render(d, t, r) {
          return '\n                  <a href="' + (BASE_URL + '/home/cilindro/' + d + '/cambiar_situacion') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="cambiar_situacion"><i class="fa fa-refresh"></i> </a>\n                  <a href="' + (BASE_URL + '/home/cilindro/' + d + '/seguimiento') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="historial"><i class="fa fa-exchange"></i> </a>\n                  <a href="' + (BASE_URL + '/home/cilindro/' + d) + '" class="btn btn-sm btn-default btn-accion-table btn-acciones btn-acciones-default"  data-id="' + d + '" data-accion="detalles"><i class="fa fa-eye"></i> </a>\n                  <a href="' + (BASE_URL + '/home/cilindro/' + d + '/edit') + '" class="btn btn-sm btn-default btn-accion-table btn-acciones"  data-id="' + d + '" data-accion="editar"><i class="fa fa-pencil"></i> </a>\n                  <button class="btn btn-sm btn-default btn-accion-table btn-acciones" type="button" data-id="' + d + '" data-accion="eliminar"><i class="fa fa-trash"></i> </button>\n\n                ';
        } }],
      columnDefs: [{
        targets: [5],
        className: 'text-right'
      }]
    });

    $('#tbl_cilindros').on('click', '.btn-acciones', this.fnOnClick_btnAcciones);

    // })
  }
});

/***/ }),
/* 65 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

// import axios from 'axios'
var win = window;
/* harmony default export */ __webpack_exports__["a"] = ({
  template: '#vue_cilindros_registro',
  name: 'registro',
  data: function data() {
    return _extends({}, app_data, {
      error: {
        propietario: false
      }
    });
  },

  // beforeRouteEnter (to, from, next) {
  //   console.log('before')
  //   console.log(to)
  //   next(res => {
  //     console.log(res)
  //     return true
  //   })
  // },
  // beforeRouteUpdate (to, from, next) {
  //   // console.log('update')
  //   // console.log(from)
  //   // console.log(to)
  //   this.getPropietario(to.params.id)
  //   next(true)
  // },
  methods: {
    // editar () {
    //   console.log('editar')
    // },
    getCilindro: function getCilindro(id) {
      var _this = this;

      console.log(id);
      setTimeout(function () {
        axios.get(BASE_URL + '/api/cilindro/' + id + '?type=json').then(function (res) {
          console.log(res.data);
          if (_this.edit && res.data.success) {
            _this.cilindro = res.data.data;

            //     "cil_id": 6,
            // "serie": "5555890951",
            // "codigo": "5555890951",
            // "capacidad": "10.00",
            // "tapa": "0",
            // "presion": "2700.00",
            // "propietario_id": 48,
            // "situacion": "1",
            // "created_at": "2018-08-30 22:18:04",
            // "updated_at": "2018-08-30 22:18:04",
            // "cargado": "0",
            // "defectuoso": "0"

            _this.nombre = _this.cilindro.propietario_id;
            _this.serie = _this.cilindro.serie;
            _this.capacidad = _this.cilindro.capacidad;
            _this.presion = _this.cilindro.presion;
            _this.tapa = +_this.cilindro.tapa;
            // this.error = this.cilindro.
            // this.propietario = this.cilindro.

          }
        }).catch(function (err) {
          console.log(err);
          console.log(err.response);
        });
      }, 10000);
    },
    resetData: function resetData() {
      this.nombre = '';
      this.serie = '';
      this.capacidad = 0;
      this.presion = 0;
      this.tapa = 0;
      this.error.propietario = false;
      this.propietario = null;
      this.$refs.propietario.focus();
    },
    frmOnSubmit_frmRegistro: function frmOnSubmit_frmRegistro() {
      var _this2 = this;

      this.error.propietario = false;
      if (this.propietario != null) {
        if (this.capacidad > 0 && this.presion > 0) {

          var sendData = {
            serie: this.serie,
            capacidad: this.capacidad,
            presion: this.presion,
            tapa: this.tapa,
            propietario: this.propietario.ent_id
          };
          var config = {
            method: this.edit ? 'PUT' : 'POST',
            params: sendData,
            url: this.edit ? BASE_URL + '/api/cilindro/' + this.cilindro.cil_id : BASE_URL + '/api/cilindro'
          };
          axios(config).then(function (res) {
            // console.log(res)
            if (res.data.success) {
              // this.$router.push({path: '/'})
              if (_this2.edit) {
                toastr.success("La actualización se realizó con éxito", "Cilindro - Success");

                // this.$router.push({path: '/'})
              } else {
                toastr.success("El registro se realizó con éxito", "Cilindro - Success");

                _this2.resetData();
              }
            }
            if (res.data.existe) {
              toastr.error("El número de serie se encuentra registrado", "Cilindro - Error");
            }
          }).catch(function (err) {
            console.log(err.response);
            toastr.error(parsePreJson(err.response), 'Error');
          });
        } else {
          toastr.error('Capacidad y presión deben ser mayores a cero', 'Cilindro - Error');
        }
      } else {
        this.error.propietario = true;
        toastr.error('Seleccione un propietario', 'Cilindro - Error');
      }
    },

    // btnOnClick_btnCancelar () {
    //   // this.$router.push({path: '/'})

    //   console.log(this)
    // },
    fnTargetPropietario: function fnTargetPropietario(e, d) {
      // console.log(data)
      this.propietario = d;
      this.nombre = d.nombre + ' - ' + d.numero;
    }
  },
  created: function created() {
    if (this.edit) console.log('ACTUALIZAR CILINDROS');else console.log('REGISTRO CILINDROS');
    console.log(this);
    // if (win.editmode) {
    //   this.edit = true
    //   this.getCilindro(win.idcilindro)
    // } else {
    //   console.log('no found')
    // }
  },
  mounted: function mounted() {

    console.log('mounted');
    $('#propietario').typeahead({
      highlight: true,
      hint: false,
      minLength: 1
    }, {
      async: true,
      name: 'buscar-nombre-propietario',
      display: function display(d) {
        return d.nombre + ' - ' + d.numero;
      },
      source: function source(q, cb, asy) {
        // let result = []
        if (q.trim() != '') {
          axios.get(BASE_URL + '/api/propietarios?q=' + q).then(function (res) {
            console.log(res.data);
            asy(res.data);
            // return res.data
          });

          // let regex = new RegExp(q, 'i');
          // cb(_this.listaBancos.filter(v => {
          //   return regex.test(v.banco_name)
          // }))
        }
      }
    }).bind('typeahead:select', this.fnTargetPropietario).bind('typeahead:autocomplete', this.fnTargetPropietario);
  }
});

/***/ }),
/* 66 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
  template: '#vue_cilindro_seguimiento_tres',
  dt_tbl_seguimiento_cilindro: null,
  tbl_seguimiento_cilindro: null,
  data: function data() {
    return {
      print_url: CURRENT_URL,
      seguimiento: [],
      filtros: {
        cilindro_id: getCilindro(),
        query: '',
        success_date: true,
        fecha_desde: moment([2018, 1, 1]).format('YYYY-MM-DD'),
        fecha_hasta: moment().format('YYYY-MM-DD'),
        filtro_date: 'interval'
      }
    };
  },

  watch: {
    'filtros.fecha_desde': function filtrosFecha_desde(nv, ov) {
      console.log('xxxx');
    }
  },
  methods: {
    onSubmit_frmAplicarFiltro: function onSubmit_frmAplicarFiltro() {
      var desde = moment(this.filtros.fecha_desde);
      var hasta = moment(this.filtros.fecha_hasta);
      this.filtros.success_date = true;
      if (desde.isValid() && hasta.isValid() && desde.unix() <= hasta.unix()) {
        if (desde.unix() < hasta.unix()) {
          this.filtros.filtro_date = 'interval';
        } else if (desde.unix() == hasta.unix()) {
          this.filtros.filtro_date = 'same';
        } else {
          toastr.warning('Fechas no válidas para la búsqueda x', 'Revisar');
          this.filtros.success_date = false;
        }
      } else {
        toastr.warning('Fechas no válidas para la búsqueda', 'Revisar');
        this.filtros.success_date = false;
      }

      if (this.filtros.success_date) this.dt_tbl_seguimiento_cilindro.draw();
    }
  },
  created: function created() {
    var _this = this;

    axios.get(CURRENT_URL, { params: { type: 'json' } }).then(function (res) {
      console.log(res);
      _this.seguimiento = res.data;
    }).catch(function (err) {
      console.log(err.response);
    });
  },
  mounted: function mounted() {
    var _this2 = this;

    this.tbl_seguimiento_cilindro = $('#tbl_seguimiento_cilindro');
    var temp_url = new URL(CURRENT_URL);

    if (!temp_url.searchParams.has('e')) temp_url.searchParams.append('e', 'pdf');
    if (!temp_url.searchParams.has('d')) temp_url.searchParams.append('d', this.filtros.fecha_desde);
    if (!temp_url.searchParams.has('h')) temp_url.searchParams.append('h', this.filtros.fecha_hasta);
    if (!temp_url.searchParams.has('m')) temp_url.searchParams.append('m', this.filtros.filtro_date);

    this.print_url = temp_url.toString();
    // $('#guia_recibo').typeahead({
    //     highlight : true,
    //     hint: false,
    //     minLength: 1,
    //   },
    //   {
    //     async :true,
    //     name: 'buscar-guia-recibo',
    //     display: function(d){
    //       return d.nombre
    //     },
    //     source: function(q, cb, asy) {
    //       // let result = []
    //       if (q.trim() != '') {
    //         axios.get(BASE_URL + '/api/propietarios?qq=' + q).then(res => {
    //           // console.log(res.data)
    //           // return res.data
    //           asy(res.data)
    //           // return res.data
    //         })

    //         // let regex = new RegExp(q, 'i');
    //         // cb(_this.listaBancos.filter(v => {
    //         //   return regex.test(v.banco_name)
    //         // }))
    //       }

    //     }
    //   })
    // .bind('typeahead:select', this.fnTargetCliente)
    // .bind('typeahead:autocomplete', this.fnTargetCliente)
    this.dt_tbl_seguimiento_cilindro = this.tbl_seguimiento_cilindro.DataTable({
      data: [],
      pageLength: 10,
      processing: true,
      ajax: {
        url: BASE_URL + '/home/cilindro/seguimiento',
        data: function data(d) {
          d.buscar = _this2.filtros.query;
          if (_this2.filtros.success_date) {
            d.cilindro_id = _this2.filtros.cilindro_id;
            d.filtro_date = _this2.filtros.filtro_date;
            d.buscar = _this2.filtros.query;
            d.desde = _this2.filtros.fecha_desde;
            d.hasta = _this2.filtros.fecha_hasta;
          }
        }
      },
      serverSide: true,
      // rowCallback: function (r, d) {
      //   // console.log(this)
      //   console.log(r)
      //   console.log(d)
      //   if (+d.anulado == 1) {
      //     r.classList.add("mystyle")
      //   }
      //   // if ()
      // },
      dom: '<"table-responsive"t>p',
      // order: [[0, "desc"]],
      // bSort: false,
      columns: [{ data: 'salida' }, { data: 'guia_correlativo' }, { data: 'entrada' }, { data: 'recibo_correlativo' }],
      columnDefs: [
        // {targets: [7], className: 'text-right'}
      ]
    });
  }
});

/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
	template: '#vue_cilindro_situacion',
	data: function data() {
		return {
			ubicacion: 'cliente',
			cilindro: OBJ_CILINDRO,
			situacion: '',
			motivo: '',
			fecha: moment().format('YYYY-MM-DD'),
			hora: '00:00'
		};
	},

	methods: {
		frmOnSubmit_cambiarSituacion: function frmOnSubmit_cambiarSituacion(e) {
			var sendParams = {
				situacion: this.situacion,
				motivo: this.motivo,
				ubicacion: this.ubicacion,
				fecha: this.fecha,
				hora: this.hora
			};
			axios.put(BASE_URL + '/api/cilindro/' + this.cilindro.cil_id + '?m=cambiar_situacion', sendParams).then(function (res) {
				console.log(res.data);
				if (res.data.success) {
					toastr.success('Actualización completada con éxito', 'Cilindro - Success');
				}
			}).catch(function (e) {
				console.log(e.response);
			});
		}
	},
	created: function created() {
		var process_evento = true;
		if (this.cilindro.defectuoso == '1') {
			this.situacion = 'defectuoso';
			process_evento = false;
		}
		if (this.cilindro.trasegada == '1') {
			this.situacion = 'trasegada';
			process_evento = false;
		}
		if (process_evento) {
			switch (this.cilindro.evento) {
				case 'cliente':
					this.situacion = 'cliente';
					break;
				case 'cargada':
					this.situacion = 'cargada';
					break;
				case 'vacio':
					this.situacion = 'vacio';
					break;
			}
		}
	}
});

/***/ })
/******/ ]);