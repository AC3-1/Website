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
        <?php include ('nav.php'); ?>
    </div>
    <div id="reg">
        <div id="register">
            <?php
            if($_SERVER['REQUEST_METHOD']=='POST'){
                //error array to store all errons
                $errors = array();
                // may nilagay ba na frase?
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
                if(!empty($_POST['psword1']) && !empty($_POST['psword2'])){
                    if($_POST['psword1'] != $_POST['psword2']){
                        $errors[] = 'Passwords did not match.';
                    }else{
                        $salt = bin2hex(random_bytes(1));
                        $iterations = 1;
                        $length = 16;
                        $p = trim($_POST['psword1']);
                        $hashed_password = hash_pbkdf2("sha256", $p, $salt, $iterations, $length, false);
                    }
                }else{
                    $errors[] = 'Please input your Password.';
                }
                // all feilds are successful
                if(empty($errors)){
                    require('mysqli_connect.php');
                    // query to insert registered data
                    $q = "INSERT INTO users (fname, lname, email, psword, salt, registration_date) values ('$fn', '$ln', '$e', '$hashed_password', '$salt', NOW());";
                    $result = @mysqli_query($dbcon, $q);
                    if($result){
                        header("location: register_success.php");
                        exit();
                    }else{
                        echo'<h2>System Error</h2><p> class="error"> Your registration failed due to an unexpected error.</p>';
                        echo '<p>'.mysqli_error($dbcon).'</p>';
                    }
                    mysqli_close($dbcon);
                    include('footer.php');
                    exit();
                }else{
                    echo '<h3>Error!</h3><p class = "error">The following error(s) occured:<br/>';
                    foreach($errors as $msg){
                        echo " - $msg<br/>\n";
                    }
                    echo '</p><h4>Please try again</h4><br/><br/>';
                }
            }
        ?>
           <h2 class="title">Registration Page</h2>
            <form action="register.php" method="post" class="form">
                <div class="flex">
                    <div class="form-group">
                        <label for="fname">
                            <input type="text" id="fname" name="fname" class="input" size="30" maxlength="40" 
                            value="<?php if(isset($_POST['fname'])) echo $_POST['fname'];?>" required>
                            <span>First Name</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="lname">
                            <input type="text" id="lname" name="lname" class="input" size="30" maxlength="40" 
                            value="<?php if(isset($_POST['lname'])) echo $_POST['lname'];?>" required>
                            <span>Last Name</span>
                        </label>
                    </div>
                </div>  
                
                <div class="form-group">
                    <label for="email">
                        <input type="email" id="email" name="email" class="input" size="50" maxlength="40" 
                        value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" required>
                        <span>Email</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="psword1">
                        <input type="password" id="psword1" name="psword1" class="input" size="50" maxlength="40" 
                        value="<?php if(isset($_POST['psword1'])) echo $_POST['psword1'];?>" required>
                        <span>Password</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="psword2">
                        <input type="password" id="psword2" name="psword2" class="input" size="50" maxlength="40" 
                        value="<?php if(isset($_POST['psword2'])) echo $_POST['psword2'];?>" required>
                        <span>Confirm Password</span>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" id="submit" name="submit" class="submit">Submit</button>
                </div>
            
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>