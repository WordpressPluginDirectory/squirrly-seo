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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/blocks.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/assertThisInitialized.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }
  return self;
}
module.exports = _assertThisInitialized, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/classCallCheck.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/classCallCheck.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}
module.exports = _classCallCheck, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/createClass.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/createClass.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toPropertyKey = __webpack_require__(/*! ./toPropertyKey.js */ "./node_modules/@babel/runtime/helpers/toPropertyKey.js");
function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, toPropertyKey(descriptor.key), descriptor);
  }
}
function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  Object.defineProperty(Constructor, "prototype", {
    writable: false
  });
  return Constructor;
}
module.exports = _createClass, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/defineProperty.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var toPropertyKey = __webpack_require__(/*! ./toPropertyKey.js */ "./node_modules/@babel/runtime/helpers/toPropertyKey.js");
function _defineProperty(obj, key, value) {
  key = toPropertyKey(key);
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }
  return obj;
}
module.exports = _defineProperty, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/extends.js":
/*!********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/extends.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _extends() {
  module.exports = _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  return _extends.apply(this, arguments);
}
module.exports = _extends, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/getPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _getPrototypeOf(o) {
  module.exports = _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  return _getPrototypeOf(o);
}
module.exports = _getPrototypeOf, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/inherits.js":
/*!*********************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/inherits.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var setPrototypeOf = __webpack_require__(/*! ./setPrototypeOf.js */ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js");
function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }
  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  Object.defineProperty(subClass, "prototype", {
    writable: false
  });
  if (superClass) setPrototypeOf(subClass, superClass);
}
module.exports = _inherits, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/objectWithoutProperties.js":
/*!************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/objectWithoutProperties.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var objectWithoutPropertiesLoose = __webpack_require__(/*! ./objectWithoutPropertiesLoose.js */ "./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js");
function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};
  var target = objectWithoutPropertiesLoose(source, excluded);
  var key, i;
  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);
    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }
  return target;
}
module.exports = _objectWithoutProperties, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/objectWithoutPropertiesLoose.js ***!
  \*****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;
  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }
  return target;
}
module.exports = _objectWithoutPropertiesLoose, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/typeof.js")["default"];
var assertThisInitialized = __webpack_require__(/*! ./assertThisInitialized.js */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");
function _possibleConstructorReturn(self, call) {
  if (call && (_typeof(call) === "object" || typeof call === "function")) {
    return call;
  } else if (call !== void 0) {
    throw new TypeError("Derived constructors may only return object or undefined");
  }
  return assertThisInitialized(self);
}
module.exports = _possibleConstructorReturn, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/setPrototypeOf.js":
/*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/setPrototypeOf.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _setPrototypeOf(o, p) {
  module.exports = _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports;
  return _setPrototypeOf(o, p);
}
module.exports = _setPrototypeOf, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toPrimitive.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toPrimitive.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/typeof.js")["default"];
function _toPrimitive(input, hint) {
  if (_typeof(input) !== "object" || input === null) return input;
  var prim = input[Symbol.toPrimitive];
  if (prim !== undefined) {
    var res = prim.call(input, hint || "default");
    if (_typeof(res) !== "object") return res;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return (hint === "string" ? String : Number)(input);
}
module.exports = _toPrimitive, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toPropertyKey.js":
/*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toPropertyKey.js ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _typeof = __webpack_require__(/*! ./typeof.js */ "./node_modules/@babel/runtime/helpers/typeof.js")["default"];
var toPrimitive = __webpack_require__(/*! ./toPrimitive.js */ "./node_modules/@babel/runtime/helpers/toPrimitive.js");
function _toPropertyKey(arg) {
  var key = toPrimitive(arg, "string");
  return _typeof(key) === "symbol" ? key : String(key);
}
module.exports = _toPropertyKey, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/typeof.js":
/*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  return (module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) {
    return typeof obj;
  } : function (obj) {
    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
  }, module.exports.__esModule = true, module.exports["default"] = module.exports), _typeof(obj);
}
module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports;

/***/ }),

/***/ "./src/blocks.js":
/*!***********************!*\
  !*** ./src/blocks.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _extensions_formats___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./extensions/formats/ */ "./src/extensions/formats/index.js");
/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */

/**
 * WordPress dependencies
 */
var registerBlockType = wp.blocks.registerBlockType;

// // Formats


/***/ }),

