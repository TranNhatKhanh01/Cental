<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Cental - Car Rent Website</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>
    
    <body> 
        <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $servername = "localhost";
            $username   = "root";
            $password   = "";
            $dbname     = "car_rental";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $user_id                = $_SESSION['user']['id'] ?? 0;
            $password_message       = null;
            $profile_message        = null;
            $avatar_message         = null;
            $phone_error            = null;
            $current_password_error = null;
            $new_password_error     = null;
            $confirm_password_error = null;

            // Redirect to login if not logged in
            if (!$user_id) {
                echo "<script>window.location.href = 'layout.php?page=login';</script>";
                exit;
            }

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST['action'])) {
                    if ($_POST['action'] === 'change_password') {
                        $current = $_POST['current_password'];
                        $new = $_POST['new_password'];
                        $confirm = $_POST['confirm_password'];

                        $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $stmt->bind_result($hashed);
                        $stmt->fetch();
                        $stmt->close();

                        if (!password_verify($current, $hashed)) {
                            $current_password_error = "Current password is incorrect.";
                        } elseif ($new === $current) {
                            $new_password_error = "New password must be different from the current password.";
                        } elseif ($new !== $confirm) {
                            $confirm_password_error = "New passwords do not match.";
                        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/", $new)) {
                            $new_password_error = "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
                        } else {
                            $new_hashed = password_hash($new, PASSWORD_DEFAULT);
                            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
                            $stmt->bind_param("si", $new_hashed, $user_id);
                            $stmt->execute();
                            $stmt->close();

                            $password_message = "Password changed successfully.";
                        }
                    } elseif ($_POST['action'] === 'upload_avatar' && isset($_FILES['avatar'])) {
                        $target_dir = "uploads/avatars/";
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0777, true);
                        }

                        $file_tmp = $_FILES['avatar']['tmp_name'];
                        $file_name = basename($_FILES['avatar']['name']);
                        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                        if (in_array($file_ext, $allowed)) {
                            $new_filename = uniqid("avatar_", true) . "." . $file_ext;
                            $target_file = $target_dir . $new_filename;

                            if (move_uploaded_file($file_tmp, $target_file)) {
                                $stmt = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
                                $stmt->bind_param("si", $new_filename, $user_id);
                                $stmt->execute();
                                $stmt->close();
                                $avatar_message = "Avatar updated successfully.";
                                $_SESSION['image'] = $new_filename;
                            } else {
                                $avatar_message = "Failed to upload file.";
                            }
                        } else {
                            $avatar_message = "Invalid file type. Please upload an image.";
                        }
                    }
                } else {
                    $full_name = trim($_POST['full_name'] ?? '');
                    $phone = trim($_POST['phone'] ?? '');
                    $address = trim($_POST['address'] ?? '');

                    if (!preg_match('/^[0-9]{10}$/', $phone)) {
                        $phone_error = "Invalid phone number. Must be 10 digits.";
                    } else {
                        $stmt_check = $conn->prepare("SELECT id FROM users WHERE phone = ? AND id != ?");
                        $stmt_check->bind_param("si", $phone, $user_id);
                        $stmt_check->execute();
                        $stmt_check->store_result();

                        if ($stmt_check->num_rows > 0) {
                            $phone_error = "Phone number is already in use.";
                        } else {
                            $stmt_update = $conn->prepare("UPDATE users SET full_name = ?, phone = ?, address = ? WHERE id = ?");
                            $stmt_update->bind_param("sssi", $full_name, $phone, $address, $user_id);
                            $stmt_update->execute();
                            $stmt_update->close();

                            $profile_message = "Profile updated successfully.";
                        }
                        $stmt_check->close();
                    }
                }
            }

            $stmt = $conn->prepare("SELECT full_name, email, phone, address, image FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            $conn->close();

            if (!$user) {
                echo "<div class='alert alert-danger text-center mt-5'>User not found or not logged in.</div>";
                exit;
            }
        ?>

        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5 wow fadeInDown" data-wow-delay="0.1s">
                <h4 class="text-white display-4 mb-4">Profile</h4>
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="layout.php">Home</a></li>
                    <li class="breadcrumb-item active text-primary" id="info-profile">Profile</li>
                </ol>
            </div>
        </div>

        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 position-relative">
                    <div class="bg-light rounded p-4 p-md-5 shadow wow fadeInUp" data-wow-delay="0.2s">
                        <h3 class="text-primary mb-4 d-flex align-items-center"><i class="fas fa-user me-2"></i><strong>Personal Profile</strong></h3>
                        <div class="avatar-wrapper">
                        <div class="avatar-box">
                            <?php if (!empty($user['image'])): ?>
                                <img src="uploads/avatars/<?= htmlspecialchars($user['image']) ?>" class="avatar-img" alt="Avatar">
                            <?php else: ?>
                                <div class="avatar-placeholder">Avatar</div>
                            <?php endif; ?>
                            <div class="avatar-overlay" data-bs-toggle="modal" data-bs-target="#avatarModal">
                                <i class="fas fa-pen avatar-edit-btn"></i>
                            </div>
                        </div>
                    </div>
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($_POST['full_name'] ?? $user['full_name']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control <?= $phone_error ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_POST['phone'] ?? $user['phone']) ?>">
                                    <?php if ($phone_error): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($phone_error) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="1"><?= htmlspecialchars($_POST['address'] ?? $user['address']) ?></textarea>
                                </div>
                            </div>
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Save</button>
                            </div>
                            <?php if ($profile_message): ?>
                            <div class="alert alert-info mt-3 mb-0">
                                <?= $profile_message ?>
                            </div>
                            <?php endif; ?>
                            <?php if ($avatar_message): ?>
                            <div class="alert alert-info mt-3 mb-0">
                                <?= htmlspecialchars($avatar_message) ?>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>

                    <div class="bg-light rounded p-4 p-md-5 shadow mt-5 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="text-warning mb-4"><i class="fas fa-key me-2"></i><strong>Change Password</strong></h4>
                        <form method="POST" id="change-password">
                            <input type="hidden" name="action" value="change_password">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control <?= $current_password_error ? 'is-invalid' : '' ?>" required>
                                <?php if ($current_password_error): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($current_password_error) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control <?= $new_password_error ? 'is-invalid' : '' ?>" required>
                                <?php if ($new_password_error): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($new_password_error) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control <?= $confirm_password_error ? 'is-invalid' : '' ?>" required>
                                <?php if ($confirm_password_error): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($confirm_password_error) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-warning text-dark px-4"><i class="fas fa-key me-1"></i> Change</button>
                            </div>
                        </form>
                        <?php if ($password_message): ?>
                        <div class="alert alert-info mt-3 mb-0">
                            <?= $password_message ?>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- Avatar Upload Modal -->
        <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="avatarModalLabel">Upload New Avatar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="avatar" accept="image/*" class="form-control" required>
                            <input type="hidden" name="action" value="upload_avatar">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="js/profile.js"></script>
    </body>
</html>