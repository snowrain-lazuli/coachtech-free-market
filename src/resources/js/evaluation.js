document.addEventListener('DOMContentLoaded', function () {

    // -------------------------
    // ★評価の初期化
    // -------------------------
    function initStarRating() {
        const stars = document.querySelectorAll('.modal .star-rating .star');
        const ratingInput = document.getElementById('rating');

        if (!stars.length || !ratingInput) return;

        stars.forEach((star, index) => {

            // クリックで評価をセット
            star.addEventListener('click', function () {
                ratingInput.value = index + 1;
                stars.forEach((s, i) => {
                    if (i <= index) s.classList.add('selected');
                    else s.classList.remove('selected');
                });
            });

            // ホバー時に色を変える
            star.addEventListener('mouseover', function () {
                stars.forEach((s, i) => {
                    if (i <= index) s.classList.add('selected');
                    else s.classList.remove('selected');
                });
            });

            // ホバーアウト時に現在の評価を表示
            star.addEventListener('mouseout', function () {
                const currentRating = parseInt(ratingInput.value) || 0;
                stars.forEach((s, i) => {
                    if (i < currentRating) s.classList.add('selected');
                    else s.classList.remove('selected');
                });
            });
        });
    }

    // モーダルが存在する場合に初期化
    const modal = document.querySelector('.modal-overlay');
    if (modal) {
        initStarRating();
    }

});
