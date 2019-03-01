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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var __ = wp.i18n.__;
var el = wp.element.createElement;
var registerBlockType = wp.blocks.registerBlockType;
var SelectControl = wp.components.SelectControl;
var Fragment = wp.element.Fragment;

var adTitleList = ad_list['aic_ad_title'];
var selectData = [];

if (adTitleList) {
    Object.keys(adTitleList).forEach(function (key) {
        selectData.push({ value: key, label: adTitleList[key] });
    });

    registerBlockType('aic/block', {
        title: __('Ads In Content', 'ads-in-content'),
        description: __('You can add your ad codes in content easily', 'ads-in-content'),
        icon: 'archive',
        category: 'widgets',
        attributes: {
            adKey: {
                type: 'string'
            }
        },

        edit: function edit(_ref) {
            var attributes = _ref.attributes,
                setAttributes = _ref.setAttributes;

            if (!attributes.adKey) {
                setAttributes({ adKey: selectData[0]['value'] });
            }

            return wp.element.createElement(SelectControl, {
                label: __('Select ad:', 'ads-in-content'),
                value: attributes.adKey,
                onChange: function onChange(adKey) {
                    return setAttributes({ adKey: adKey });
                },
                options: selectData
            });
        },


        save: function save() {
            return null;
        }
    });
}

/***/ })
/******/ ]);