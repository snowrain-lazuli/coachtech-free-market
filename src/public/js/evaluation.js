/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./resources/js/evaluation.js ***!
  \************************************/
document.addEventListener('DOMContentLoaded', function () {
  // -------------------------
  // ★評価の初期化
  // -------------------------
  function initStarRating() {
    var stars = document.querySelectorAll('.modal .star-rating .star');
    var ratingInput = document.getElementById('rating');
    if (!stars.length || !ratingInput) return;
    stars.forEach(function (star, index) {
      // クリックで評価をセット
      star.addEventListener('click', function () {
        ratingInput.value = index + 1;
        stars.forEach(function (s, i) {
          if (i <= index) s.classList.add('selected');else s.classList.remove('selected');
        });
      });

      // ホバー時に色を変える
      star.addEventListener('mouseover', function () {
        stars.forEach(function (s, i) {
          if (i <= index) s.classList.add('selected');else s.classList.remove('selected');
        });
      });

      // ホバーアウト時に現在の評価を表示
      star.addEventListener('mouseout', function () {
        var currentRating = parseInt(ratingInput.value) || 0;
        stars.forEach(function (s, i) {
          if (i < currentRating) s.classList.add('selected');else s.classList.remove('selected');
        });
      });
    });
  }

  // モーダルが存在する場合に初期化
  var modal = document.querySelector('.modal-overlay');
  if (modal) {
    initStarRating();
  }
});
/******/ })()
;