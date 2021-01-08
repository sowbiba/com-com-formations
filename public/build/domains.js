(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["domains"],{

/***/ "./assets/admin/js/domains.js":
/*!************************************!*\
  !*** ./assets/admin/js/domains.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _app__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./app */ "./assets/admin/js/app.js");
/* harmony import */ var _styles_domains_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../styles/domains.scss */ "./assets/admin/styles/domains.scss");
/* harmony import */ var _styles_domains_scss__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_styles_domains_scss__WEBPACK_IMPORTED_MODULE_2__);


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

 // Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

console.log('Hello Webpack Encore! Edit me in assets/admin/js/domains.js');
$(document).ready(function () {
  setSampleColor($('select#domain_color'));
  $('select#domain_color').on('change', function () {
    setSampleColor($(this));
  });
  setSampleIcon($('input#domain_icon'), $('.domain-icon-sample'));
  $('input#domain_icon').on('input', function () {
    setSampleIcon($(this), $('.domain-icon-sample'));
  });
});

function setSampleColor(selector) {
  var selectedColor = selector.val();
  var sampleColor = $('.domain-color-sample');
  var actualColor = sampleColor.attr('data-selected');

  if (actualColor) {
    sampleColor.removeClass(actualColor);
  }

  sampleColor.addClass(selectedColor);
  sampleColor.attr({
    'data-selected': selectedColor
  });
}

function setSampleIcon(selector, sampleIcon) {
  var selectedIcon = selector.val();
  var actualIcon = sampleIcon.attr('data-selected');

  if (actualIcon) {
    sampleIcon.find('.icon').removeClass("bx-".concat(actualIcon));
    sampleIcon.find('.icon').removeClass("bxs-".concat(actualIcon));
    sampleIcon.find('.icon').removeClass("bxl-".concat(actualIcon));
  }

  sampleIcon.find('.icon').addClass("bxl-".concat(selectedIcon));
  sampleIcon.find('.icon').addClass("bxs-".concat(selectedIcon));
  sampleIcon.find('.icon').addClass("bx-".concat(selectedIcon));
  sampleIcon.attr({
    'data-selected': selectedIcon
  });
}

/***/ }),

