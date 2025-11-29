// home.js - full file with validation fixed
(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);

    new WOW().init();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 200) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });

    // Carousel
    $(".categories-carousel").owlCarousel({
      
        autoplay: true,
        smartSpeed: 1000,
        dots: false,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{ items:1 },
            576:{ items:1 },
            768:{ items:1 },
            992:{ items:2 },
            1200:{ items:3 }
        }
    });

    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav : false,
        responsiveClass: true,
        responsive: {
            0:{ items:1 },
            576:{ items:1 },
            768:{ items:1 },
            992:{ items:2 },
            1200:{ items:2 }
        }
    });

    $('[data-toggle="counter-up"]').counterUp({
        delay: 5,
        time: 2000
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });

})(jQuery);

// --- Custom JavaScript ---
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("reservationForm");

    // Book now handler
    const bookButtons = document.querySelectorAll(".book-now-btn");
    bookButtons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const carId = this.dataset.carId;
            const carName = this.dataset.carName;
            const activeCarousel = document.querySelector(".carousel-item.active");
            const form = activeCarousel.querySelector(".booking-form");
            const nameSpan = form.querySelector(".selected-car-name");
            const hiddenInput = form.querySelector(".car-type-input");
            const clearBtn = form.querySelector(".clear-car");
            const selectedBox = form.querySelector(".selected-car");
            nameSpan.textContent = carName;
            hiddenInput.value = carId;
            hiddenInput.defaultValue = carId;
            clearBtn.style.display = "inline-block";
            selectedBox?.classList.remove("flash-border");
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    });

    // Clear car → reload
    document.querySelectorAll(".clear-car").forEach(clearBtn => {
        clearBtn.addEventListener("click", function () {
            const url = new URL(window.location.href);
            url.searchParams.delete("car_id");
            url.searchParams.delete("error");
            window.location.href = url.toString();
        });
    });

    // Scroll to continue-reservation
    if (window.location.hash === "#continue-reservation") {
        const el = document.getElementById("continue-reservation");
        if (el) {
            setTimeout(() => {
                el.scrollIntoView({ behavior: "smooth" });
            }, 300);
        }
    }

    // Restore scroll after reload
    const scrollPos = sessionStorage.getItem("scrollPos");
    if (scrollPos !== null) {
        window.scrollTo(0, parseInt(scrollPos));
        sessionStorage.removeItem("scrollPos");
    }

    // Payment toggle
    const payNow = document.getElementById("pay_now");
    const payLater = document.getElementById("pay_later");
    const paymentBox = document.getElementById("payment-box");
    function togglePaymentBox() {
        if (payNow?.checked) {
            paymentBox.style.display = "block";
            paymentBox.scrollIntoView({ behavior: "smooth", block: "center" });
        } else {
            paymentBox.style.display = "none";
        }
    }
    payNow?.addEventListener("change", togglePaymentBox);
    payLater?.addEventListener("change", togglePaymentBox);
    togglePaymentBox();

    // Init Flatpickr
    flatpickr("#start_date", { dateFormat: "Y-m-d", minDate: "today" });
    flatpickr("#end_date", { dateFormat: "Y-m-d", minDate: "today" });

    // Load booking schedule
    const carInput = document.querySelector('input[name="car_id"]');
    const scheduleList = document.getElementById("car-schedule-list");
    if (carInput && scheduleList && carInput.value) {
        fetch(`get_car_schedule.php?car_id=${carInput.value}`)
            .then(res => res.json())
            .then(data => {
                scheduleList.innerHTML = "";
                if (data.length === 0) {
                    scheduleList.innerHTML = "<li>No upcoming booking.</li>";
                } else {
                    data.forEach(booking => {
                        const start = new Date(booking.start_date);
                        const end = new Date(booking.end_date);      

                        const formatDate = dt => {
                            const d = dt.toLocaleDateString();
                            const h = dt.getHours().toString().padStart(2, '0');
                            const m = dt.getMinutes().toString().padStart(2, '0');
                            return `${h}:${m} ${d}`;
                        };

                        const li = document.createElement("li");
                        li.innerHTML = `🕓 <strong>${formatDate(start)}</strong> → <strong>${formatDate(end)}</strong>`;
                        scheduleList.appendChild(li);
                    });
                }
            })
            .catch(() => {
                scheduleList.innerHTML = "<li class='text-danger'>Failed to load booking schedule.</li>";
            });
    }

    // Form validation
    form?.addEventListener("submit", function (e) {
    e.preventDefault();

    let isValid = true;

    const carId = document.getElementById("car_id");
    const pickup = document.getElementById("pickup");
    const dropoff = document.getElementById("dropoff");
    const startDate = document.getElementById("start_date");
    const startHour = document.getElementById("start_hour");
    const startMinute = document.getElementById("start_minute");
    const endDate = document.getElementById("end_date");
    const endHour = document.getElementById("end_hour");
    const endMinute = document.getElementById("end_minute");

        // Clear previous validation errors when user edits
    [startDate, startHour, startMinute, endDate, endHour, endMinute].forEach(input => {
        input.addEventListener("input", () => input.setCustomValidity(""));
    });

    const paymentMethod = form.querySelector('input[name="payment_method"]:checked');
    const agreeTerms = document.getElementById("agree_terms");

    [carId, pickup, dropoff, startDate, startHour, startMinute, endDate, endHour, endMinute].forEach(input => {
        input.setCustomValidity('');
    });

    if (!carId.value) { carId.setCustomValidity("Please select a car."); carId.reportValidity(); isValid = false; }
    if (!pickup.value.trim()) { pickup.setCustomValidity("Please enter pickup location."); pickup.reportValidity(); isValid = false; }
    if (!dropoff.value.trim()) { dropoff.setCustomValidity("Please enter dropoff location."); dropoff.reportValidity(); isValid = false; }
    if (!startDate.value) { startDate.setCustomValidity("Start date is required."); startDate.reportValidity(); isValid = false; }
    if (!startHour.value) { startHour.setCustomValidity("Start hour is required."); startHour.reportValidity(); isValid = false; }
    if (!startMinute.value) { startMinute.setCustomValidity("Start minute is required."); startMinute.reportValidity(); isValid = false; }
    if (!endDate.value) { endDate.setCustomValidity("End date is required."); endDate.reportValidity(); isValid = false; }
    if (!endHour.value) { endHour.setCustomValidity("End hour is required."); endHour.reportValidity(); isValid = false; }
    if (!endMinute.value) { endMinute.setCustomValidity("End minute is required."); endMinute.reportValidity(); isValid = false; }
    if (!paymentMethod) { alert("Please choose a payment method."); isValid = false; }
    if (!agreeTerms.checked) { alert("You must agree to the terms."); isValid = false; }

    if (isValid) {
        const now = new Date();
        now.setSeconds(0, 0);
        const start = new Date(`${startDate.value}T${startHour.value.padStart(2, '0')}:${startMinute.value.padStart(2, '0')}`);
        const end = new Date(`${endDate.value}T${endHour.value.padStart(2, '0')}:${endMinute.value.padStart(2, '0')}`);

        let dateValid = true;

        if (isNaN(start.getTime())) {
            startDate.setCustomValidity("Start datetime is invalid.");
            startDate.reportValidity();
            dateValid = false;
        }

        if (isNaN(end.getTime())) {
            endDate.setCustomValidity("End datetime is invalid.");
            endDate.reportValidity();
            dateValid = false;
        }

        if (dateValid) {
            const oneHourLater = new Date(now.getTime() + 60 * 60 * 1000);
            if (start < oneHourLater) {
                startHour.setCustomValidity("Start time must be at least 1 hour from now.");
                startHour.reportValidity();
                isValid = false;
            }

            const oneHourAfterStart = new Date(start.getTime() + 60 * 60 * 1000);
            if (end < oneHourAfterStart) {
                endHour.setCustomValidity("End time must be at least 1 hour after start.");
                endHour.reportValidity();
                isValid = false;
            }

            if (start > end) {
                startDate.setCustomValidity("Start must be before or equal to end.");
                startDate.reportValidity();
                isValid = false;
            }
        } else {
            isValid = false;
        }
    }

   if (isValid) {
        const formData = new FormData(form);
        
        sessionStorage.setItem("scrollPos", window.scrollY);

        fetch("booking_process.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === "success") {
                window.location.href = "layout.php?page=home&success=1";
            } else if (result.status === "error") {
                alert(result.message);
            }
        })
        .catch(() => {
            alert("Server connection error.");
        });
    }
});
});
