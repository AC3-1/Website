<!doctype html>
<html lang ="en">
<head>
	<title>Edit User Info</title>
	<meta charset = "utf-8">
	<link rel= "stylesheet" type="text/css" href="includes.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div id = "head-nav">
		<?php include ('header.php'); ?>
		<?php include ('nav.php'); ?>
	<div id = "reg">
		<div id="edit_users">
			<h2 class="title">Edit User Record</h2>
			<?php
				if((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
					$id = $_GET['id'];
				}elseif((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
					$id = $_POST['id'];
				}else{ //no id was found
					echo '<p class = "error">This page has been accessed by mistake....</p>';
					exit();
				}
				require('mysqli_connect.php');
				if($_SERVER['REQUEST_METHOD'] == 'POST'){
					$errors = array();
					//check if there is a fname, lname, email textbox
					if(empty($_POST['fname'])){
						$errors[] = 'Please input your First Name.';
					}else{
						$fn = trim($_POST['fname']);
					}
					//check lastname and email
					if(empty($_POST['lname'])){
						$errors[] = 'Please input your Last Name.';
					}else{
						$ln = trim($_POST['lname']);
					}
					if(empty($_POST['email'])){
						$errors[] = 'Please input your Email.';
					}else{
						$e = trim($_POST['email']);
					}
					if(empty($errors)){
						$q = "UPDATE users SET fname='$fn', lname='$ln', email='$e' WHERE user_id='$id' LIMIT 1";
						$result = @mysqli_query($dbcon, $q);
						if(mysqli_affected_rows($dbcon) == 1){
							echo'<h3>User info edited successfully!</h3>';
							echo'<h3><a href="register_view_users.php">Go to Users</a></h3>';
						}else{
							echo'<h3>User info failed to edit.</h3>';
							echo'<p>'.mysqli_error($dbcon).'</p>';
						}
					}else{
						//display errors
						echo '<h3>Error!</h3><p class = "error">The following error(s) occurred:<br/>';
						foreach($errors as $msg){
							echo " - $msg<br/>\n";
						}
						echo '</p><h4>Please try again</h4><br/><br/>';
					}

				}
				$q = "SELECT fname, lname, email FROM users WHERE user_id='$id'";
				$result = @mysqli_query($dbcon, $q);
				if(mysqli_num_rows($result) == 1){ // valid user id entered
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					//create form
					echo'
						<form action="edit_user.php" method="post" class="form">
                <div class="flex">
                    <div class="form-group">
                        <label for="fname">
                            <input type="text" id="fname" name="fname" class="input" size="30" maxlength="40"
                            value="'.$row['fname'].'">
                            <span>First Name</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="lname">
                            <input type="text" id="lname" name="lname" class="input" size="30" maxlength="40"
                            value="'.$row['lname'].'">
                            <span>Last Name</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">
                        <input type="email" id="email" name="email" class="input" size="50" maxlength="40"
                        value="'.$row['email'].'">
                        <span>Email</span>
                    </label>
                </div>
				<div class="form-group">
                    <button type="submit" id="edit_ye" name="edit" class="edit">Edit</button>
                </div>
				<p><input type="hidden" name="id" value="'.$id.'"></p>
					</form>
					';

				}else{//id not valid
					echo'<h2>Invalid user ID</h2>';
					echo'<h3><a href="register.php">Register Here</a> if you have no account</h3>';
				}
				mysqli_close($dbcon);
			?>
		</div>
	</div>
	<?php include('footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>