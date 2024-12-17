<!doctype html>
<html lang="en">
<head>
    <title>Website ni Ancheta</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="includes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div id="head-nav">
        <?php include('header.php'); ?>
        <?php include('nav.php'); ?>
    </div>
    <div id="reg">
        <div id="register">
        <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');
    //Email validation
    if (!empty($_POST['email'])) {
        $e = mysqli_real_escape_string($dbcon, $_POST['email']);
    } else {
        echo '<p class="error">Empty Field: Email</p>';
        $e = null;
    }
    //Password validation
    if (!empty($_POST['psword1'])) {
        $p = mysqli_real_escape_string($dbcon, $_POST['psword1']);
    } else {
        echo '<p class="error">Empty Field: Password</p>';
        $p = null;
    }
    if ($e && $p) {
        $q = "SELECT user_id, fname, user_lvl, psword, salt FROM users WHERE email = '$e'";
        $result = mysqli_query($dbcon, $q);
        if (!$result) {
            //SANITY CHECK TV SERIES: LET ME SEE DEM DITTIES
            echo '<p>Error with query: ' . mysqli_error($dbcon) . '</p>';
        }
        if ($result && mysqli_num_rows($result) > 0) {
            //Get user info from db
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $stored_hashed_password = $row['psword'];
            $stored_salt = $row['salt'];
            $iterations = 1;
            $length = 16;
            $hashed_input_password = hash_pbkdf2("sha256", $p, $stored_salt, $iterations, $length, false);
            //SANITY CHECK PART 2: I WISH MY LIFE IS DUE
            echo '<p>Stored Hashed Password: ' . $stored_hashed_password . '</p>';
            echo '<p>Input Hashed Password: ' . $hashed_input_password . '</p>';
            echo '<p>Stored salt: ' . $stored_salt . '</p>';
            if ($hashed_input_password === $stored_hashed_password) {
                //Start session
                session_start();
                //SANITY CHECK: THE ORIGINAL
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['user_lvl'] = (int) $row['user_lvl'];
                //Redirect ADMIN OR MEMBER
                $url = ($_SESSION['user_lvl'] === 1) ? 'admin_page.php' : 'members_page.php';
                header('Location: ' . $url);
                exit();
            } else {
                echo '<p class="error">Invalid password. Please try again.</p>';
            }
        } else {
            echo '<p>No user found for email: ' . htmlspecialchars($e) . '</p>';
            echo '<p class="error">You\'re not in the system.</p>';
        }
        //Free result and close connection
        mysqli_free_result($result);
    } else {
        echo '<p class="error">Please fill in all fields and try again.</p>';
    }
    mysqli_close($dbcon);
}
?>

            <h2 class="title">Login Page</h2>
            <form action="login_page.php" method="post" class="form">
                <div class="form-group">
                    <label for="email">
                        <input type="email" id="email" name="email" class="input" size="50" maxlength="40"
                        value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" required>
                        <span>Email</span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="psword1">
                        <input type="password" id="psword1" name="psword1" class="input" size="50" maxlength="40"
                        required>
                        <span>Password</span>
                    </label>
                    <h7>No Account? <a href="register.php">Register Here</a></h7>
                </div>
                <div class="form-group">
                    <button type="submit" id="submit" name="submit" class="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>