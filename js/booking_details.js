// Scroll to booking section if exists
window.addEventListener('load', function () {
    const section = document.getElementById('booking-details-section');
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
});

// Handle cancel booking form submission
document.getElementById('cancelBookingForm')?.addEventListener('submit', function (e) {
    e.preventDefault();
    const form = this;
    const bookingId = form.querySelector('input[name="booking_id"]').value;

    fetch('booking_cancel.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `booking_id=${encodeURIComponent(bookingId)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const badge = document.querySelector('.status-badge');
            badge.textContent = 'Cancelled';
            badge.classList.remove('bg-warning', 'bg-success');
            badge.classList.add('bg-danger');

            const modal = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
            modal.hide();

            const cancelBtn = document.querySelector('[data-bs-target="#cancelModal"]');
            if (cancelBtn) cancelBtn.remove();
        } else {
            alert(data.message || 'Failed to cancel.');
        }
    })
    .catch(err => {
        alert('Error occurred.');
        console.error(err);
    });
});

// ⭐ Handle star rating selection
document.querySelectorAll('.rating-star input').forEach((input) => {
    input.addEventListener('change', function () {
        const allStars = this.closest('.star-rating').querySelectorAll('i');
        const value = parseInt(this.value);

        allStars.forEach((star, index) => {
            if (index < value) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
        input.checked = true;
    });
});
// Hide notification
setTimeout(function () {
    const alertBox = document.getElementById('feedback-alert');
    if (alertBox) {
        alertBox.classList.add('fade');
        alertBox.style.opacity = 0;
        setTimeout(() => alertBox.remove(), 500);
    }
}, 3000);


