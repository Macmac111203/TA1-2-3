<!DOCTYPE html>
<?php
require_once 'api/csrf.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Task Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-body">
    <form method="POST" action="app/register.php" class="shadow p-4">
        <h3 class="display-4">REGISTER</h3>
        <?php if (isset($_GET['error'])) {?>
            <div class="danger" role="alert" id="errorAlert" style="position: relative;">
                <span onclick="document.getElementById('errorAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
                <?php echo stripcslashes($_GET['error']); ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['success'])) {?>
            <div class="success" role="alert" id="successAlert" style="position: relative;">
                <span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
                <?php echo stripcslashes($_GET['success']); ?>
            </div>
        <?php } ?>

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" class="form-control input-1" name="password" id="registerPassword" required>
                <button type="button" class="btn-eye" tabindex="-1" onclick="togglePassword('registerPassword', this)"><i class="fa fa-eye"></i></button>
            </div>
            <small class="text-muted">Password must be at least 8 characters long and include numbers and special characters</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control input-1" name="confirm_password" id="registerConfirmPassword" required>
                <button type="button" class="btn-eye" tabindex="-1" onclick="togglePassword('registerConfirmPassword', this)"><i class="fa fa-eye"></i></button>
            </div>
        </div>

        <?php echo CSRF::getTokenField(); ?>
        <button type="submit" class="btn btn-primary">Register</button>
        <a href="login.php" class="btn btn-link">Already have an account? Login</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword(id, btn) {
        var input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fa fa-eye"></i>';
        }
    }
    </script>
</body>
</html> 