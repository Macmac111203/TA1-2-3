<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Add Employee <a href="user.php">Users</a></h4>
			<form class="form-1"
			      method="POST"
			      action="app/add-user.php"
			      onsubmit="return validateAddUserForm();">
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
				<div class="input-holder">
					<label>First Name</label>
					<input type="text" name="first_name" class="input-1" placeholder="First Name"><br>
				</div>
				<div class="input-holder">
					<label>Last Name</label>
					<input type="text" name="last_name" class="input-1" placeholder="Last Name"><br>
				</div>
				<div class="input-holder">
					<lable>Username</lable>
					<input type="text" name="user_name" class="input-1" placeholder="Username"><br>
				</div>
				<div class="input-holder">
					<lable>Email</lable>
					<input type="email" name="email" class="input-1" placeholder="Email"><br>
				</div>
				<div class="input-holder">
					<lable>Role</lable>
					<select name="role" class="input-1">
						<option value="employee">Employee</option>
						<option value="admin">Admin</option>
					</select><br>
				</div>
				<div class="input-holder">
					<lable>Department</lable>
					<select name="department" class="input-1">
						<option value="HR">HR</option>
						<option value="IT">IT</option>
						<option value="Finance">Finance</option>
						<option value="Marketing">Marketing</option>
						<option value="Operations">Operations</option>
						<option value="Other">Other</option>
					</select><br>
				</div>
				<div class="input-holder">
					<label>Password</label>
					<div class="input-group">
						<input type="password" name="password" class="input-1" placeholder="Password" id="addUserPassword"><br>
						<button type="button" class="btn-eye" onclick="togglePassword('addUserPassword', this)"><i class="fa fa-eye"></i></button>
					</div>
				</div>
				<div class="input-holder">
					<label>Confirm Password</label>
					<div class="input-group">
						<input type="password" name="confirm_password" class="input-1" placeholder="Confirm Password" id="addUserConfirmPassword"><br>
						<button type="button" class="btn-eye" onclick="togglePassword('addUserConfirmPassword', this)"><i class="fa fa-eye"></i></button>
					</div>
				</div>

				<button class="edit-btn">Add</button>
			</form>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
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

function validateAddUserForm() {
    var firstName = document.getElementsByName('first_name')[0].value.trim();
    var lastName = document.getElementsByName('last_name')[0].value.trim();
    var username = document.getElementsByName('user_name')[0].value.trim();
    var email = document.getElementsByName('email')[0].value.trim();
    var password = document.getElementsByName('password')[0].value.trim();
    var confirmPassword = document.getElementsByName('confirm_password')[0].value.trim();
    var role = document.getElementsByName('role')[0].value;
    var department = document.getElementsByName('department')[0].value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var errorMsg = '';
    if (!firstName) errorMsg += 'First name is required.\n';
    if (!lastName) errorMsg += 'Last name is required.\n';
    if (!username) errorMsg += 'Username is required.\n';
    if (!email) errorMsg += 'Email is required.\n';
    else if (!emailPattern.test(email)) errorMsg += 'Invalid email format.\n';
    if (!password) errorMsg += 'Password is required.\n';
    else if (password.length < 6) errorMsg += 'Password must be at least 6 characters.\n';
    if (!confirmPassword) errorMsg += 'Confirm password is required.\n';
    else if (password !== confirmPassword) errorMsg += 'Passwords do not match.\n';
    if (!role) errorMsg += 'Role is required.\n';
    if (!department) errorMsg += 'Department is required.\n';
    if (errorMsg) {
        alert(errorMsg);
        return false;
    }
    return true;
}
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>