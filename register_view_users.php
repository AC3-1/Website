<!doctype html>
<html lang ="en">
<head>
	<title> Registered Users</title>
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
	<div id = "container_table">
		<div id="content_table">
			<h2>Registered Users List</h2>
			<p>
			<?php
				require('mysqli_connect.php');
				//fetch data
				$q = "SELECT user_id, CONCAT(lname , ', ' , fname) as Name, email, DATE_FORMAT(registration_date, '%M %d, %Y') as regdate from users ORDER BY registration_date ASC";
				$result = @mysqli_query($dbcon, $q);
				if($result){ // success
					echo '<table class="table table-striped table-bordered table-hover shadow-lg p-3 mb-5 bg-white rounded">
					<thead class="thead-dark">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Registration Date</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>';
					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						echo '<tbody>
							<tr>
								<td>'.$row['Name'] .'</td>
								<td>'.$row['email'] .'</td>
								<td>'.$row['regdate'] .'</td>
								<td><a href="edit_user.php?id='.$row['user_id'].'">Edit</a></td>
								<td><a href="delete_user.php?id='.$row['user_id'].'">Delete</a></td>
							</tr>
						</tbody>';
					}
					echo '</table>';
					mysqli_free_result($result);
				}else{ // fail
					echo '<p class="error">System Error. Cannot retrieve user data. ERROR CODE: 21</p>';
				}
				mysqli_close($dbcon);
			?>
			</p>
		</div>
	</div>
	<?php include('footer.php'); ?>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>