/***/ "./src/extensions/formats/index.js":
/*!*****************************************!*\
  !*** ./src/extensions/formats/index.js ***!
  \*****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/objectWithoutProperties */ "./node_modules/@babel/runtime/helpers/objectWithoutProperties.js");
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _link__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./link */ "./src/extensions/formats/link/index.js");

var _excluded = ["name"];
/**
 * Internal dependencies
 */


/**
 * WordPress dependencies
 */
var registerFormatType = wp.richText.registerFormatType;
var select = wp.data.select;
var isDisabled = select('core/edit-post').isFeatureActive('disableSquirrlyLinkFormats');
function registerEditorsKitFormats() {
  [!isDisabled ? _link__WEBPACK_IMPORTED_MODULE_1__["link"] : []].forEach(function (_ref) {
    var name = _ref.name,
      settings = _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_0___default()(_ref, _excluded);
    if (name) {
      registerFormatType(name, settings);
    }
  });
}
wp.domReady(registerEditorsKitFormats);

/***/ }),

/***/ "./src/extensions/formats/link/components/edit.js":
/*!********************************************************!*\
  !*** ./src/extensions/formats/link/components/edit.js ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _inline__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./inline */ "./src/extensions/formats/link/components/inline.js");








function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0___default()(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_6___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_5___default()(this, result); }; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
/**
 * External dependencies
 */


/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var _wp$element = wp.element,
  Component = _wp$element.Component,
  Fragment = _wp$element.Fragment;
var _wp$data = wp.data,
  withSelect = _wp$data.withSelect,
  dispatch = _wp$data.dispatch;
var _wp$blockEditor = wp.blockEditor,
  BlockControls = _wp$blockEditor.BlockControls,
  RichTextToolbarButton = _wp$blockEditor.RichTextToolbarButton,
  RichTextShortcut = _wp$blockEditor.RichTextShortcut;
var _wp$richText = wp.richText,
  getTextContent = _wp$richText.getTextContent,
  applyFormat = _wp$richText.applyFormat,
  removeFormat = _wp$richText.removeFormat,
  slice = _wp$richText.slice,
  getActiveFormat = _wp$richText.getActiveFormat;
var isURL = wp.url.isURL;
var _wp$components = wp.components,
  Toolbar = _wp$components.Toolbar,
  withSpokenMessages = _wp$components.withSpokenMessages;
var _wp$compose = wp.compose,
  compose = _wp$compose.compose,
  ifCondition = _wp$compose.ifCondition;

/**
 * Internal dependencies
 */

