// Sign In
document.getElementById('loginForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const emailOrPhone = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    const errorDiv = document.getElementById('loginError');

    errorDiv.classList.add('d-none');
    errorDiv.textContent = '';

    fetch('signin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `login=${encodeURIComponent(emailOrPhone)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const goToHistory = sessionStorage.getItem("goToHistory");
            sessionStorage.removeItem("goToHistory");

            if (goToHistory === "1") {
                window.location.href = 'layout.php?page=history';
            } else {
                window.location.reload();
            }
        } else {
            errorDiv.textContent = data.message;
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(() => {
        errorDiv.textContent = "An error occurred. Please try again.";
        errorDiv.classList.remove('d-none');
    });
});

// Sign Up
document.getElementById('signupForm')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const fullName = document.getElementById('signupName').value.trim();
    const email = document.getElementById('signupEmail').value.trim();
    const phone = document.getElementById('signupPhone').value.trim();
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('signupConfirmPassword').value;

    const phoneError = document.getElementById('phoneError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    const signupError = document.getElementById('signupError');

    [phoneError, passwordError, confirmPasswordError, signupError].forEach(div => {
        div.classList.add('d-none');
        div.textContent = '';
    });

    const strongPwdRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
    let valid = true;

    if (!/^[0-9]{10}$/.test(phone)) {
        phoneError.textContent = "Phone number must be 10 digits.";
        phoneError.classList.remove('d-none');
        valid = false;
    }

    if (!strongPwdRegex.test(password)) {
        passwordError.textContent = "Password must include uppercase, lowercase, number, special character, and be at least 8 characters.";
        passwordError.classList.remove('d-none');
        valid = false;
    }

    if (password !== confirmPassword) {
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.classList.remove('d-none');
        valid = false;
    }

    if (!valid) return;

    fetch('signup.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `full_name=${encodeURIComponent(fullName)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.reload();
        } else {
            signupError.textContent = data.message || "Registration failed.";
            signupError.classList.remove('d-none');
        }
    })
    .catch(() => {
        signupError.textContent = "An error occurred. Please try again.";
        signupError.classList.remove('d-none');
    });
});

// History
document.addEventListener('DOMContentLoaded', function () {
    const historyBtn = document.getElementById('historyLink');
    if (historyBtn) {
        historyBtn.addEventListener('click', function (e) {
            e.preventDefault();

            sessionStorage.setItem("goToHistory", "1");

            fetch('signin_check.php')
                .then(response => response.json())
                .then(data => {
                    if (data.loggedIn) {
                        window.location.href = 'layout.php?page=history';
                    } else {
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    }
                })
                .catch(() => {
                    alert("Could not check login status.");
                });
        });
    }

    // Sign Out
    document.body.addEventListener('click', function (e) {
        if (e.target.closest('.sign-out')) {
            e.preventDefault();
            fetch('signout.php')
                .then(() => {
                    window.location.href = 'layout.php?page=home';
                });
        }
    });

    // Hide navbar on scroll
    const navbar = document.querySelector('.nav-bar');
    let lastScrollTop = 0;
    window.addEventListener('scroll', function () {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        navbar.style.top = (currentScroll > lastScrollTop) ? '-100px' : '0';
        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
    }, false);
});
