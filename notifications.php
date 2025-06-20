<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Notification.php";
    // include "app/Model/User.php";

    if ($_SESSION['role'] == 'admin') {
        // Admin: show all notifications
        $stmt = $conn->prepare("SELECT * FROM notifications ORDER BY id DESC");
        $stmt->execute();
        $notifications = $stmt->fetchAll();
    } else {
        // Employee: show only their own notifications
        $notifications = get_all_my_notifications($conn, $_SESSION['id']);
    }

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Notifications</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1" style="display: flex; flex-direction: column; align-items: center; min-height: 80vh;">
			<div class="card" style="max-width: 900px; width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 16px; background: #fff; margin-top: 30px;">
				<div class="card-body" style="padding: 2rem;">
					<h4 class="title mb-4" style="font-size: 1.3rem; font-weight: bold; display: flex; align-items: center; gap: 10px;">
						<i class="fa fa-bell" style="color: #127b8e;"></i> All Notifications
					</h4>
					<?php if (isset($_GET['success'])) {?>
						<div class="success" role="alert" id="successAlert" style="position: relative;">
							<span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
							<?php echo stripcslashes($_GET['success']); ?>
						</div>
					<?php } ?>
					<?php if ($notifications != 0) { ?>
					<div style="overflow-x: auto;">
						<table class="table table-striped table-bordered" style="width: 100%; min-width: 700px;">
							<thead>
								<tr>
									<th style="text-align:center;">#</th>
									<th>Message</th>
									<th>Type</th>
									<th>Date</th>
									<th>Recipient</th>
									<th style="text-align:center;">Delete</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach ($notifications as $notification) { ?>
								<tr>
									<td style="text-align:center; vertical-align:middle;"> <?=++$i?> </td>
									<td style="vertical-align:middle;"> <?=$notification['message']?> </td>
									<td style="vertical-align:middle;"> <?=$notification['type']?> </td>
									<td style="vertical-align:middle;"> <?=$notification['date']?> </td>
									<td style="vertical-align:middle;">
										<?php if ($_SESSION['role'] == 'admin') {
											// Show recipient username
											$recipient_id = $notification['recipient'];
											$stmt = $conn->prepare("SELECT username FROM users WHERE id=?");
											$stmt->execute([$recipient_id]);
											$user = $stmt->fetch();
											echo $user ? '@' . htmlspecialchars($user['username']) : 'Unknown';
										} else {
											// Show recipient number for employee
											echo $notification['recipient'];
										} ?>
									</td>
									<td style="text-align:center; vertical-align:middle;">
										<a href="app/delete-notification.php?id=<?=$notification['id']?>" onclick="return confirm('Delete this notification?');" style="color:#e74c3c; font-size:1.3em; text-decoration:none; font-weight:bold;">
											&times;
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<?php }else { ?>
						<div style="text-align:center; color:#888; font-size:1.15rem; margin-top: 2rem;">
							<i class="fa fa-bell-slash" style="font-size:2.5rem; color:#ccc;"></i><br>
							You have zero notifications.
						</div>
					<?php  }?>
				</div>
			</div>
		</section>
	</div>


<script type="text/javascript">
	var navList = document.querySelectorAll("#navList li");
	if (navList.length === 6) { // Admin: Dashboard, Manage Users, Create Task, All Tasks, Notifications, Logout
		navList[4].classList.add("active"); // Notifications is the 5th item (index 4)
	} else if (navList.length === 5) { // Employee: Dashboard, My Task, Profile, Notifications, Logout
		navList[3].classList.add("active"); // Notifications is the 4th item (index 3)
	}
</script>

<style>
.table {
    font-size: 1.12rem;
}
.table th, .table td {
    padding: 16px 32px !important;
    min-width: 120px;
}
.table tr {
    height: 54px;
}
</style>

</body>
</html>
<?php }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>