var name = 'squirrly/link';
var title = __('Add Link', 'block-options');
var EMAIL_REGEXP = /^(mailto:)?[a-z0-9._%+-]+@[a-z0-9][a-z0-9.-]*\.[a-z]{2,63}$/i;
var Edit = /*#__PURE__*/function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_4___default()(Edit, _Component);
  var _super = _createSuper(Edit);
  function Edit() {
    var _this;
    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1___default()(this, Edit);
    _this = _super.apply(this, arguments);
    _this.isEmail = _this.isEmail.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3___default()(_this));
    _this.addLink = _this.addLink.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3___default()(_this));
    _this.stopAddingLink = _this.stopAddingLink.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3___default()(_this));
    _this.onRemoveFormat = _this.onRemoveFormat.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_3___default()(_this));
    _this.state = {
      addingLink: false
    };
    return _this;
  }
  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2___default()(Edit, [{
    key: "componentDidMount",
    value: function componentDidMount() {
      var oldFormat = this.props.oldFormat;
      if (oldFormat) {
        oldFormat.edit = null;
        dispatch('core/rich-text').addFormatTypes(oldFormat);
      }
    }
  }, {
    key: "isEmail",
    value: function isEmail(email) {
      return EMAIL_REGEXP.test(email);
    }
  }, {
    key: "addLink",
    value: function addLink() {
      var _this$props = this.props,
        value = _this$props.value,
        onChange = _this$props.onChange;
      var text = getTextContent(slice(value));
      if (text && isURL(text)) {
        onChange(applyFormat(value, {
          type: name,
          attributes: {
            url: text
          }
        }));
      } else if (text && this.isEmail(text)) {
        onChange(applyFormat(value, {
          type: name,
          attributes: {
            url: "mailto:".concat(text)
          }
        }));
      } else {
        this.setState({
          addingLink: true
        });
      }
    }
  }, {
    key: "stopAddingLink",
    value: function stopAddingLink() {
      this.setState({
        addingLink: false
      });
    }
  }, {
    key: "onRemoveFormat",
    value: function onRemoveFormat() {
      var _this$props2 = this.props,
        value = _this$props2.value,
        onChange = _this$props2.onChange,
        speak = _this$props2.speak;
      var newValue = value;
      Object(lodash__WEBPACK_IMPORTED_MODULE_8__["map"])(['core/link', 'squirrly/link'], function (linkFormat) {
        newValue = removeFormat(newValue, linkFormat);
      });
      onChange(_objectSpread({}, newValue));
      speak(__('Link removed.', 'block-options'), 'assertive');
    }
  }, {
    key: "render",
    value: function render() {
      var _this$props3 = this.props,
        activeAttributes = _this$props3.activeAttributes,
        onChange = _this$props3.onChange;
      var _this$props4 = this.props,
        isActive = _this$props4.isActive,
        value = _this$props4.value;
      var activeFormat = getActiveFormat(value, 'core/link');
      if (activeFormat) {
        activeFormat.type = name;
        if (typeof activeFormat.unregisteredAttributes !== 'undefined' && typeof activeFormat.unregisteredAttributes.rel !== 'undefined') {
          activeFormat.attributes = Object.assign(activeFormat.attributes, {
            rel: activeFormat.unregisteredAttributes.rel
          });
        }
        var newValue = value;
        newValue = applyFormat(newValue, activeFormat);
        newValue = removeFormat(newValue, 'core/link');
        onChange(_objectSpread({}, newValue));
        value = newValue;
        isActive = true;
      }
      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(BlockControls, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(RichTextShortcut, {
        type: "primary",
        character: "k",
        onUse: this.addLink
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(RichTextShortcut, {
        type: "primaryShift",
        character: "k",
        onUse: this.onRemoveFormat
      }), isActive && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(RichTextToolbarButton, {
        name: "link",
        icon: "editor-unlink",
        title: __('Unlink', 'block-options'),
        onClick: this.onRemoveFormat,
        isActive: isActive,
        shortcutType: "primaryShift",
        shortcutCharacter: "k"
      }), !isActive && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(RichTextToolbarButton, {
        name: "link",
        icon: "admin-links",
        title: title,
        onClick: this.addLink,
        isActive: isActive,
        shortcutType: "primary",
        shortcutCharacter: "k"
      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_7__["createElement"])(_inline__WEBPACK_IMPORTED_MODULE_9__["default"], {
        value: value,
        isActive: isActive,
        onChange: onChange,
        contentRef: this.props.contentRef,
        addingLink: this.state.addingLink,
        stopAddingLink: this.stopAddingLink,
        activeAttributes: activeAttributes
      })));
    }
  }]);
  return Edit;
}(Component);
/* harmony default export */ __webpack_exports__["default"] = (compose(withSelect(function (select) {
  return {
    isDisabled: select('core/edit-post').isFeatureActive('disableSquirrlyLinkFormats'),
    oldFormat: select('core/rich-text').getFormatType('core/link')
  };
}), ifCondition(function (props) {
  return !props.isDisabled;
}), withSpokenMessages)(Edit));

/***/ }),

/***/ "./src/extensions/formats/link/components/inline.js":
/*!**********************************************************!*\
  !*** ./src/extensions/formats/link/components/inline.js ***!
  \**********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/assertThisInitialized */ "./node_modules/@babel/runtime/helpers/assertThisInitialized.js");
/* harmony import */ var _babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/extends.js");
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @babel/runtime/helpers/objectWithoutProperties */ "./node_modules/@babel/runtime/helpers/objectWithoutProperties.js");
/* harmony import */ var _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./utils */ "./src/extensions/formats/link/components/utils.js");
/* harmony import */ var _positioned_at_selection__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./positioned-at-selection */ "./src/extensions/formats/link/components/positioned-at-selection.js");
/* harmony import */ var _index__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../index */ "./src/extensions/formats/link/index.js");








var _excluded = ["isActive", "addingLink", "value", "contentRef"];

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_5___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_4___default()(this, result); }; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var _wp$element = wp.element,
  Component = _wp$element.Component,
  createRef = _wp$element.createRef,
  useMemo = _wp$element.useMemo,
  Fragment = _wp$element.Fragment;
var _wp$components = wp.components,
  ToggleControl = _wp$components.ToggleControl,
  withSpokenMessages = _wp$components.withSpokenMessages;
