document.addEventListener('DOMContentLoaded', () => {
    const ratings = document.querySelectorAll('.mypage__account-rating');

    ratings.forEach(star => {
        const rating = parseFloat(star.dataset.rating) || 0;
        const percentage = (rating / 5) * 100;

        const inner = star.querySelector('.stars-inner');
        if(inner) {
            inner.style.width = `${percentage}%`;
        }
    });
});
