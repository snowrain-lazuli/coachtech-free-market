document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('purchase__pay-select');
    const displayInput = document.getElementById('payment-method-display');
    const hiddenInput = document.getElementById('payment-method-hidden');
    const purchaseForm = document.getElementById('purchase-form');

    if (!select || !displayInput || !hiddenInput || !purchaseForm) return;

    function updateDisplay() {
        let text = '';
        if (select.value === '1') text = 'コンビニ払い';
        if (select.value === '2') text = 'カード支払い';
        displayInput.value = text;
        hiddenInput.value = select.value;
    }

    select.addEventListener('change', updateDisplay);
    updateDisplay();

    purchaseForm.addEventListener('submit', function (e) {
        if (!hiddenInput.value) {
            e.preventDefault();
            alert('支払い方法を選択してください');
            return;
        }

        if (hiddenInput.value === '2') {
            e.preventDefault();
            const itemId = purchaseForm.dataset.itemId || purchaseForm.action.split('/').pop();
            window.location.href = `/payment/stripe/${itemId}`;
        }
    });
});
