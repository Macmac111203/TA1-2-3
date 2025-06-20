<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) ) {

	 include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

	if ($_SESSION['role'] == "admin") {
		  $todaydue_task = count_tasks_due_today($conn);
	     $overdue_task = count_tasks_overdue($conn);
	     $nodeadline_task = count_tasks_NoDeadline($conn);
	     $num_task = count_tasks($conn);
	     $num_users = count_users($conn);
	     $pending = count_pending_tasks($conn);
	     $in_progress = count_in_progress_tasks($conn);
	     $completed = count_completed_tasks($conn);
	     include_once "app/Model/Notification.php";
	     $notif_count = count_all_unread_notifications($conn);
	}else {
        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $nodeadline_task = count_my_tasks_NoDeadline($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
	     $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);
	     $completed = count_my_completed_tasks($conn, $_SESSION['id']);
	     include_once "app/Model/Notification.php";
	     $notif_count = count_notification($conn, $_SESSION['id']);
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<?php if ($_SESSION['role'] == "admin") { ?>
				<div class="dashboard">
					<a href="user.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-users"></i>
						<span><?=$num_users?> Employee</span>
					</a>
					<a href="tasks.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-tasks"></i>
						<span><?=$num_task?> All Tasks</span>
					</a>
					<a href="tasks.php?due_date=Overdue" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Overdue</span>
					</a>
					<a href="tasks.php?due_date=No+Deadline" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</a>
					<a href="tasks.php?due_date=Due+Today" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-exclamation-triangle"></i>
						<span><?=$todaydue_task?> Due Today</span>
					</a>
					<a href="notifications.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-bell"></i>
						<span><?=$notif_count?> Notifications</span>
					</a>
					<a href="tasks.php?status=pending" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-square-o"></i>
						<span><?=$pending?> Pending</span>
					</a>
					<a href="tasks.php?status=in_progress" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In Progress</span>
					</a>
					<a href="tasks.php?status=completed" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-check-square-o"></i>
						<span><?=$completed?> Completed</span>
					</a>
				</div>
			<?php }else{ ?>
				<div class="dashboard">
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-tasks"></i>
						<span><?=$num_my_task?> My Tasks</span>
					</a>
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-window-close-o"></i>
						<span><?=$overdue_task?> Missing</span>
					</a>
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-clock-o"></i>
						<span><?=$nodeadline_task?> No Deadline</span>
					</a>
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-square-o"></i>
						<span><?=$pending?> Pending</span>
					</a>
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In Progress</span>
					</a>
					<a href="my_task.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-check-square-o"></i>
						<span><?=$completed?> Completed</span>
					</a>
					<a href="notifications.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer; position:relative;">
						<i class="fa fa-bell"></i>
						<span style="display:block; margin-top:8px;"><?=$notif_count?> Notifications</span>
					</a>
					<a href="profile.php" class="dashboard-item" style="text-decoration:none; color:inherit; cursor:pointer;">
						<i class="fa fa-user"></i>
						<span>Profile</span>
					</a>
				</div>
			<?php } ?>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(1)");
	active.classList.add("active");
</script>
</body>
</html>
<?php }else{ 
   $em = "Login First!";
   header("Location: login.php?error=$em");
   exit();
}
 ?>