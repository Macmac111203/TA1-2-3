<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/User.php";
    require_once 'api/csrf.php';
    $user = get_user_by_id($conn, $_SESSION['id']);
    
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1" style="display: flex; flex-direction: column; align-items: center; min-height: 80vh;">
			<div class="card" style="max-width: 450px; width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 16px; background: #fff; margin-top: 30px;">
				<div class="card-body" style="padding: 2rem;">
					<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 1.5rem;">
						<h4 class="title" style="margin: 0; font-size: 1.1rem; font-weight: bold;">Edit Profile</h4>
						<a href="profile.php" style="margin-left: 10px; text-decoration: none; border: none; background: #00CF22; padding: 8px 15px; color: #fff; font-size: 15px; border-radius: 5px; cursor: pointer; outline: none; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.08);">Profile</a>
					</div>
					<form class="form-1" method="POST" action="app/update-profile.php">
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
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>First Name</label>
							<input type="text" name="first_name" class="input-1" placeholder="First Name" value="<?=explode(' ', $user['full_name'])[0]?>">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Last Name</label>
							<input type="text" name="last_name" class="input-1" placeholder="Last Name" value="<?=isset(explode(' ', $user['full_name'])[1]) ? explode(' ', $user['full_name'])[1] : ''?>">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Email</label>
							<input type="email" name="email" class="input-1" placeholder="Email" value="<?=$user['email']?>">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Username</label>
							<input type="text" name="user_name" class="input-1" placeholder="Username" value="<?=$user['username']?>">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Old Password</label>
							<div class="input-group">
								<input type="password" value="" name="password" class="input-1" placeholder="Old Password" id="oldPassword">
								<button type="button" class="btn-eye" onclick="togglePassword('oldPassword', this)"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>New Password</label>
							<div class="input-group">
								<input type="password" name="new_password" class="input-1" placeholder="New Password" id="newPassword">
								<button type="button" class="btn-eye" onclick="togglePassword('newPassword', this)"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<div class="input-holder" style="margin-bottom: 1.5rem;">
							<label>Confirm Password</label>
							<div class="input-group">
								<input type="password" name="confirm_password" class="input-1" placeholder="Confirm Password" id="confirmPassword">
								<button type="button" class="btn-eye" onclick="togglePassword('confirmPassword', this)"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<?php echo CSRF::getTokenField(); ?>
						<button class="edit-btn" style="width: 100%; margin-top: 10px;">Change</button>
					</form>
				</div>
			</div>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>