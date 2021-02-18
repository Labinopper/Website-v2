<?php
    session_start();
    // When form submitted, check and create user session.
    require '/db_connection.php';

    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($conn, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($conn, $password);
        // Check user is exist in the database
        $query    = "SELECT * FROM `Users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($conn, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $row['id'];
                //$_SESSION['strava_access_token'] = $row['strava_access_token'];
                //$_SESSION['strava_refresh_token'] = $row['strava_refresh_token'];
                //$_SESSION['strava_access_token_expires_at'] = $row['strava_access_token_expires_at'];

            }
            // Redirect to user dashboard page
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='index.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
    <div id="login-form">
    <form method="post" name="login">
        <h1 class="login-title">Login here!!</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/><br>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        </form>
  </div>
</body>
</html>