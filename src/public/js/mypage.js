/******/ (() => { // webpackBootstrap
/*!********************************!*\
  !*** ./resources/js/mypage.js ***!
  \********************************/
document.addEventListener('DOMContentLoaded', function () {
  var ratings = document.querySelectorAll('.mypage__account-rating');
  ratings.forEach(function (star) {
    var rating = parseFloat(star.dataset.rating) || 0;
    var percentage = rating / 5 * 100;
    var inner = star.querySelector('.stars-inner');
    if (inner) {
      inner.style.width = "".concat(percentage, "%");
    }
  });
});
/******/ })()
;