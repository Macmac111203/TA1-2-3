<header class="header">
	<div class="header" style="display: flex; align-items: center; padding: 0 30px;">
		<div class="u-name" style="flex: 0 0 auto;">
			Task <b>MSPro</b>
		</div>
		<label for="checkbox" id="navbtn" style="margin-left: 40px; font-size: 24px; cursor: pointer;"><i class="fa fa-bars"></i></label>
		<div style="flex: 1 1 auto;"></div>
		<?php if (isset($_SESSION['id']) && isset($conn)) { ?>
			<div class="notification" style="margin-left: 1800px; margin-right: 0; padding-right: 10px;">
				<a href="notifications.php"><i class="fa fa-bell"></i></a>
				<?php
				include_once "app/Model/Notification.php";
				if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
					$notif_count = count_all_unread_notifications($conn);
				} else {
					$notif_count = count_notification($conn, $_SESSION['id']);
				}
				if ($notif_count > 0) { echo "<span>$notif_count</span>"; }
				?>
			</div>
		<?php } ?>
	</div>
</header>
<div class="notification-bar" id="notificationBar">
	<ul id="notifications">
	
	</ul>
</div>
<script type="text/javascript">
	var openNotification = false;

	const notification = ()=> {
		let notificationBar = document.querySelector("#notificationBar");
		if (openNotification) {
			notificationBar.classList.remove('open-notification');
			openNotification = false;
		}else {
			notificationBar.classList.add('open-notification');
			openNotification = true;
		}
	}
	let notificationBtn = document.querySelector("#notificationBtn");
	notificationBtn.addEventListener("click", notification);
</script>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){

       $("#notificationNum").load("app/notification-count.php");
       $("#notifications").load("app/notification.php");

   });
</script>