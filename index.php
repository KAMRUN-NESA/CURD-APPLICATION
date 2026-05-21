<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Application</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="card col-md-6 mx-auto shadow">

            <div class="card-header text-center">
                <h4>User Login Form</h4>
            </div>

            <div class="card-body">
                <form action="loginvalidation.php" method="POST">

                    <label>Name</label>
                    <input type="text" class="form-control mb-2" name="name">

                    <label>Email</label>
                    <input type="email" class="form-control mb-2" name="email">

                    <label>Password</label>
                    <input type="password" class="form-control mb-3" name="password">

                    <!-- Important -->
                    <button type="submit" name="submit" class="btn btn-primary w-100">
                        Submit
                    </button>

                </form>
            </div>

        </div>
    </div>

</body>
</html>