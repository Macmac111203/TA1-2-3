<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    // Handle search functionality
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_term = trim($_GET['search']);
        $users = search_users($conn, $search_term);
        $search_active = true;
    } else {
        $users = get_all_users($conn);
        $search_active = false;
    }
  
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
		<section class="section-1" style="display: flex; flex-direction: column; align-items: center; min-height: 80vh;">
			<div class="card" style="max-width: 1400px; width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 16px; background: #fff; margin-top: 30px;">
				<div class="card-body" style="padding: 2rem;">
					<?php if (isset($_GET['success'])) {?>
						<div class="success" role="alert" id="successAlert" style="position: relative;">
							<span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
							<?php echo stripcslashes($_GET['success']); ?>
						</div>
					<?php } ?>
					<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 18px; margin-bottom: 20px;">
						<div style="display: flex; align-items: center; gap: 18px;">
							<h4 class="title" style="margin-bottom: 0;">Manage Users</h4>
							<a href="add-user.php" style="text-decoration: none; border: none; background: #00CF22; padding: 10px 22px; color: #fff; font-size: 17px; border-radius: 7px; cursor: pointer; outline: none; box-shadow: 0 4px 12px 0 rgba(0,0,0,0.10); transition: background 0.2s;">Add Employee</a>
						</div>
						
						<!-- Search Form -->
						<form method="GET" action="user.php" style="display: flex; gap: 10px; align-items: center;">
							<input type="text" name="search" placeholder="Search users..." 
								   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
								   style="padding: 10px 15px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; min-width: 300px;">
							<button type="submit" style="background: #127b8e; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 14px;">
								<i class="fa fa-search"></i> Search
							</button>
							<?php if ($search_active) { ?>
								<a href="user.php" style="background: #6c757d; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-size: 14px;">
									<i class="fa fa-times"></i> Clear
								</a>
							<?php } ?>
						</form>
					</div>
					
					<?php if ($search_active) { ?>
						<div style="margin-bottom: 15px; padding: 10px; background: #e3f2fd; border-radius: 6px; border-left: 4px solid #127b8e;">
							<i class="fa fa-search" style="color: #127b8e; margin-right: 8px;"></i>
							<strong>Search Results:</strong> Showing results for "<em><?php echo htmlspecialchars($_GET['search']); ?></em>"
							<?php if ($users != 0) { ?>
								<span style="color: #127b8e;">(<?php echo count($users); ?> user(s) found)</span>
							<?php } else { ?>
								<span style="color: #f44336;">(No users found)</span>
							<?php } ?>
						</div>
					<?php } ?>
					
					<div style="overflow-x: auto;">
						<table class="table table-striped table-bordered" style="width: 100%; min-width: 1300px; background: #fff; border-radius: 10px; overflow: hidden; font-size: 1.08rem;">
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
								<?php if ($users != 0) { ?>
									<?php $i=0; foreach ($users as $user) { ?>
									<tr>
										<td style="text-align:center; vertical-align:middle;"> <?=++$i?> </td>
										<td style="vertical-align:middle;"> <?=$user['full_name']?> </td>
										<td style="vertical-align:middle;"> <?=$user['username']?> </td>
										<td style="vertical-align:middle;"> <?=$user['email']?> </td>
										<td style="vertical-align:middle;"> <?=ucwords($user['role'])?> </td>
										<td style="vertical-align:middle;"> <?=$user['department']?> </td>
										<td style="text-align:center; vertical-align:middle;">
											<div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
												<a href="edit-user.php?id=<?=$user['id']?>" class="edit-btn" style="min-width: 60px;">Edit</a>
												<a href="delete-user.php?id=<?=$user['id']?>" class="delete-btn" style="min-width: 60px;">Delete</a>
											</div>
										</td>
									</tr>
									<?php } ?>
								<?php } else { ?>
									<tr>
										<td colspan="7" style="text-align: center; padding: 40px; color: #666; font-style: italic;">
											<?php if ($search_active) { ?>
												<i class="fa fa-search" style="font-size: 2rem; color: #ccc; margin-bottom: 10px; display: block;"></i>
												No users found matching your search criteria.
											<?php } else { ?>
												<i class="fa fa-users" style="font-size: 2rem; color: #ccc; margin-bottom: 10px; display: block;"></i>
												No employees found in the system.
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
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