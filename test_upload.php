<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    require_once 'api/csrf.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test File Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Test File Upload</h4>
            
            <!-- File Upload Form -->
            <form class="form-1" method="POST" action="api/file_upload.php" enctype="multipart/form-data">
                <?php if (isset($_GET['error'])) { ?>
                    <div class="danger" role="alert">
                        <?php echo stripcslashes($_GET['error']); ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="success" role="alert">
                        <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>

                <div class="input-holder">
                    <label>Select File</label>
                    <input type="file" name="file" class="input-1" required>
                </div>
                
                <?php echo CSRF::getTokenField(); ?>
                <button class="edit-btn">Upload File</button>
            </form>

            <!-- Display Uploaded Files -->
            <div class="uploaded-files" style="margin-top: 20px;">
                <h5>Your Uploaded Files:</h5>
                <?php
                include "DB_connection.php";
                $stmt = $conn->prepare("SELECT * FROM file_uploads WHERE user_id = ? ORDER BY upload_date DESC");
                $stmt->execute([$_SESSION['id']]);
                $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($files) {
                    echo "<table class='table'>";
                    echo "<tr><th>File Name</th><th>Upload Date</th><th>Type</th></tr>";
                    foreach ($files as $file) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($file['original_name']) . "</td>";
                        echo "<td>" . $file['upload_date'] . "</td>";
                        echo "<td>" . $file['file_type'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No files uploaded yet.</p>";
                }
                ?>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(1)");
        active.classList.add("active");
    </script>
</body>
</html>
<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
?> 