/***/ "./assets/admin/styles/domains.scss":
/*!******************************************!*\
  !*** ./assets/admin/styles/domains.scss ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

},[["./assets/admin/js/domains.js","runtime","vendors~admin_app~domains~encarts~formations~front_app~home~intervenants~users","vendors~admin_app~domains~encarts~formations~home~intervenants~users","admin_app~domains~encarts~formations~front_app~home~intervenants~users","admin_app~domains~encarts~formations~home~intervenants~users"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYWRtaW4vanMvZG9tYWlucy5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvYWRtaW4vc3R5bGVzL2RvbWFpbnMuc2NzcyJdLCJuYW1lcyI6WyIkIiwicmVxdWlyZSIsImNvbnNvbGUiLCJsb2ciLCJkb2N1bWVudCIsInJlYWR5Iiwic2V0U2FtcGxlQ29sb3IiLCJvbiIsInNldFNhbXBsZUljb24iLCJzZWxlY3RvciIsInNlbGVjdGVkQ29sb3IiLCJ2YWwiLCJzYW1wbGVDb2xvciIsImFjdHVhbENvbG9yIiwiYXR0ciIsInJlbW92ZUNsYXNzIiwiYWRkQ2xhc3MiLCJzYW1wbGVJY29uIiwic2VsZWN0ZWRJY29uIiwiYWN0dWFsSWNvbiIsImZpbmQiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0NBR0E7QUFDQTs7QUFFQSxJQUFNQSxDQUFDLEdBQUdDLG1CQUFPLENBQUMsb0RBQUQsQ0FBakI7O0FBQ0FDLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLDZEQUFaO0FBRUFILENBQUMsQ0FBQ0ksUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBWTtBQUMxQkMsZ0JBQWMsQ0FBQ04sQ0FBQyxDQUFDLHFCQUFELENBQUYsQ0FBZDtBQUVBQSxHQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5Qk8sRUFBekIsQ0FBNEIsUUFBNUIsRUFBc0MsWUFBVztBQUM3Q0Qsa0JBQWMsQ0FBQ04sQ0FBQyxDQUFDLElBQUQsQ0FBRixDQUFkO0FBQ0gsR0FGRDtBQUlBUSxlQUFhLENBQUNSLENBQUMsQ0FBQyxtQkFBRCxDQUFGLEVBQXlCQSxDQUFDLENBQUMscUJBQUQsQ0FBMUIsQ0FBYjtBQUVBQSxHQUFDLENBQUMsbUJBQUQsQ0FBRCxDQUF1Qk8sRUFBdkIsQ0FBMEIsT0FBMUIsRUFBbUMsWUFBVztBQUMxQ0MsaUJBQWEsQ0FBQ1IsQ0FBQyxDQUFDLElBQUQsQ0FBRixFQUFVQSxDQUFDLENBQUMscUJBQUQsQ0FBWCxDQUFiO0FBQ0gsR0FGRDtBQUdILENBWkQ7O0FBY0EsU0FBU00sY0FBVCxDQUF3QkcsUUFBeEIsRUFBa0M7QUFDOUIsTUFBTUMsYUFBYSxHQUFHRCxRQUFRLENBQUNFLEdBQVQsRUFBdEI7QUFFQSxNQUFNQyxXQUFXLEdBQUdaLENBQUMsQ0FBQyxzQkFBRCxDQUFyQjtBQUNBLE1BQU1hLFdBQVcsR0FBR0QsV0FBVyxDQUFDRSxJQUFaLENBQWlCLGVBQWpCLENBQXBCOztBQUVBLE1BQUlELFdBQUosRUFBaUI7QUFDYkQsZUFBVyxDQUFDRyxXQUFaLENBQXdCRixXQUF4QjtBQUNIOztBQUNERCxhQUFXLENBQUNJLFFBQVosQ0FBcUJOLGFBQXJCO0FBQ0FFLGFBQVcsQ0FBQ0UsSUFBWixDQUFpQjtBQUFDLHFCQUFpQko7QUFBbEIsR0FBakI7QUFDSDs7QUFFRCxTQUFTRixhQUFULENBQXVCQyxRQUF2QixFQUFpQ1EsVUFBakMsRUFBNkM7QUFDekMsTUFBTUMsWUFBWSxHQUFHVCxRQUFRLENBQUNFLEdBQVQsRUFBckI7QUFFQSxNQUFNUSxVQUFVLEdBQUdGLFVBQVUsQ0FBQ0gsSUFBWCxDQUFnQixlQUFoQixDQUFuQjs7QUFFQSxNQUFJSyxVQUFKLEVBQWdCO0FBQ1pGLGNBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkwsV0FBekIsY0FBMkNJLFVBQTNDO0FBQ0FGLGNBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkwsV0FBekIsZUFBNENJLFVBQTVDO0FBQ0FGLGNBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkwsV0FBekIsZUFBNENJLFVBQTVDO0FBQ0g7O0FBRURGLFlBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkosUUFBekIsZUFBeUNFLFlBQXpDO0FBQ0FELFlBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkosUUFBekIsZUFBeUNFLFlBQXpDO0FBQ0FELFlBQVUsQ0FBQ0csSUFBWCxDQUFnQixPQUFoQixFQUF5QkosUUFBekIsY0FBd0NFLFlBQXhDO0FBRUFELFlBQVUsQ0FBQ0gsSUFBWCxDQUFnQjtBQUFDLHFCQUFpQkk7QUFBbEIsR0FBaEI7QUFDSCxDOzs7Ozs7Ozs7OztBQzFERCx1QyIsImZpbGUiOiJkb21haW5zLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLypcbiAqIFdlbGNvbWUgdG8geW91ciBhcHAncyBtYWluIEphdmFTY3JpcHQgZmlsZSFcbiAqXG4gKiBXZSByZWNvbW1lbmQgaW5jbHVkaW5nIHRoZSBidWlsdCB2ZXJzaW9uIG9mIHRoaXMgSmF2YVNjcmlwdCBmaWxlXG4gKiAoYW5kIGl0cyBDU1MgZmlsZSkgaW4geW91ciBiYXNlIGxheW91dCAoYmFzZS5odG1sLnR3aWcpLlxuICovXG5pbXBvcnQgJy4vYXBwJztcbmltcG9ydCAnLi4vc3R5bGVzL2RvbWFpbnMuc2Nzcyc7XG5cbi8vIE5lZWQgalF1ZXJ5PyBJbnN0YWxsIGl0IHdpdGggXCJ5YXJuIGFkZCBqcXVlcnlcIiwgdGhlbiB1bmNvbW1lbnQgdG8gaW1wb3J0IGl0LlxuLy8gaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcblxuY29uc3QgJCA9IHJlcXVpcmUoJ2pxdWVyeScpO1xuY29uc29sZS5sb2coJ0hlbGxvIFdlYnBhY2sgRW5jb3JlISBFZGl0IG1lIGluIGFzc2V0cy9hZG1pbi9qcy9kb21haW5zLmpzJyk7XG5cbiQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uICgpIHtcbiAgICBzZXRTYW1wbGVDb2xvcigkKCdzZWxlY3QjZG9tYWluX2NvbG9yJykpO1xuXG4gICAgJCgnc2VsZWN0I2RvbWFpbl9jb2xvcicpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgc2V0U2FtcGxlQ29sb3IoJCh0aGlzKSk7XG4gICAgfSk7XG5cbiAgICBzZXRTYW1wbGVJY29uKCQoJ2lucHV0I2RvbWFpbl9pY29uJyksICQoJy5kb21haW4taWNvbi1zYW1wbGUnKSk7XG5cbiAgICAkKCdpbnB1dCNkb21haW5faWNvbicpLm9uKCdpbnB1dCcsIGZ1bmN0aW9uKCkge1xuICAgICAgICBzZXRTYW1wbGVJY29uKCQodGhpcyksICQoJy5kb21haW4taWNvbi1zYW1wbGUnKSk7XG4gICAgfSk7XG59KTtcblxuZnVuY3Rpb24gc2V0U2FtcGxlQ29sb3Ioc2VsZWN0b3IpIHtcbiAgICBjb25zdCBzZWxlY3RlZENvbG9yID0gc2VsZWN0b3IudmFsKCk7XG5cbiAgICBjb25zdCBzYW1wbGVDb2xvciA9ICQoJy5kb21haW4tY29sb3Itc2FtcGxlJyk7XG4gICAgY29uc3QgYWN0dWFsQ29sb3IgPSBzYW1wbGVDb2xvci5hdHRyKCdkYXRhLXNlbGVjdGVkJyk7XG5cbiAgICBpZiAoYWN0dWFsQ29sb3IpIHtcbiAgICAgICAgc2FtcGxlQ29sb3IucmVtb3ZlQ2xhc3MoYWN0dWFsQ29sb3IpO1xuICAgIH1cbiAgICBzYW1wbGVDb2xvci5hZGRDbGFzcyhzZWxlY3RlZENvbG9yKTtcbiAgICBzYW1wbGVDb2xvci5hdHRyKHsnZGF0YS1zZWxlY3RlZCc6IHNlbGVjdGVkQ29sb3J9KTtcbn1cblxuZnVuY3Rpb24gc2V0U2FtcGxlSWNvbihzZWxlY3Rvciwgc2FtcGxlSWNvbikge1xuICAgIGNvbnN0IHNlbGVjdGVkSWNvbiA9IHNlbGVjdG9yLnZhbCgpO1xuXG4gICAgY29uc3QgYWN0dWFsSWNvbiA9IHNhbXBsZUljb24uYXR0cignZGF0YS1zZWxlY3RlZCcpO1xuXG4gICAgaWYgKGFjdHVhbEljb24pIHtcbiAgICAgICAgc2FtcGxlSWNvbi5maW5kKCcuaWNvbicpLnJlbW92ZUNsYXNzKGBieC0ke2FjdHVhbEljb259YCk7XG4gICAgICAgIHNhbXBsZUljb24uZmluZCgnLmljb24nKS5yZW1vdmVDbGFzcyhgYnhzLSR7YWN0dWFsSWNvbn1gKTtcbiAgICAgICAgc2FtcGxlSWNvbi5maW5kKCcuaWNvbicpLnJlbW92ZUNsYXNzKGBieGwtJHthY3R1YWxJY29ufWApO1xuICAgIH1cblxuICAgIHNhbXBsZUljb24uZmluZCgnLmljb24nKS5hZGRDbGFzcyhgYnhsLSR7c2VsZWN0ZWRJY29ufWApO1xuICAgIHNhbXBsZUljb24uZmluZCgnLmljb24nKS5hZGRDbGFzcyhgYnhzLSR7c2VsZWN0ZWRJY29ufWApO1xuICAgIHNhbXBsZUljb24uZmluZCgnLmljb24nKS5hZGRDbGFzcyhgYngtJHtzZWxlY3RlZEljb259YCk7XG5cbiAgICBzYW1wbGVJY29uLmF0dHIoeydkYXRhLXNlbGVjdGVkJzogc2VsZWN0ZWRJY29ufSk7XG59IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIl0sInNvdXJjZVJvb3QiOiIifQ==