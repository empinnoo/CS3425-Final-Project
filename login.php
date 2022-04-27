<?php
// Start session
session_start();
?>

<head>

<body>
    <p>
        <!-- action of login button -->
    <form method=post action=login.php>
        <h1>School Survey Login</h1>
        username: <input type="text" name="username"></input><br>
        password: <input type="password" name="password"></input><br>
        <button type="submit" name="login">login</button>
    </form>
    </p>
</body>
</head>

<?php
require "db.php";

// Code to handle the login and logout
// user clicked the login button
if (isset($_POST["login"])) {
    // if username and password correct, redirect to main page
    if (authenticateStu($_POST["username"], $_POST["password"]) == 1) {

        $_SESSION["username"] = $_POST["username"];
        $username = $_SESSION["username"];

        // Query to get whether or not it was student's first login
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare("Select first_login from student where stu_name = '$username'");
            $result = $statement->execute();
            $row = $statement->fetch();
            $dbh = null;

            // Normal login
            if ($row[0] == 1) {
                header("Location: https://classdb.it.mtu.edu/~empinnoo/stu_registered.php");
                return;

                // Go to edit account page and update first_login value
            } else {
                $query = "Update student set first_login = 1 where stu_name = '$username'"; //query to update first_login
                $dbh = connectDB();
                $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
                $step->execute();
                $dbh = null;
                header("Location: https://classdb.it.mtu.edu/~empinnoo/edit_account.php");
                return;
            }
        } catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    } else if (authenticateInst($_POST["username"], $_POST["password"]) == 1) {

        $_SESSION["username"] = $_POST["username"];
        $username = $_SESSION["username"];

        // Query to get whether or not it was instructor's first login
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare("Select first_login from instructor where inst_name = '$username'");
            $result = $statement->execute();
            $row = $statement->fetch();
            $dbh = null;

            // Normal login
            if ($row[0] == 1) {
                header("Location: https://classdb.it.mtu.edu/~empinnoo/inst_courses.php");
                return;

                // Go to edit account page and update first_login value
            } else {
                $query = "Update instructor set first_login = 1 where inst_name = '$username'"; //query to update first_login
                $dbh = connectDB();
                $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
                $step->execute();
                $dbh = null;
                header("Location: https://classdb.it.mtu.edu/~empinnoo/edit_account.php");
                return;
            }
        } catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }

        // Else wrong username and or password
    } else {
        echo '<p style="color:red">incorrect username and password</p>';
    }
}

// user clicked the logout button
if (isset($_POST["logout"])) {
    session_destroy();
}
?>