// Scroll back to form section after submitting
document.getElementById('info-form')?.addEventListener('submit', () => {
    window.location.hash = 'info-form';
});
document.getElementById('change-password')?.addEventListener('submit', () => {
    window.location.hash = 'change-password';
});

// Auto-fade and remove alert messages after 4 seconds
document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert-info");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    });
});

// Scroll to the appropriate section if hash exists
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.hash === "#info-form") {
        const el = document.querySelector("#info-form");
        if (el) {
            el.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    }
});
