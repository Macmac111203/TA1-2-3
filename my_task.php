<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>My Tasks</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1" style="display: flex; flex-direction: column; align-items: center; min-height: 80vh;">
			<h4 class="title" style="font-size: 1.3rem; font-weight: bold; margin-bottom: 18px;">My Tasks</h4>
			<?php if (isset($_GET['success'])) {?>
				<div class="success" role="alert" id="successAlert" style="position: relative;">
					<span onclick="document.getElementById('successAlert').style.display='none';" style="position: absolute; right: 12px; top: 8px; cursor: pointer; font-weight: bold; font-size: 1.2em;">&times;</span>
					<?php echo stripcslashes($_GET['success']); ?>
				</div>
			<?php } ?>
			<?php if ($tasks != 0) { ?>
				<div style="display: flex; flex-wrap: wrap; gap: 24px; justify-content: center; width: 100%;">
					<?php $i=0; foreach ($tasks as $task) { ?>
					<div class="card" style="width: 370px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 16px; background: #fff; padding: 1.5rem 1.2rem; display: flex; flex-direction: column; gap: 10px; position: relative;">
						<div style="display: flex; justify-content: space-between; align-items: center;">
							<span style="font-weight: bold; font-size: 1.1rem; color: #23242b;">#<?=++$i?> - <?=$task['title']?></span>
							<span class="badge" style="padding: 4px 12px; border-radius: 12px; font-size: 0.95em; font-weight: 500; color: #fff; background:
								<?php if($task['status']==='pending') echo '#f0ad4e';
									  elseif($task['status']==='in_progress') echo '#0275d8';
									  else echo '#5cb85c'; ?>;">
								<?=ucwords(str_replace('_',' ',$task['status']))?>
							</span>
						</div>
						<div style="color: #555; margin-bottom: 6px; min-height: 48px;"> <?=$task['description']?> </div>
						<div style="font-size: 0.98em; color: #888;">Due: <b><?=$task['due_date']?></b></div>
						<div style="display: flex; align-items: center; gap: 10px;">
							<?php if ($task['file_name']) { ?>
								<a href="uploads/<?=$task['file_name']?>" target="_blank" class="view-btn" style="background: #e9f7ef; color: #127b8e; padding: 4px 12px; border-radius: 6px; font-size: 0.97em; text-decoration: none; font-weight: 500;">View File</a>
							<?php } else { ?>
								<span style="color: #bbb; font-size: 0.97em;">No file</span>
							<?php } ?>
							<a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn" style="margin-left: auto; background: #127b8e; color: #fff; border-radius: 6px; padding: 6px 18px; font-weight: 500; text-decoration: none;">Edit</a>
						</div>
					</div>
					<?php } ?>
				</div>
			<?php } else { ?>
				<div style="text-align:center; color:#888; font-size:1.15rem; margin-top: 2rem;">
					<i class="fa fa-tasks" style="font-size:2.5rem; color:#ccc;"></i><br>
					You have no tasks assigned.
				</div>
			<?php }?>
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