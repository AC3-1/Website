<title>Deleting Users</title>
	<meta charset = "utf-8">
	<link rel= "stylesheet" type="text/css" href="includes.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div id = "head-nav">
		<?php include ('header.php'); ?>
		<?php include ('nav.php'); ?>
	</div>
	<div id = "delete_view">
		<div id="delete_msg">
			<h2 class = "p-3 mb-2 bg-danger text-white" id = "delete_h2">Deleting Record</h2>
			<?php
				// check id number if valid
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
					if($_POST['sure'] == 'Yes'){
						// delete user
						$q = "DELETE FROM users WHERE user_id = $id";
						$result = @mysqli_query($dbcon, $q);
						if(mysqli_affected_rows($dbcon) == 1){
							// no problem, success deletion
							echo '<h3>The record had been deleted</h3>';
						}else{ // deletion failed
							echo '<h3>Deletion failed</h3>';
						}
					}else{
						echo '<h3>The record has not been deleted</h3>';
					}
				}else{
					//display info of user that is to be deleted
					$q = "SELECT CONCAT(fname, ' ', lname) from users where user_id=$id";
					$result = @mysqli_query($dbcon, $q);
					if(mysqli_affected_rows($dbcon) == 1){ // may nakuha na ID
						$row = mysqli_fetch_array($result, MYSQLI_NUM);
						echo '<h2 id="usure">Are you sure you want to permanently delete <b>'.$row[0].'</b>?</h2>';
						//display buttons for delete
						echo '
						<form action="delete_user.php" method="post">
						<input id="submit-yes" type="submit" name="sure" value="Yes">
						<input id="submit-no" type="submit" name="sure" value="No">
						<input type="hidden" name="id" value="'.$id.'">
						</form></form>
						';
					}else{
						//user did not exist
						echo 'User does not exist';
					}
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