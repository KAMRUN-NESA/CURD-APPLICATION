<?php
include "header.php";

$error = "";
$success = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name)) {
        $error = "Name field is required.";
    } elseif (empty($email)) {
        $error = "Email field is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($password)) {
        $error = "Password field is required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif (emailExists($email)) {
        $error = "Email address already registered.";
    } else {
        if (addUser($name, $email, $password)) {
            $success = "User added successfully!";
            // Reset fields
            $name = "";
            $email = "";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white text-center py-4 border-0 position-relative">
                    <h3 class="fw-bold mb-0">Add New User</h3>
                    <p class="text-white-50 mb-0 mt-1">Create a new system user record</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                            <div><?php echo $error; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            <div><?php echo $success; ?></div>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST" novalidate>
                        <!-- Name Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="John Doe" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
                            <label for="name">Full Name</label>
                        </div>
                        
                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="name@example.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                            <label for="email">Email address</label>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password (Min. 6 chars)</label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button class="w-100 btn btn-lg btn-primary rounded-3 py-3 fw-bold shadow" type="submit" name="submit">
                            Save User Record
                        </button>
                    </form>
                </div>
                
                <div class="card-footer bg-light py-3 border-0 text-center">
                    <a href="view_users.php" class="text-decoration-none text-secondary small fw-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
