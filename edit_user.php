<?php
include "header.php";

$error = $success = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message']  = "User ID not specified.";
    $_SESSION['msg_type'] = "danger";
    header("Location: view_users.php"); exit();
}

$id   = intval($_GET['id']);
$user = getUserById($id);

if (!$user) {
    $_SESSION['message']  = "User not found.";
    $_SESSION['msg_type'] = "danger";
    header("Location: view_users.php"); exit();
}

if (isset($_POST['submit'])) {
    $name        = trim($_POST['name']);
    $email       = trim($_POST['email']);
    $password    = $_POST['password'];
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = "Name is required.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Valid email address is required.";
    } elseif (emailExists($email, $id)) {
        $error = "This email is already used by another user.";
    } else {
        // Handle image upload
        $image = $user['image']; // keep existing by default
        if (!empty($_FILES['image']['name'])) {
            $upload = uploadImage($_FILES['image'], $user['image']);
            if (is_array($upload) && isset($upload['error'])) {
                $error = $upload['error'];
            } else {
                $image = $upload;
            }
        }

        // Handle image removal
        if (isset($_POST['remove_image']) && $_POST['remove_image'] == '1') {
            if (!empty($user['image']) && file_exists(UPLOAD_DIR . $user['image'])) {
                unlink(UPLOAD_DIR . $user['image']);
            }
            $image = '';
        }

        if (empty($error)) {
            if (updateUser($id, $name, $email, $password, $description, $image)) {
                $_SESSION['message']  = "✅ User updated successfully!";
                $_SESSION['msg_type'] = "success";
                header("Location: view_users.php"); exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}

$imgUrl = getImageUrl($user['image']);
?>

<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-lg overflow-hidden">

                <!-- Card Header -->
                <div class="card-header text-white py-4 text-center border-0"
                     style="background: linear-gradient(135deg,#0891b2,#0e7490);">
                    <?php if ($imgUrl): ?>
                        <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Avatar"
                             class="avatar-circle avatar-lg mb-3 border border-3 border-white shadow">
                    <?php else: ?>
                        <div class="avatar-circle avatar-lg mb-3 mx-auto"
                             style="background:rgba(255,255,255,0.2);color:#fff;font-size:2rem;">
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <h2 class="fw-bold mb-1">Edit User</h2>
                    <p class="mb-0 opacity-75 small">Updating profile for <strong><?= htmlspecialchars($user['name']) ?></strong></p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="" method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="remove_image" id="removeImageFlag" value="0">

                        <!-- Current Photo + Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Profile Photo</label>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <?php if ($imgUrl): ?>
                                    <img src="<?= htmlspecialchars($imgUrl) ?>"
                                         id="currentPhoto"
                                         class="avatar-circle avatar-lg border border-2"
                                         style="border-color:#4f46e5!important;"
                                         alt="Current Photo">
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="removePhoto()">🗑 Remove Photo</button>
                                <?php else: ?>
                                    <div class="avatar-circle avatar-lg"
                                         style="background:#e0e7ff;color:#4f46e5;font-size:2rem;">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </div>
                                    <span class="text-muted small">No photo uploaded</span>
                                <?php endif; ?>
                            </div>

                            <div class="upload-zone" onclick="$('#imageInput').click()">
                                <div style="font-size:1.8rem;">📷</div>
                                <div class="fw-semibold mt-1">Click to upload new photo</div>
                                <div class="text-muted small">JPG, PNG, GIF, WEBP — Max 2 MB</div>
                                <input type="file" id="imageInput" name="image" accept="image/*">
                            </div>
                            <div id="imagePreviewContainer" class="text-center mt-3">
                                <img id="imagePreview" src="" alt="Preview" class="avatar-circle avatar-lg">
                                <div class="text-muted small mt-1">New photo preview</div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Full Name"
                                   value="<?= htmlspecialchars($user['name']) ?>" required>
                            <label for="name">Full Name</label>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Email"
                                   value="<?= htmlspecialchars($user['email']) ?>" required>
                            <label for="email">Email Address</label>
                        </div>

                        <!-- Password (optional) -->
                        <div class="form-floating mb-1">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="New Password">
                            <label for="password">New Password (leave blank to keep current)</label>
                        </div>
                        <div class="form-text text-muted small mb-4">
                            🔒 Only fill this if you want to change the password.
                        </div>

                        <!-- Biography (Summernote) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Biography / Notes</label>
                            <textarea id="summernote" name="description"><?= htmlspecialchars($user['description'] ?? '') ?></textarea>
                        </div>

                        <!-- Submit -->
                        <button type="submit" name="submit"
                                class="btn btn-primary w-100 py-3 fw-bold rounded-3 fs-6">
                            💾 Save Changes
                        </button>
                    </form>
                </div>

                <div class="card-footer bg-light border-0 py-3 text-center">
                    <a href="view_users.php" class="text-decoration-none text-muted fw-semibold small">
                        ← Cancel & Return
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removePhoto() {
    document.getElementById('removeImageFlag').value = '1';
    document.getElementById('currentPhoto') &&
        (document.getElementById('currentPhoto').style.opacity = '0.3');
}
</script>

<?php include "footer.php"; ?>