var _wp$keycodes = wp.keycodes,
  LEFT = _wp$keycodes.LEFT,
  RIGHT = _wp$keycodes.RIGHT,
  UP = _wp$keycodes.UP,
  DOWN = _wp$keycodes.DOWN,
  BACKSPACE = _wp$keycodes.BACKSPACE,
  ENTER = _wp$keycodes.ENTER,
  ESCAPE = _wp$keycodes.ESCAPE;
var getRectangleFromRange = wp.dom.getRectangleFromRange;
var prependHTTP = wp.url.prependHTTP;
var _wp$richText = wp.richText,
  create = _wp$richText.create,
  insert = _wp$richText.insert,
  isCollapsed = _wp$richText.isCollapsed,
  applyFormat = _wp$richText.applyFormat,
  getTextContent = _wp$richText.getTextContent,
  slice = _wp$richText.slice,
  useAnchor = _wp$richText.useAnchor;
var _wp$blockEditor = wp.blockEditor,
  URLPopover = _wp$blockEditor.URLPopover,
  useCachedTruthy = _wp$blockEditor.useCachedTruthy;

/**
 * Internal dependencies
 */



var stopKeyPropagation = function stopKeyPropagation(event) {
  return event.stopPropagation();
};
function isShowingInput(props, state) {
  return props.addingLink || state.editLink;
}
var URLPopoverAtLink = function URLPopoverAtLink(_ref) {
  var isActive = _ref.isActive,
    addingLink = _ref.addingLink,
    value = _ref.value,
    contentRef = _ref.contentRef,
    props = _babel_runtime_helpers_objectWithoutProperties__WEBPACK_IMPORTED_MODULE_7___default()(_ref, _excluded);
  var popoverAnchor = useCachedTruthy(useAnchor({
    value: value,
    editableContentElement: contentRef.current,
    settings: _index__WEBPACK_IMPORTED_MODULE_11__["link"]
  }));
  if (!popoverAnchor) {
    return null;
  }
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(URLPopover, _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_6___default()({
    anchor: popoverAnchor
  }, props));
};
var InlineLinkUI = /*#__PURE__*/function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_3___default()(InlineLinkUI, _Component);
  var _super = _createSuper(InlineLinkUI);
  function InlineLinkUI() {
    var _this;
    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, InlineLinkUI);
    _this = _super.apply(this, arguments);
    _this.editLink = _this.editLink.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.submitLink = _this.submitLink.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.onKeyDown = _this.onKeyDown.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.onChangeInputValue = _this.onChangeInputValue.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.setLinkTarget = _this.setLinkTarget.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.setNoFollow = _this.setNoFollow.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.setSponsored = _this.setSponsored.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.onFocusOutside = _this.onFocusOutside.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.resetState = _this.resetState.bind(_babel_runtime_helpers_assertThisInitialized__WEBPACK_IMPORTED_MODULE_2___default()(_this));
    _this.autocompleteRef = createRef();
    _this.state = {
      opensInNewWindow: false,
      noFollow: false,
      sponsored: false,
      inputValue: ''
    };
    return _this;
  }
  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(InlineLinkUI, [{
    key: "onKeyDown",
    value: function onKeyDown(event) {
      if ([LEFT, DOWN, RIGHT, UP, BACKSPACE, ENTER].indexOf(event.keyCode) > -1) {
        // Stop the key event from propagating up to ObserveTyping.startTypingInTextField.
        event.stopPropagation();
      }
      if ([ESCAPE].indexOf(event.keyCode) > -1) {
        this.resetState();
      }
    }
  }, {
    key: "onChangeInputValue",
    value: function onChangeInputValue(inputValue) {
      this.setState({
        inputValue: inputValue
      });
    }
  }, {
    key: "setLinkTarget",
    value: function setLinkTarget(opensInNewWindow) {
      var _this$props = this.props,
        _this$props$activeAtt = _this$props.activeAttributes.url,
        url = _this$props$activeAtt === void 0 ? '' : _this$props$activeAtt,
        value = _this$props.value,
        onChange = _this$props.onChange;
      this.setState({
        opensInNewWindow: opensInNewWindow
      });

      // Apply now if URL is not being edited.
      if (!isShowingInput(this.props, this.state)) {
        var selectedText = getTextContent(slice(value));
        onChange(applyFormat(value, Object(_utils__WEBPACK_IMPORTED_MODULE_9__["createLinkFormat"])({
          url: url,
          opensInNewWindow: opensInNewWindow,
          noFollow: this.state.noFollow,
          sponsored: this.state.sponsored,
          text: selectedText
        })));
      }
    }
  }, {
    key: "setNoFollow",
    value: function setNoFollow(noFollow) {
      var _this$props2 = this.props,
        _this$props2$activeAt = _this$props2.activeAttributes.url,
        url = _this$props2$activeAt === void 0 ? '' : _this$props2$activeAt,
        value = _this$props2.value,
        onChange = _this$props2.onChange;
      this.setState({
        noFollow: noFollow
      });

      // Apply now if URL is not being edited.
      if (!isShowingInput(this.props, this.state)) {
        var selectedText = getTextContent(slice(value));
        onChange(applyFormat(value, Object(_utils__WEBPACK_IMPORTED_MODULE_9__["createLinkFormat"])({
          url: url,
          opensInNewWindow: this.state.opensInNewWindow,
          noFollow: noFollow,
          sponsored: this.state.sponsored,
          text: selectedText
        })));
      }
    }
  }, {
    key: "setSponsored",
    value: function setSponsored(sponsored) {
      var _this$props3 = this.props,
        _this$props3$activeAt = _this$props3.activeAttributes.url,
        url = _this$props3$activeAt === void 0 ? '' : _this$props3$activeAt,
        value = _this$props3.value,
        onChange = _this$props3.onChange;
      this.setState({
        sponsored: sponsored
      });

      // Apply now if URL is not being edited.
      if (!isShowingInput(this.props, this.state)) {
        var selectedText = getTextContent(slice(value));
        onChange(applyFormat(value, Object(_utils__WEBPACK_IMPORTED_MODULE_9__["createLinkFormat"])({
          url: url,
          opensInNewWindow: this.state.opensInNewWindow,
          noFollow: this.state.noFollow,
          sponsored: sponsored,
          text: selectedText
        })));
      }
    }
  }, {
    key: "editLink",
    value: function editLink(event) {
      this.setState({
        editLink: true
      });
      event.preventDefault();
    }
  }, {
    key: "submitLink",
    value: function submitLink(event) {
      var _this$props4 = this.props,
        isActive = _this$props4.isActive,
        value = _this$props4.value,
        onChange = _this$props4.onChange,
        speak = _this$props4.speak;
      var _this$state = this.state,
        inputValue = _this$state.inputValue,
        opensInNewWindow = _this$state.opensInNewWindow;
      var url = prependHTTP(inputValue);
      var selectedText = getTextContent(slice(value));
      var format = Object(_utils__WEBPACK_IMPORTED_MODULE_9__["createLinkFormat"])({
        url: url,
        opensInNewWindow: opensInNewWindow,
        text: selectedText
      });
      event.preventDefault();
      if (isCollapsed(value) && !isActive) {
        var toInsert = applyFormat(create({
          text: url
        }), format, 0, url.length);
        onChange(insert(value, toInsert));
      } else {
        onChange(applyFormat(value, format));
      }
      this.resetState();
      if (!Object(_utils__WEBPACK_IMPORTED_MODULE_9__["isValidHref"])(url)) {
        speak(__('Warning: the link has been inserted but may have errors. Please test it.', 'block-options'), 'assertive');
      } else if (isActive) {
        speak(__('Link edited.', 'block-options'), 'assertive');
      } else {
        speak(__('Link inserted.', 'block-options'), 'assertive');
      }
    }
  }, {
    key: "onFocusOutside",
    value: function onFocusOutside() {
      // The autocomplete suggestions list renders in a separate popover (in a portal),
      // so onClickOutside fails to detect that a click on a suggestion occured in the
      // LinkContainer. Detect clicks on autocomplete suggestions using a ref here, and
      // return to avoid the popover being closed.
      var autocompleteElement = this.autocompleteRef.current;
      if (autocompleteElement && autocompleteElement.contains(event.target)) {
        return;
      }
      this.resetState();
    }
  }, {
    key: "resetState",
    value: function resetState() {
      this.props.stopAddingLink();
      this.setState({
        editLink: false
      });
    }
  }, {
    key: "render",
    value: function render() {
      var _this2 = this;
      var _this$props5 = this.props,
        isActive = _this$props5.isActive,
        _this$props5$activeAt = _this$props5.activeAttributes,
        url = _this$props5$activeAt.url,
        target = _this$props5$activeAt.target,
        rel = _this$props5$activeAt.rel,
        addingLink = _this$props5.addingLink,
        value = _this$props5.value;
      if (!isActive && !addingLink) {
        return null;
      }
      var _this$state2 = this.state,
        inputValue = _this$state2.inputValue,
        opensInNewWindow = _this$state2.opensInNewWindow,
        noFollow = _this$state2.noFollow,
        sponsored = _this$state2.sponsored;
      var showInput = isShowingInput(this.props, this.state);
      if (!opensInNewWindow && target === '_blank') {
        this.setState({
          opensInNewWindow: true
        });
      }
      if (typeof rel === 'string') {
        var relNoFollow = rel.split(' ').includes('nofollow');
        var relSponsored = rel.split(' ').includes('sponsored');
        if (relNoFollow !== noFollow) {
          this.setState({
            noFollow: relNoFollow
          });
        }
        if (relSponsored !== sponsored) {
          this.setState({
            sponsored: relSponsored
          });
        }
      }
      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(URLPopoverAtLink, {
        value: value,
        contentRef: this.props.contentRef,
        isActive: isActive,
        addingLink: addingLink,
        onFocusOutside: this.onFocusOutside,
        onClose: function onClose() {
          if (!inputValue) {
            _this2.resetState();
          }
        },
        focusOnMount: showInput ? 'firstElement' : false,
        className: "squirrly-url-popover",
        renderSettings: function renderSettings() {
          return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(ToggleControl, {
            label: __('Open in New Tab', 'block-options'),
            checked: opensInNewWindow,
            onChange: _this2.setLinkTarget
          }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(ToggleControl, {
            label: __('No Follow', 'block-options'),
            checked: noFollow,
            onChange: _this2.setNoFollow
          }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(ToggleControl, {
            label: __('Sponsored', 'block-options'),
            checked: sponsored,
            onChange: _this2.setSponsored
          }));
        }
      }, showInput ? Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(URLPopover.LinkEditor, {
        className: "editor-format-toolbar__link-container-content block-editor-format-toolbar__link-container-content",
        value: inputValue,
        onChangeInputValue: this.onChangeInputValue,
        onKeyDown: this.onKeyDown,
        onKeyPress: stopKeyPropagation,
        onSubmit: this.submitLink,
        autocompleteRef: this.autocompleteRef
      }) : Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_8__["createElement"])(URLPopover.LinkViewer, {
        className: "editor-format-toolbar__link-container-content block-editor-format-toolbar__link-container-content",
        onKeyPress: stopKeyPropagation,
        url: url,
        onEditLinkClick: this.editLink,
        linkClassName: url && Object(_utils__WEBPACK_IMPORTED_MODULE_9__["isValidHref"])(prependHTTP(url)) ? undefined : 'has-invalid-link'
      }));
    }
  }], [{
    key: "getDerivedStateFromProps",
    value: function getDerivedStateFromProps(props, state) {
      var _props$activeAttribut = props.activeAttributes,
        url = _props$activeAttribut.url,
        target = _props$activeAttribut.target,
        rel = _props$activeAttribut.rel;
      var opensInNewWindow = target === '_blank';
      if (!isShowingInput(props, state)) {
        if (url !== state.inputValue) {
          return {
            inputValue: url
          };
        }
        if (opensInNewWindow !== state.opensInNewWindow) {
          return {
            opensInNewWindow: opensInNewWindow
          };
        }
        if (typeof rel === 'string') {
          var noFollow = rel.split(' ').includes('nofollow');
          var sponsored = rel.split(' ').includes('sponsored');
          if (noFollow !== state.noFollow) {
            return {
              noFollow: noFollow
            };
          }
          if (sponsored !== state.sponsored) {
            return {
              sponsored: sponsored
            };
          }
        }
      }
      return null;
    }
  }]);
  return InlineLinkUI;
}(Component);
/* harmony default export */ __webpack_exports__["default"] = (withSpokenMessages(InlineLinkUI));

