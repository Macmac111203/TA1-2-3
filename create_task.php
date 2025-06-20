<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    require_once 'api/csrf.php';

    $users = get_all_users($conn);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Task</title>
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
					<h4 class="title mb-4 text-center" style="font-size: 1.3rem; font-weight: bold;">Create Task</h4>
					<form class="form-1" method="POST" action="app/add-task.php" enctype="multipart/form-data">
						<?php if (isset($_GET['error'])) {?>
							<div class="danger" role="alert">
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
							<label>Title</label>
							<input type="text" name="title" class="input-1" placeholder="Title">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Description</label>
							<textarea name="description" class="input-1" placeholder="Description"></textarea>
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Due Date</label>
							<input type="date" name="due_date" class="input-1" placeholder="Due Date">
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Assigned to</label>
							<select name="assigned_to" class="input-1">
								<option value="0">Select Employee</option>
								<?php if ($users !=0) { 
									foreach ($users as $user) {
								?>
								<option value="<?=$user['id']?>"><?=$user['full_name']?></option>
								<?php } } ?>
							</select>
						</div>
						<div class="input-holder" style="margin-bottom: 1rem;">
							<label>Attach File (Optional)</label>
							<input type="file" name="file" class="input-1" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
							<small>Allowed files: JPG, PNG, PDF, DOC, DOCX (Max 5MB)</small>
						</div>
						<?php echo CSRF::getTokenField(); ?>
						<button class="edit-btn" style="width: 100%; margin-top: 10px;">Create Task</button>
					</form>
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