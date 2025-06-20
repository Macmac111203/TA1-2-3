<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    
    $text = "All Tasks";
    if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Due Today") {
    	$text = "Due Today";
      $tasks = get_all_tasks_due_today($conn);
      $num_task = count_tasks_due_today($conn);

    }else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "Overdue") {
    	$text = "Missing";
      $tasks = get_all_tasks_overdue($conn);
      $num_task = count_tasks_overdue($conn);

    }else if (isset($_GET['due_date']) &&  $_GET['due_date'] == "No Deadline") {
    	$text = "No Deadline";
      $tasks = get_all_tasks_NoDeadline($conn);
      $num_task = count_tasks_NoDeadline($conn);

    }else{
    	 $tasks = get_all_tasks($conn);
       $num_task = count_tasks($conn);
    }
    $users = get_all_users($conn);
    

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>All Tasks</title>
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
					<div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 18px;">
						<a href="create_task.php" class="btn" style="background: #00CF22; color: #fff; font-weight: 500; border-radius: 6px; padding: 10px 20px; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.08);">Create Task</a>
						<a href="tasks.php?due_date=Due Today" class="btn" style="background: #f5f5f5; color: #23242b; border-radius: 6px; padding: 10px 20px;">Due Today</a>
						<a href="tasks.php?due_date=Overdue" class="btn" style="background: #f5f5f5; color: #23242b; border-radius: 6px; padding: 10px 20px;">Missing</a>
						<a href="tasks.php?due_date=No Deadline" class="btn" style="background: #f5f5f5; color: #23242b; border-radius: 6px; padding: 10px 20px;">No Deadline</a>
						<a href="tasks.php" class="btn" style="background: #f5f5f5; color: #23242b; border-radius: 6px; padding: 10px 20px;">All Tasks</a>
					</div>
					<h4 class="title-2" style="margin-bottom: 18px; font-size: 1.2rem; font-weight: bold; color: #23242b;"><?=$text?> (<?=$num_task?>)</h4>
					<?php if (isset($_GET['success'])) {?>
						<div class="success" role="alert" id="successAlert" style="position: relative;">
							<span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
							<?php echo stripcslashes($_GET['success']); ?>
						</div>
					<?php } ?>
					<?php if (isset($_GET['error'])) {?>
						<div class="danger" role="alert" id="errorAlert" style="position: relative;">
							<span onclick="document.getElementById('errorAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
							<?php echo stripcslashes($_GET['error']); ?>
						</div>
					<?php } ?>
					<?php if ($tasks != 0) { ?>
					<div style="overflow-x: auto;">
						<table class="table table-striped table-bordered" style="min-width: 1400px;">
							<thead>
								<tr>
									<th style="text-align:center;">#</th>
									<th>Title</th>
									<th>Description</th>
									<th>Assigned To</th>
									<th>Due Date</th>
									<th>Status</th>
									<th>File</th>
									<th style="text-align:center;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0; foreach ($tasks as $task) { ?>
								<tr>
									<td style="text-align:center; vertical-align:middle;"> <?=++$i?> </td>
									<td style="vertical-align:middle;"> <?=$task['title']?> </td>
									<td style="vertical-align:middle; max-width: 220px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?=htmlspecialchars($task['description'])?>"> <?=$task['description']?> </td>
									<td style="vertical-align:middle;">
										<?php foreach ($users as $user) { if($user['id'] == $task['assigned_to']){ echo $user['full_name']; }}?>
									</td>
									<td style="vertical-align:middle;"> <?php if($task['due_date'] == "") echo "No Deadline"; else echo $task['due_date']; ?> </td>
									<td style="vertical-align:middle;"> <?=$task['status']?> </td>
									<td style="vertical-align:middle;">
										<?php if (isset($task['file_name']) && $task['file_name']) { ?>
											<a href="uploads/<?=$task['file_name']?>" target="_blank" class="view-btn" style="color: #127b8e; text-decoration: underline;">View</a>
										<?php } else { ?>
											<span style="color: #aaa;">No file</span>
										<?php } ?>
									</td>
									<td style="text-align:center; vertical-align:middle;">
										<div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
											<a href="edit-task.php?id=<?=$task['id']?>" class="edit-btn" style="min-width: 60px;">Edit</a>
											<a href="delete-task.php?id=<?=$task['id']?>" class="delete-btn" style="min-width: 60px;">Delete</a>
										</div>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<?php }else { ?>
						<h3>Empty</h3>
					<?php  }?>
				</div>
			</div>
		</section>
	</div>

<script type="text/javascript">
	var active = document.querySelector("#navList li:nth-child(4)");
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