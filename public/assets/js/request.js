document.addEventListener('DOMContentLoaded', function () {
    const rateButtons = document.querySelectorAll('.rate-btn');
    rateButtons.forEach(button => {
        button.addEventListener('click', function () {
            const serviceId = button.dataset.id;
            document.querySelector('#service_id').value = serviceId;
        });
    });

    const rangeInput = document.querySelector('.form-range');
    const starsContainer = document.querySelector('.rating-stars');
    rangeInput.addEventListener('input', function () {
        const rating = this.value;
        const stars = '&#9733;'.repeat(rating); 
        starsContainer.innerHTML = stars;
    });

    const submitBtn = document.querySelector('#submitRatingBtn');
    submitBtn.addEventListener('click', function () {
        const rating = rangeInput.value;
        document.querySelector('#rating').value = rating; 
    });
});