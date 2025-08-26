/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/chat.js ***!
  \******************************/
document.addEventListener('DOMContentLoaded', function () {
  var chatInput = document.querySelector('.chat-input');
  if (!chatInput) return;
  var paymentId = chatInput.dataset.paymentId;
  var storageKey = 'chat_draft_' + paymentId;

  // 初期値を復元
  if (localStorage.getItem(storageKey)) {
    chatInput.value = localStorage.getItem(storageKey);
  }

  // 入力時に保存
  chatInput.addEventListener('input', function () {
    localStorage.setItem(storageKey, chatInput.value);
  });
});
/******/ })()
;