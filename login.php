<?php
// Start session
session_start();
?>

<head>

<body>
    <p>
        <!-- action of login button -->
    <form method=post action=login.php>
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
        header("Location: https://classdb.it.mtu.edu/~empinnoo/stu_registered.php");
        return;
    } else if (authenticateInst($_POST["username"], $_POST["password"]) == 1) {
        $_SESSION["username"] = $_POST["username"];
        header("Location: https://classdb.it.mtu.edu/~empinnoo/inst_courses.php");
        return;
    } else {
        echo '<p style="color:red">incorrect username and password</p>';
    }
}

// user clicked the logout button
if (isset($_POST["logout"])) {
    session_destroy();
}

//check if login form was submitted
//if (isset($_POST['login'])) {
//queries
//$stu_login = "select count(*) from student where stu_name = :userVal and stu_password = :passVal";
//$inst_login = "select count(*) from instructor where inst_name = :userVal and inst_password = :passVal";
//$stu_first_login = "select count(*) from student where stu_name = :userVal";
//$inst_first_login = "select count(*) from instructor where inst_name = :userVal";

//if not the user's first login, proceed with regular login; else, redirect to edit_account.php
//if (isFirstLogin($_POST['username'], $stu_first_login) || isFirstLogin($_POST['username'], $inst_first_login)) {
//if user is a student, check student table for matching info then redirect to student view
//if ((authenticate($_POST['username'], $_POST['password'], $stu_login)) == 1) {
//    $_SESSION['username'] = $_POST['username'];
//    header("LOCATION:stu_registered.php");
//    return;
//} //if user is instructor, check instuctor table for matching info then redirect to instructor view
//else if ((authenticate($_POST['username'], $_POST['password'], $inst_login)) == 1) {
//    $_SESSION['username'] = $_POST['username'];
//    header("LOCATION:inst_courses.php");
//    return;
//} //neither username and/or password match data from student nor instructor
//else {
//    echo '<p style="color:red">Incorrect username and/or password</p>';
//}
//} else {
//    header("LOCATION:edit_account.php");
//    return;
//}
//}
?>