/***/ }),

/***/ "./src/extensions/formats/link/components/positioned-at-selection.js":
/*!***************************************************************************!*\
  !*** ./src/extensions/formats/link/components/positioned-at-selection.js ***!
  \***************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/classCallCheck */ "./node_modules/@babel/runtime/helpers/classCallCheck.js");
/* harmony import */ var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/createClass */ "./node_modules/@babel/runtime/helpers/createClass.js");
/* harmony import */ var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/inherits */ "./node_modules/@babel/runtime/helpers/inherits.js");
/* harmony import */ var _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @babel/runtime/helpers/possibleConstructorReturn */ "./node_modules/@babel/runtime/helpers/possibleConstructorReturn.js");
/* harmony import */ var _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @babel/runtime/helpers/getPrototypeOf */ "./node_modules/@babel/runtime/helpers/getPrototypeOf.js");
/* harmony import */ var _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);






function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _babel_runtime_helpers_getPrototypeOf__WEBPACK_IMPORTED_MODULE_4___default()(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _babel_runtime_helpers_possibleConstructorReturn__WEBPACK_IMPORTED_MODULE_3___default()(this, result); }; }
function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); return true; } catch (e) { return false; } }
/**
 * WordPress dependencies
 */
var Component = wp.element.Component;
var _wp$dom = wp.dom,
  getOffsetParent = _wp$dom.getOffsetParent,
  getRectangleFromRange = _wp$dom.getRectangleFromRange;

