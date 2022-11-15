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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/utilities/pvpService.js":
/*!**********************************************!*\
  !*** ./resources/js/utilities/pvpService.js ***!
  \**********************************************/
/*! exports provided: createUserDOM, generateEquation, createTimerDisplay, getParam */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createUserDOM", function() { return createUserDOM; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "generateEquation", function() { return generateEquation; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createTimerDisplay", function() { return createTimerDisplay; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getParam", function() { return getParam; });
var createUserDOM = function createUserDOM(users) {
  var contestants = [];

  for (var key in users.contestants) {
    if (Object.hasOwnProperty.call(users.contestants, key)) {
      var user = users.contestants[key];
      contestants.push(user);
    }
  }

  var player_one = contestants[0];
  var player_two = contestants[1];
  $('div#player-one-name').html(player_one.name);
  $('div#player-two-name').html(player_two.name);
  $('div.points-holder.one').attr('id', "player-".concat(player_one.id, "-points")).html(player_one.points > 1 ? "".concat(player_one.points, " points") : "".concat(player_one.points, " point"));
  $('div.points-holder.two').attr('id', "player-".concat(player_two.id, "-points")).html(player_two.points > 1 ? "".concat(player_two.points, " points") : "".concat(player_two.points, " point"));
};

var generateEquation = function generateEquation() {
  var equations = eq,
      htmlDOM = '',
      index = 1;
  equations.forEach(function (equation) {
    var operation = '';

    switch (equation.operation) {
      case 'addition':
        operation = '+';
        break;

      case 'subtraction':
        operation = '-';
        break;

      case 'multiplication':
        operation = 'x';
        break;

      case 'division':
        operation = '/';
        break;
    } // htmlDOM += `<div class="equation" data-answer=${equation.answer} >${equation.a}${operation}${equation.b}=???</div>`;


    htmlDOM += "<div class=\"equation equation-".concat(index, "\" data-answer=").concat(equation.answer, ">\n            <span class=\"circle\"></span>\n            <span id=\"equation-1\">").concat(equation.a).concat(operation).concat(equation.b, "=???</span>\n        </div>");
    index++;
  }); // htmlDOM += `<div class="big-square"></div>`;

  $('div.game-area').html(htmlDOM);
};

var createTimerDisplay = function createTimerDisplay(cd) {
  var newSeconds = cd;
  var seconds = newSeconds % 60;
  var minutes = Math.floor(newSeconds / 60);

  if (seconds < 10) {
    if (seconds == 0 && minutes > 0) {
      $('div.countdown').html("".concat(minutes, ": 0").concat(seconds));
      setTimeout(function () {
        $('div.countdown').html("".concat(minutes, ": ").concat(seconds));
      }, 1000);
      return;
    }

    $('div.countdown').html("".concat(minutes, ": 0").concat(seconds));
    return;
  }

  console.log("sec: ".concat(seconds, " | min: ").concat(minutes));
  $('div.countdown').html("".concat(minutes, ": ").concat(seconds));
};

var getParam = function getParam() {
  var query = window.location.search,
      parameters = new URLSearchParams(query),
      id = parameters.get('id'),
      name = parameters.get('name'),
      room = parameters.get('room');
  return {
    id: id,
    name: name,
    room: room
  };
};



/***/ }),

/***/ 2:
/*!****************************************************!*\
  !*** multi ./resources/js/utilities/pvpService.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\EquaSolve\app\resources\js\utilities\pvpService.js */"./resources/js/utilities/pvpService.js");


/***/ })

/******/ });