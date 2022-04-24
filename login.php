<?php 
    include('db.php'); 
    session_start();
?>
<html>
    <body>
        <form method=post>
            <div class="username"><input type="text" placeholder="Username" name="username"></div>
            <div class="password"><input type="password" placeholder="Password" name="password"></div>
            <div class="login"><input type="submit" value ="Login" name="login"></div>
        </form>
    </body>
</html>
<?php
    //check if login form was submitted
    if (isset($_POST['login'])) {
        //queries
        $stu_login = "select * from student where stu_name = :userVal and stu_password = :passVal";
        $inst_login = "select * from instructor where inst_name = :userVal and inst_password = :passVal";

        //if not the user's first login, proceed with regular login; else, redirect to edit_account.php
        if (!(isFirstLogin($_POST['username']))) {
            //if user is a student, check student table for matching info then redirect to student view
            if (authenticate($_POST['username'], $_POST['password'], 'student')) {
                $_SESSION['username'] = $_POST['username'];
                header("LOCATION:stu_registered.php");
                return;
            } //if user is instructor, check instuctor table for matching info then redirect to instructor view
            else if (authenticate($_POST['username'], $_POST['password'], 'instructor')) {
                $_SESSION['username'] = $_POST['username'];
                header("LOCATION:inst_courses.php");
                return;
            } //neither username and/or password match data from student nor instructor
            else {
                echo '<p style="color:red">Incorrect username and/or password</p>';
            }
        } else {
            header("LOCATION:edit_account.php");
        }
    }
    //user clicked the logout button
    if (isset($_POST['logout'])) {
        session_destroy();
    }
?>