/**
 * Returns a style object for applying as `position: absolute` for an element
 * relative to the bottom-center of the current selection. Includes `top` and
 * `left` style properties.
 *
 * @return {Object} Style object.
 */
function getCurrentCaretPositionStyle() {
  var selection = window.getSelection();

  // Unlikely, but in the case there is no selection, return empty styles so
  // as to avoid a thrown error by `Selection#getRangeAt` on invalid index.
  if (selection.rangeCount === 0) {
    return {};
  }

  // Get position relative viewport.
  var rect = getRectangleFromRange(selection.getRangeAt(0));
  var top = rect.top + rect.height;
  var left = rect.left + rect.width / 2;

  // Offset by positioned parent, if one exists.
  var offsetParent = getOffsetParent(selection.anchorNode);
  if (offsetParent) {
    var parentRect = offsetParent.getBoundingClientRect();
    top -= parentRect.top;
    left -= parentRect.left;
  }
  return {
    top: top,
    left: left
  };
}

/**
 * Component which renders itself positioned under the current caret selection.
 * The position is calculated at the time of the component being mounted, so it
 * should only be mounted after the desired selection has been made.
 *
 */
var PositionedAtSelection = /*#__PURE__*/function (_Component) {
  _babel_runtime_helpers_inherits__WEBPACK_IMPORTED_MODULE_2___default()(PositionedAtSelection, _Component);
  var _super = _createSuper(PositionedAtSelection);
  function PositionedAtSelection() {
    var _this;
    _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_0___default()(this, PositionedAtSelection);
    _this = _super.apply(this, arguments);
    _this.state = {
      style: getCurrentCaretPositionStyle()
    };
    return _this;
  }
  _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_1___default()(PositionedAtSelection, [{
    key: "render",
    value: function render() {
      var children = this.props.children;
      var style = this.state.style;
      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__["createElement"])("div", {
        className: "editor-format-toolbar__selection-position",
        style: style
      }, children);
    }
  }]);
  return PositionedAtSelection;
}(Component);
/* harmony default export */ __webpack_exports__["default"] = (PositionedAtSelection);

