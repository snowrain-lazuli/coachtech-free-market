import axios from 'axios';
import { loadStripe } from '@stripe/stripe-js';

document.addEventListener('DOMContentLoaded', async () => {
    const stripePublicKeyInput = document.getElementById('stripe-public-key');
    const itemIdInput = document.getElementById('item-id');
    const form = document.getElementById('payment-form');

    if (!stripePublicKeyInput || !itemIdInput || !form) return;

    const stripePublicKey = stripePublicKeyInput.value;
    const itemId = itemIdInput.value;

    // フォームに埋め込まれた hidden の _token を取得（meta は不要）
    const csrfToken = form.querySelector('input[name="_token"]')?.value || '';

    // axios に CSRF を設定（以降のリクエストは自動でヘッダ付与）
    if (csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }

    const stripe = await loadStripe(stripePublicKey);
    const elements = stripe.elements();

    // CardElement（郵便番号は非表示）
    const card = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                '::placeholder': { color: '#a0aec0' },
            }
        }
    });
    card.mount('#stripe-element');

    const cardholderName = document.getElementById('cardholder-name');
    const errorBox = document.getElementById('stripe-errors');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorBox.textContent = '';

        try {
            // PaymentIntent 作成（body に _token を含める：冗長だけど確実）
            const { data } = await axios.post(`/purchase/${itemId}/payment-intent`, {
                _token: csrfToken
            });

            const clientSecret = data.clientSecret;

            // 決済実行（カード情報 + 名義）
            const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card,
                    billing_details: { name: cardholderName.value || '' }
                }
            });

            if (error) {
                console.error('Stripe Error:', error);
                errorBox.textContent = error.message;
                return;
            }

            if (paymentIntent.status === 'succeeded') {
                // 決済成功 → サーバに記録
                const res = await axios.post('/purchase/payment/success', {
                    item_id: itemId,
                    payment_intent_id: paymentIntent.id,
                    _token: csrfToken
                });

                // 取引チャットへ遷移（コントローラが返すURL）
                if (res.data?.redirect) {
                    window.location.href = res.data.redirect;
                } else {
                    // 念のためのフォールバック
                    window.location.href = `/purchases/${paymentIntent.id}/chat`;
                }
            }
        } catch (err) {
            console.error('Request Error:', err);
            // Laravel からのメッセージ or axios のメッセージ or 汎用文言
            errorBox.textContent = err?.response?.data?.message || err.message || '決済処理中にエラーが発生しました。';
        }
    });
});
