<nav class="side-bar">
			<div class="user-p" style="display: flex; flex-direction: column; align-items: center;">
				<img src="img/user.png">
				<h4 style="display: flex; align-items: center; gap: 8px; justify-content: center; margin-top: 10px; text-align: center;">
					@<?=$_SESSION['username']?>
					<?php if ($_SESSION['role'] == 'admin') { ?>
						<a href="edit-user.php?id=<?=$_SESSION['id']?>" style="color: #127b8e; margin-left: 4px; font-size: 1.1em;" title="Edit Admin Account"><i class="fa fa-pencil"></i></a>
					<?php } else { ?>
						<a href="edit_profile.php" style="color: #127b8e; margin-left: 4px; font-size: 1.1em;" title="Edit Profile"><i class="fa fa-pencil"></i></a>
					<?php } ?>
				</h4>
			</div>
			
			<?php 

               if($_SESSION['role'] == "employee"){
			 ?>
			 <!-- Employee Navigation Bar -->
			<ul id="navList">
				<li>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="my_task.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>My Task</span>
					</a>
				</li>
				<li>
					<a href="profile.php">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span>Profile</span>
					</a>
				</li>
				<li>
					<a href="notifications.php">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<span>Notifications</span>
					</a>
				</li>
				<li>
					<a href="logout.php">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		<?php }else { ?>
			<!-- Admin Navigation Bar -->
            <ul id="navList">
				<li>
					<a href="index.php">
						<i class="fa fa-tachometer" aria-hidden="true"></i>
						<span>Dashboard</span>
					</a>
				</li>
				<li>
					<a href="user.php">
						<i class="fa fa-users" aria-hidden="true"></i>
						<span>Manage Users</span>
					</a>
				</li>
				<li>
					<a href="create_task.php">
						<i class="fa fa-plus" aria-hidden="true"></i>
						<span>Create Task</span>
					</a>
				</li>
				<li>
					<a href="tasks.php">
						<i class="fa fa-tasks" aria-hidden="true"></i>
						<span>All Tasks</span>
					</a>
				</li>
				<li>
					<a href="notifications.php">
						<i class="fa fa-bell" aria-hidden="true"></i>
						<span>Notifications</span>
					</a>
				</li>
				<li>
					<a href="logout.php">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
						<span>Logout</span>
					</a>
				</li>
			</ul>
		<?php } ?>
		</nav>