/***/ }),

/***/ "./src/extensions/formats/link/components/utils.js":
/*!*********************************************************!*\
  !*** ./src/extensions/formats/link/components/utils.js ***!
  \*********************************************************/
/*! exports provided: isValidHref, createLinkFormat */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isValidHref", function() { return isValidHref; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createLinkFormat", function() { return createLinkFormat; });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/**
 * External dependencies
 */


/**
 * WordPress dependencies
 */
var _wp$url = wp.url,
  getProtocol = _wp$url.getProtocol,
  isValidProtocol = _wp$url.isValidProtocol,
  getAuthority = _wp$url.getAuthority,
  isValidAuthority = _wp$url.isValidAuthority,
  getPath = _wp$url.getPath,
  isValidPath = _wp$url.isValidPath,
  getQueryString = _wp$url.getQueryString,
  isValidQueryString = _wp$url.isValidQueryString,
  getFragment = _wp$url.getFragment,
  isValidFragment = _wp$url.isValidFragment;
var _wp$i18n = wp.i18n,
  __ = _wp$i18n.__,
  sprintf = _wp$i18n.sprintf;

/**
 * Check for issues with the provided href.
 *
 * @param {string} href The href.
 *
 * @return {boolean} Is the href invalid?
 */
function isValidHref(href) {
  if (!href) {
    return false;
  }
  var trimmedHref = href.trim();
  if (!trimmedHref) {
    return false;
  }

  // Does the href start with something that looks like a URL protocol?
  if (/^\S+:/.test(trimmedHref)) {
    var protocol = getProtocol(trimmedHref);
    if (!isValidProtocol(protocol)) {
      return false;
    }

    // Add some extra checks for http(s) URIs, since these are the most common use-case.
    // This ensures URIs with an http protocol have exactly two forward slashes following the protocol.
    // eslint-disable-next-line no-useless-escape
    if (Object(lodash__WEBPACK_IMPORTED_MODULE_0__["startsWith"])(protocol, 'http') && !/^https?:\/\/[^\/\s]/i.test(trimmedHref)) {
      return false;
    }
    var authority = getAuthority(trimmedHref);
    if (!isValidAuthority(authority)) {
      return false;
    }
    var path = getPath(trimmedHref);
    if (path && !isValidPath(path)) {
      return false;
    }
    var queryString = getQueryString(trimmedHref);
    if (queryString && !isValidQueryString(queryString)) {
      return false;
    }
    var fragment = getFragment(trimmedHref);
    if (fragment && !isValidFragment(fragment)) {
      return false;
    }
  }

  // Validate anchor links.
  if (Object(lodash__WEBPACK_IMPORTED_MODULE_0__["startsWith"])(trimmedHref, '#') && !isValidFragment(trimmedHref)) {
    return false;
  }
  return true;
}

