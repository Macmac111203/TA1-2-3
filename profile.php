<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/User.php";
    $user = get_user_by_id($conn, $_SESSION['id']);
    
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<div style="display: flex; flex-direction: column; align-items: center; margin-top: 30px;">
				<div class="card" style="max-width: 520px; width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 20px; background: #fff;">
					<div class="card-body" style="padding: 2.5rem;">
						<div style="display: flex; justify-content: center; align-items: center; margin-bottom: 1.5rem;">
							<h4 class="title" style="margin: 0; font-size: 1.25rem; font-weight: bold;">Profile</h4>
							<a href="edit_profile.php" style="margin-left: 16px; text-decoration: none; border: none; background: #00CF22; padding: 12px 22px; color: #fff; font-size: 17px; border-radius: 7px; cursor: pointer; outline: none; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.08);">Edit Profile</a>
						</div>
						<div style="display: flex; align-items: flex-start; gap: 18px; margin-bottom: 1.5rem;">
							<i class="fa fa-user-circle" style="font-size: 3.5rem; color: #127b8e;"></i>
							<table class="table table-borderless mb-0" style="width: auto; font-size: 1.15rem;">
								<tr style="height: 44px;">
									<th style="width: 120px; text-align: left;">Full Name</th>
									<td style="text-align: left;"> <?=$user['full_name']?> </td>
								</tr>
								<tr style="height: 44px;">
									<th style="text-align: left;">User Name</th>
									<td style="text-align: left;"> <?=$user['username']?> </td>
								</tr>
								<tr style="height: 44px;">
									<th style="text-align: left;">Email</th>
									<td style="text-align: left;"> <?=$user['email']?> </td>
								</tr>
								<tr style="height: 44px;">
									<th style="text-align: left;">Role</th>
									<td style="text-align: left;"> <?=ucfirst($user['role'])?> </td>
								</tr>
								<tr style="height: 44px;">
									<th style="text-align: left;">Department</th>
									<td style="text-align: left;"> <?=$user['department']?> </td>
								</tr>
								<tr style="height: 44px;">
									<th style="text-align: left;">Joined At</th>
									<td style="text-align: left;"> <?=$user['created_at']?> </td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(3)");
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