// Change map when selecting different campus
function changeMap(location) {
    const map = document.getElementById("map-frame");
    if (location === "cs1") {
        map.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3913.709553396942!2d105.72885387587061!3d10.013066189932079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a089c191c9270b%3A0x3c10c29b8cb0e5cf!2sGreenwich%20Vi%E1%BB%87t%20Nam%20-%20C%C6%A1%20s%E1%BB%9F%20C%E1%BA%A7n%20Th%C6%A1%201!5e0!3m2!1sen!2s!4v1717292740000!5m2!1sen!2s";
    } else if (location === "cs2") {
        map.src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1964.4270592861467!2d105.77687877109139!3d10.028894699123008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a062a8990f568d%3A0x2a22d599b2c06b23!2sGreenwich%20Vi%E1%BB%87t%20Nam!5e0!3m2!1sen!2s!4v1748859406463!5m2!1sen!2s";
    }
}

// Form validation
document.getElementById("contactForm")?.addEventListener("submit", function(e) {
    let valid = true;

    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    const fields = [
        { id: "name", name: "Name" },
        { id: "email", name: "Email" },
        { id: "phone", name: "Phone" },
        { id: "project", name: "Project" },
        { id: "subject", name: "Subject" },
        { id: "message", name: "Message" }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        const value = input.value.trim();

        if (!value) {
            valid = false;
            input.classList.add("is-invalid");

            const feedback = document.createElement("div");
            feedback.className = "invalid-feedback";
            feedback.textContent = `${field.name} is required.`;

            input.parentNode.appendChild(feedback);
        }

        if (field.id === "email" && value) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(value)) {
                valid = false;
                input.classList.add("is-invalid");

                const feedback = document.createElement("div");
                feedback.className = "invalid-feedback";
                feedback.textContent = "Invalid email format.";
                input.parentNode.appendChild(feedback);
            }
        }

        if (field.id === "phone" && value) {
            const phonePattern = /^\d{10}$/;
            if (!phonePattern.test(value)) {
                valid = false;
                input.classList.add("is-invalid");

                const feedback = document.createElement("div");
                feedback.className = "invalid-feedback";
                feedback.textContent = "Phone number must be exactly 10 digits.";
                input.parentNode.appendChild(feedback);
            }
        }
    });

    if (!valid) {
        e.preventDefault();
    }
});
