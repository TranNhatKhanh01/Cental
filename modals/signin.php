<!-- Signin Modal Start -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="loginModalLabel">Sign In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loginForm">
                    <div class="mb-2">
                        <label for="loginEmail" class="form-label">Email or Phone Number</label>
                        <input type="text" class="form-control" id="loginEmail" name="email_or_phone" placeholder="Enter your email or phone" required>
                    </div>
                    <div class="mb-2">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required>
                    </div>

                    <!-- Remember & Forgot Password in same row -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check m-0">
                            <input type="checkbox" class="form-check-input" id="rememberLogin">
                            <label class="form-check-label" for="rememberLogin">Remember me</label>
                        </div>
                        <a href="#" class="small text-decoration-none" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                            Forgot Password?
                        </a>
                    </div>

                    <div id="loginError" class="form-text text-danger mb-3 d-none"></div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>

                <div class="mt-3 text-center">
                    Don't have an account? 
                    <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Signin Modal End -->