<?php 
    include('db.php'); 
    session_start();
?>
<html>
    <body>
        <form method=post>
            <div class="username"><input type="text" placeholder="Username" name="username"></div>
            <div class="password"><input type="password" placeholder="Old Password" name="oldPassword"></div>
            <div class="newPassword"><input type="password" placeholder="New Password" name="newPassword"></div>
            <div class="edit"><input type="submit" value ="Edit" name="edit"></div>
        </form>
    </body>
</html>
<?php
    //Confirm the current password before editing
    if (isset($_POST['edit'])) {
        //queries
        $stu_edit = "update student set stu_password = :newPassVal where stu_name = :userVal and stu_password = :oldPassVal";
        $inst_edit = "update instructor set inst_password = :newPassVal where inst_name = :userVal and inst_password = :oldPassVal";
        $oldHashedPassword = $_POST['oldPassword'];

        //if user is a student, check student table for matching info then redirect to student view
        if ((editAccount($_POST['username'], $_POST['oldPassword'], $_POST['newPassword'], $stu_edit)) == 1) {
            $_SESSION['username'] = $_POST['username'];
            header("LOCATION:stu_registered.php");
            return;
        } //if user is instructor, check instuctor table for matching info then redirect to instructor view
        else if ((editAccount($_POST['username'], $_POST['oldPassword'], $_POST['newPassword'], $inst_edit)) == 1) {
            $_SESSION['username'] = $_POST['username'];
            header("LOCATION:inst_courses.php");
            return;
        } //neither username and/or password match data from student nor instructor
        else {
            echo '<p style="color:red">Incorrect username and/or old password</p>';
        }
    }
?>