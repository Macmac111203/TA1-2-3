<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    require_once 'api/csrf.php';
    
    if (!isset($_GET['id'])) {
    	 header("Location: tasks.php");
    	 exit();
    }
    $id = $_GET['id'];
    $task = get_task_by_id($conn, $id);

    if ($task == 0) {
    	 header("Location: tasks.php");
    	 exit();
    }
   $users = get_all_users($conn);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1" style="display: flex; flex-direction: column; align-items: center; min-height: 80vh;">
			<div class="card" style="max-width: 500px; width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-radius: 16px; background: #fff; margin-top: 30px;">
				<div class="card-body" style="padding: 2rem;">
					<h4 class="title mb-4 text-center" style="font-size: 1.3rem; font-weight: bold;">Edit Task <a href="my_task.php" style="font-size: 1rem; color: #127b8e; text-decoration: underline; margin-left: 10px;">Tasks</a></h4>
					<form class="form-1" method="POST" action="app/update-task-employee.php">
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
							<label style="font-weight: 500; color: #23242b;">Title</label>
							<div style="background: #f5f5f5; border-radius: 6px; padding: 10px 14px; color: #555; font-size: 1.05em;"> <?=$task['title']?> </div>
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label style="font-weight: 500; color: #23242b;">Description</label>
							<div style="background: #f5f5f5; border-radius: 6px; padding: 10px 14px; color: #555; font-size: 1.05em; min-height: 48px;"> <?=$task['description']?> </div>
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label style="font-weight: 500; color: #23242b;">Status</label>
							<select name="status" class="input-1" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc; font-size: 1em;">
								<option value="pending" <?php if($task['status'] == "pending") echo "selected"; ?>>Pending</option>
								<option value="in_progress" <?php if($task['status'] == "in_progress") echo "selected"; ?>>In Progress</option>
								<option value="completed" <?php if($task['status'] == "completed") echo "selected"; ?>>Completed</option>
							</select>
						</div>
						<input type="text" name="id" value="<?=$task['id']?>" hidden>
						<?php echo CSRF::getTokenField(); ?>
						<button class="edit-btn" style="width: 100%; margin-top: 10px; background: #127b8e; color: #fff; border-radius: 6px; font-weight: 500; font-size: 1.08em;">Update</button>
					</form>
				</div>
			</div>
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