/**
 * Generates the format object that will be applied to the link text.
 *
 * @param {Object}  options
 * @param {string}  options.url              The href of the link.
 * @param {boolean} options.opensInNewWindow Whether this link will open in a new window.
 * @param {Object}  options.text             The text that is being hyperlinked.
 *
 * @return {Object} The final format object.
 */
function createLinkFormat(_ref) {
  var url = _ref.url,
    opensInNewWindow = _ref.opensInNewWindow,
    noFollow = _ref.noFollow,
    sponsored = _ref.sponsored,
    text = _ref.text;
  var format = {
    type: 'squirrly/link',
    attributes: {
      url: url
    }
  };
  var relAttributes = [];
  if (opensInNewWindow) {
    // translators: accessibility label for external links, where the argument is the link text
    var label = sprintf(__('%s (opens in a new tab)', 'block-options'), text);
    format.attributes.target = '_blank';
    format.attributes['aria-label'] = label;
    relAttributes.push('noreferrer noopener');
  }
  if (noFollow) {
    relAttributes.push('nofollow');
  }
  if (sponsored) {
    relAttributes.push('sponsored');
  }
  if (relAttributes.length > 0) {
    format.attributes.rel = relAttributes.join(' ');
  }
  return format;
}

/***/ }),

/***/ "./src/extensions/formats/link/index.js":
/*!**********************************************!*\
  !*** ./src/extensions/formats/link/index.js ***!
  \**********************************************/
/*! exports provided: link */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "link", function() { return link; });
/* harmony import */ var _components_edit__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/edit */ "./src/extensions/formats/link/components/edit.js");
/**
 * Internal dependencies
 */


/**
 * WordPress dependencies
 */
var __ = wp.i18n.__;
var _wp$richText = wp.richText,
  applyFormat = _wp$richText.applyFormat,
  isCollapsed = _wp$richText.isCollapsed;
var decodeEntities = wp.htmlEntities.decodeEntities;
var isURL = wp.url.isURL;

/**
 * Block constants
 */
var name = 'squirrly/link';
var link = {
  name: name,
  title: __('Link', 'block-options'),
  tagName: 'a',
  className: 'ek-link',
  attributes: {
    url: 'href',
    target: 'target',
    rel: 'rel'
  },
  __unstablePasteRule: function __unstablePasteRule(value, _ref) {
    var html = _ref.html,
      plainText = _ref.plainText;
    if (isCollapsed(value)) {
      return value;
    }
    var pastedText = (html || plainText).replace(/<[^>]+>/g, '').trim();

    // A URL was pasted, turn the selection into a link
    if (!isURL(pastedText)) {
      return value;
    }

    // Allows us to ask for this information when we get a report.
    //window.console.log( 'Created link:\n\n', pastedText );

    return applyFormat(value, {
      type: name,
      attributes: {
        url: decodeEntities(pastedText)
      }
    });
  },
  edit: _components_edit__WEBPACK_IMPORTED_MODULE_0__["default"]
};

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["element"]; }());

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["lodash"]; }());

/***/ })

/******/ });
//# sourceMappingURL=gutenberg.js.map