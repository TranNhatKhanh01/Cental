<!-- Signup Modal Start -->
    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content p-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="signupForm">
                    <div class="mb-3">
                        <label for="signupName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="signupName" name="full_name" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="signupPhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="signupPhone" name="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" maxlength="10" required>
                        <div id="phoneError" class="form-text text-danger d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Create a password" required>
                        <div id="passwordError" class="form-text text-danger d-none"></div>
                    </div>

                    <div class="mb-3">
                        <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="signupConfirmPassword" placeholder="Repeat your password" required>
                        <div id="confirmPasswordError" class="form-text text-danger d-none"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    <div id="signupError" class="form-text text-danger text-center mt-2 d-none"></div>
                    </form>
                    <div class="mt-3 text-center">
                        Already have an account? 
                        <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Signup Modal End -->