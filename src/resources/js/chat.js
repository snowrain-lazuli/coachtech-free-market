document.addEventListener('DOMContentLoaded', function () {
    const chatInput = document.querySelector('.chat-input');
    if (!chatInput) return;

    const paymentId = chatInput.dataset.paymentId;
    const storageKey = 'chat_draft_' + paymentId;

    // 初期値を復元
    if (localStorage.getItem(storageKey)) {
        chatInput.value = localStorage.getItem(storageKey);
    }

    // 入力時に保存
    chatInput.addEventListener('input', function () {
        localStorage.setItem(storageKey, chatInput.value);
    });

});
