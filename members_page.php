<?php
	session_start();
	if (!isset($_SESSION['user_id'])) or ($_SESSION['user_lvl'] != 0){
		header('Location: login_page.php');
		exit();
	}
?>
<!doctype html>
<html lang ="en">
<head>
	<title> Website ni Ancheta</title>
	<meta charset = "utf-8">
	<link rel= "stylesheet" type="text/css" href="includes.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div id = "head-nav">
		<?php include ('header.php'); ?>
        <div id = "nav">
        <ul>
            <li><a href="change_pass.php" title="Change Password">Change Password</a></li>
            <li><a href="logout.php" title="Log Out">Log Out</a></li>
            <li><a href="page1.php" title="Contact">Contact Us</a></li>
        </ul>
        </div>
	<div id = "container_new">
		<div id="content">
			<h2>This is the Member's Page</h2>
            <p>Thank you for being a member of this website! If you want to access more tools, you can subscribe to a plan provided below.</p>
            <img src="subscriptions-members-theme-1.png" alt="Not a fake dashboard" width="900" height="500">
            <p>Note: We have your family, pay up.</p>
		</div>
	</div>
	<?php include('footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>