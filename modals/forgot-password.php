<!-- Forgot Password Modal Start -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="forgotPasswordLabel">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm">
                    <div class="mb-3">
                        <label for="forgotEmail" class="form-label">Enter your registered Email</label>
                        <input type="email" class="form-control" id="forgotEmail" name="email" placeholder="you@example.com" required>
                    </div>
                    <div id="forgotError" class="form-text text-danger mb-3 d-none"></div>
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>
                <div class="mt-3 text-center">
                    Remembered your password? 
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Forgot Password Modal End -->

<script>
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const errorEl = document.getElementById('forgotError');

    fetch('forgot-password.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            alert(data.message + "\nReset link: " + data.link);
            this.reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
            modal.hide();
        } else {
            errorEl.classList.remove('d-none');
            errorEl.textContent = data.message;
        }
    })
    .catch(err => {
        errorEl.classList.remove('d-none');
        errorEl.textContent = "Network/server error. Check console.";
        console.error(err);
    });
});

</script>