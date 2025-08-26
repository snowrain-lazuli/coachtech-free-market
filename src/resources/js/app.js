require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    function updateContent() {
        var selectBox = document.querySelector('#purchase__pay-select');
        var selectedValue = selectBox.value;
        var outputElement = document.querySelector('.purchase__status-changed input');

        // セレクトボックスのテキストに"✓"を追加
        Array.from(selectBox.options).forEach(function(option) {
            option.textContent = option.textContent.replace("✓ ", "");
        });

        var selectedOption = selectBox.options[selectBox.selectedIndex];
        if (selectedOption.value) {
            selectedOption.textContent = "✓ " + selectedOption.textContent.trim();
        }

        // 支払い方法の選択肢に応じて表示を変更
        var outputText = '';
        if (selectedValue === '1') {
            outputText = 'コンビニ払い';
        } else if (selectedValue === '2') {
            outputText = 'カード支払い';
        } else {
            outputText = '未選択';
        }

        // 即時に値を反映
        if (outputElement) {
            outputElement.value = outputText;
        }
    }

    var selectBox = document.querySelector('#purchase__pay-select');
    selectBox.addEventListener('change', updateContent);

    // 初期状態の更新
    updateContent();
});

document.addEventListener('DOMContentLoaded', function () {
    function updateCondition() {
        var selectBox = document.querySelector('#item_condition');
        var selectedValue = selectBox.value;

        // セレクトボックスのテキストに"✓"を追加
        Array.from(selectBox.options).forEach(function(option) {
            option.textContent = option.textContent.replace("✓ ", "");
        });

        var selectedOption = selectBox.options[selectBox.selectedIndex];
        if (selectedOption.value) {
            selectedOption.textContent = "✓ " + selectedOption.textContent.trim();
        }
    }

    // item_conditionセレクトボックスの変更イベント
    var selectBox = document.querySelector('#item_condition');
    selectBox.addEventListener('change', updateCondition);

    // 初期状態の更新
    updateCondition();
});

document.addEventListener("DOMContentLoaded", function () {
    // 事前にbladeで埋め込まれた情報を取得
    const stripePublicKey = document.getElementById("stripe-public-key").value;
    const clientSecret = document.getElementById("client-secret").value;

    // Stripeインスタンスを作成
    const stripe = Stripe(stripePublicKey);
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#stripe-element");

    const form = document.getElementById("payment-form");
    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
            },
        });

        if (error) {
            const errorElement = document.getElementById("stripe-errors");
            errorElement.textContent = error.message;
        } else if (paymentIntent.status === "succeeded") {
            window.location.href = "/payment/stripe";
        }
    });
});
