<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    $users = get_all_users($conn);
  
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Manage Users</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<?php if (isset($_GET['success'])) {?>
				<div class="success" role="alert" id="successAlert" style="position: relative;">
					<span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
					<?php echo stripcslashes($_GET['success']); ?>
				</div>
			<?php } ?>
			<div style="display: flex; align-items: center; gap: 18px; margin-bottom: 20px;">
				<h4 class="title" style="margin-bottom: 0;">Manage Users</h4>
				<a href="add-user.php" style="text-decoration: none; border: none; background: #00CF22; padding: 10px 22px; color: #fff; font-size: 17px; border-radius: 7px; cursor: pointer; outline: none; box-shadow: 0 4px 12px 0 rgba(0,0,0,0.10); transition: background 0.2s;">Add Employee</a>
			</div>
			<div style="display: flex; justify-content: center;">
				<div style="overflow-x: auto; min-width: 1100px; max-width: 1400px; width: 100%;">
					<table class="table table-striped table-bordered" style="width: 100%; min-width: 1400px; background: #fff; border-radius: 10px; overflow: hidden; font-size: 1.08rem;">
						<thead style="background: #f8f9fa;">
							<tr>
								<th style="text-align:center;">#</th>
								<th>Full Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Role</th>
								<th>Department</th>
								<th style="text-align:center;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=0; foreach ($users as $user) { ?>
							<tr>
								<td style="text-align:center; vertical-align:middle;"> <?=++$i?> </td>
								<td style="vertical-align:middle;"> <?=$user['full_name']?> </td>
								<td style="vertical-align:middle;"> <?=$user['username']?> </td>
								<td style="vertical-align:middle;"> <?=$user['email']?> </td>
								<td style="vertical-align:middle;"> <?=ucwords($user['role'])?> </td>
								<td style="vertical-align:middle;"> <?=$user['department']?> </td>
								<td style="text-align:center; vertical-align:middle;">
									<a href="edit-user.php?id=<?=$user['id']?>" class="edit-btn" style="margin-right: 8px; min-width: 60px;">Edit</a>
									<a href="delete-user.php?id=<?=$user['id']?>" class="delete-btn" style="min-width: 60px;">Delete</a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(2)");
	active.classList.add("active");
</script>

<style>
.table {
    font-size: 1.15rem;
}
.table th, .table td {
    padding: 18px 38px !important;
    min-width: 140px;
}
.table tr {
    height: 64px;
}
</style>
</body>
</html>
<?php }else{ 
   $em = "Login First!";
   header("Location: login.php?error=$em");
   exit();
}
 ?>