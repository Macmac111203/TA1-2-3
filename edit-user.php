<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    require_once 'api/csrf.php';
    
    if (!isset($_GET['id'])) {
    	 header("Location: user.php");
    	 exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user == 0) {
    	 header("Location: user.php");
    	 exit();
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit User</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Edit Users <a href="user.php">Users</a></h4>
			<form class="form-1"
			      method="POST"
			      action="app/update-user.php">
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
					<input type="text" name="first_name" class="input-1" placeholder="First Name" value="<?=explode(' ', $user['full_name'])[0]?>"><br>
				</div>
				<div class="input-holder">
					<label>Last Name</label>
					<input type="text" name="last_name" class="input-1" placeholder="Last Name" value="<?=isset(explode(' ', $user['full_name'])[1]) ? explode(' ', $user['full_name'])[1] : ''?>"><br>
				</div>
				<div class="input-holder">
					<label>Email</label>
					<input type="email" name="email" class="input-1" placeholder="Email" value="<?=$user['email']?>"><br>
				</div>
				<div class="input-holder">
					<label>Username</label>
					<input type="text" name="user_name" value="<?=$user['username']?>" class="input-1" placeholder="Username"><br>
				</div>
				<div class="input-holder">
					<label>Position</label>
					<select name="role" class="input-1">
						<option value="admin" <?=$user['role']=='admin'?'selected':''?>>Admin</option>
						<option value="employee" <?=$user['role']=='employee'?'selected':''?>>Employee</option>
					</select><br>
				</div>
				<div class="input-holder">
					<label>Department</label>
					<select name="department" class="input-1">
						<option value="HR" <?=$user['department']=='HR'?'selected':''?>>HR</option>
						<option value="IT" <?=$user['department']=='IT'?'selected':''?>>IT</option>
						<option value="Finance" <?=$user['department']=='Finance'?'selected':''?>>Finance</option>
						<option value="Marketing" <?=$user['department']=='Marketing'?'selected':''?>>Marketing</option>
						<option value="Operations" <?=$user['department']=='Operations'?'selected':''?>>Operations</option>
						<option value="Other" <?=$user['department']=='Other'?'selected':''?>>Other</option>
					</select><br>
				</div>
				<input type="text" name="id" value="<?=$user['id']?>" hidden>
				<?php echo CSRF::getTokenField(); ?>
				<button class="edit-btn">Update</button>
			</form>
			
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>