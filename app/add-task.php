<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && $_SESSION['role'] == 'admin' && isset($_POST['due_date'])) {
	include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$title = validate_input($_POST['title']);
	$description = validate_input($_POST['description']);
	$assigned_to = validate_input($_POST['assigned_to']);
	$due_date = validate_input($_POST['due_date']);

	if (empty($title)) {
		$em = "Title is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($description)) {
		$em = "Description is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if ($assigned_to == 0) {
		$em = "Select User";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else {
    
       include "Model/Task.php";
       include "Model/Notification.php";

       // Handle file upload if a file is provided
       $fileNameToSave = null;
       if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
           $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
           $maxFileSize = 5242880; // 5MB
           
           if ($_FILES['file']['size'] > $maxFileSize) {
               $em = "File too large";
               header("Location: ../create_task.php?error=$em");
               exit();
           }

           $finfo = new finfo(FILEINFO_MIME_TYPE);
           $fileType = $finfo->file($_FILES['file']['tmp_name']);
           
           if (!in_array($fileType, $allowedTypes)) {
               $em = "Invalid file type";
               header("Location: ../create_task.php?error=$em");
               exit();
           }

           $uploadDir = '../uploads/';
           if (!file_exists($uploadDir)) {
               mkdir($uploadDir, 0777, true);
           }

           $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
           $newFilename = $_FILES['file']['name'];
           $uploadPath = $uploadDir . $newFilename;

           if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
               $em = "Failed to upload file";
               header("Location: ../create_task.php?error=$em");
               exit();
           }
           $fileNameToSave = $newFilename;
       }

       $data = array($title, $description, $assigned_to, $due_date, $fileNameToSave);
       insert_task($conn, $data);

       $notif_data = array("'$title' has been assigned to you. Please review and start working on it", $assigned_to, 'New Task Assigned');
       insert_notification($conn, $notif_data);


       $em = "Task created successfully";
	    header("Location: ../create_task.php?success=$em");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../create_task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../create_task.php?error=$em");
   exit();
}

if (isset($_GET['error'])) {?>
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