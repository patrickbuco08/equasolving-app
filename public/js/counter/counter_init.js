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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/counter/counter_init.js":
/*!**********************************************!*\
  !*** ./resources/js/counter/counter_init.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

throw new Error("Module build failed (from ./node_modules/babel-loader/lib/index.js):\nSyntaxError: C:\\xampp\\htdocs\\EquaSolve\\app\\resources\\js\\counter\\counter_init.js: Support for the experimental syntax 'jsx' isn't currently enabled (11:12):\n\n\u001b[0m \u001b[90m  9 |\u001b[39m     }\u001b[0m\n\u001b[0m \u001b[90m 10 |\u001b[39m\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 11 |\u001b[39m     render(\u001b[33m<\u001b[39m\u001b[33mCounter\u001b[39m\u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m            \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 12 |\u001b[39m         container\u001b[0m\n\u001b[0m \u001b[90m 13 |\u001b[39m     )\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 14 |\u001b[39m }\u001b[33m;\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:72:32)\n    at constructor (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:367:12)\n    at Parser.raise (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:3684:19)\n    at Parser.expectOnePlugin (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:3741:18)\n    at Parser.parseExprAtom (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:13282:18)\n    at Parser.parseExprSubscripts (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12852:23)\n    at Parser.parseUpdate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12831:21)\n    at Parser.parseMaybeUnary (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12801:23)\n    at Parser.parseMaybeUnaryOrPrivate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12592:61)\n    at Parser.parseExprOps (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12599:23)\n    at Parser.parseMaybeConditional (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12569:23)\n    at Parser.parseMaybeAssign (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12521:21)\n    at C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12479:39\n    at Parser.allowInAnd (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14553:12)\n    at Parser.parseMaybeAssignAllowIn (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12479:17)\n    at Parser.parseExprListItem (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14258:18)\n    at Parser.parseCallExpressionArguments (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:13078:22)\n    at Parser.parseCoverCallAndAsyncArrowHead (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12975:29)\n    at Parser.parseSubscript (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12900:19)\n    at Parser.parseSubscripts (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12869:19)\n    at Parser.parseExprSubscripts (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12858:17)\n    at Parser.parseUpdate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12831:21)\n    at Parser.parseMaybeUnary (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12801:23)\n    at Parser.parseMaybeUnaryOrPrivate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12592:61)\n    at Parser.parseExprOps (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12599:23)\n    at Parser.parseMaybeConditional (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12569:23)\n    at Parser.parseMaybeAssign (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12521:21)\n    at Parser.parseExpressionBase (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12457:23)\n    at C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12451:39\n    at Parser.allowInAnd (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14547:16)\n    at Parser.parseExpression (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12451:17)\n    at Parser.parseStatementContent (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14987:23)\n    at Parser.parseStatement (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14844:17)\n    at Parser.parseBlockOrModuleBlockBody (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:15503:25)\n    at Parser.parseBlockBody (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:15494:10)\n    at Parser.parseBlock (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:15478:10)\n    at Parser.parseFunctionBody (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14152:24)\n    at Parser.parseArrowExpression (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14123:10)\n    at Parser.parseParenAndDistinguishExpression (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:13622:12)\n    at Parser.parseExprAtom (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:13180:23)\n    at Parser.parseExprSubscripts (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12852:23)\n    at Parser.parseUpdate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12831:21)\n    at Parser.parseMaybeUnary (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12801:23)\n    at Parser.parseMaybeUnaryOrPrivate (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12592:61)\n    at Parser.parseExprOps (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12599:23)\n    at Parser.parseMaybeConditional (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12569:23)\n    at Parser.parseMaybeAssign (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12521:21)\n    at C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12479:39\n    at Parser.allowInAnd (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:14547:16)\n    at Parser.parseMaybeAssignAllowIn (C:\\xampp\\htdocs\\EquaSolve\\app\\node_modules\\@babel\\parser\\lib\\index.js:12479:17)");

/***/ }),

/***/ 1:
/*!****************************************************!*\
  !*** multi ./resources/js/counter/counter_init.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\EquaSolve\app\resources\js\counter\counter_init.js */"./resources/js/counter/counter_init.js");


/***/ })

/******/ });