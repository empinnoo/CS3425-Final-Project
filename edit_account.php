<?php
session_start();
require "db.php";
?>
<html>

<body>
    <h1>Edit Account</h1>
    <form method=post>
        <div class="username"><input type="text" placeholder="Username" name="username"></div>
        <div class="password"><input type="password" placeholder="Old Password" name="oldPassword"></div>
        <div class="newPassword"><input type="password" placeholder="New Password" name="newPassword"></div>
        <div class="edit"><input type="submit" value="Edit" name="edit"></div>
    </form>
</body>

</html>
<?php
// The start of database connection and editing
if (isset($_POST['edit']) && isset($_POST['username']) && isset($_POST['oldPassword']) && isset($_POST['newPassword'])) {

    // Setting variables of information in textboxes
    $check = 0; // Check for if stu or inst table should be accessed
    $username = $_POST["username"]; // variable username is the value in the username text box
    $newPassword = $_POST['newPassword']; // variable newPassword is the value in the new password text box
    $oldPassword = $_POST['oldPassword']; // variable oldPassword is the value in the old password text box

    try {
        $dbh = connectDB();

        //query to look for student account with the credentials given (prepare used to prevent SQL injection)
        $accountquery = "Select * from student where stu_name = :username";
        $accountstep = $dbh->prepare($accountquery);
        $accountstep->bindParam(':username', $username);
        $accountstep->execute();
        $accountFound = $accountstep->fetch();

        if (!$accountFound) { // result did not return a student account, look for an instructor one
            $accountquery = "Select * from instructor where inst_name = :username";
            $accountstep = $dbh->prepare($accountquery);
            $accountstep->bindParam(':username', $username);
            $accountstep->execute();
            $accountFound = $accountstep->fetch();
            $check = 1;
        }

        if (!$accountFound) { // result did not return an instructer account, send alert
?>
            <script>
                alert("The credentials given are not linked to a current account.  Please make sure that the username, old password, and new password are correct and try again.")
            </script>
            <?php
        } else { // Should be good to change the password

            $query = "";
            if ($check == 0) {
                $query = "Update student set stu_password = sha2(:newPassword,256) where stu_name = :username"; //query to update password
            } else {
                $query = "Update instructor set inst_password = sha2(:newPassword,256) where inst_name = :username"; //query to update password
            }
            $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
            $step->bindParam(':username', $username); //bind the parameters of query to form answers
            $step->bindParam(':newPassword', $newPassword);

            if ($step->execute()) {
                //if successful, shows popup and redirects to login.php
                ?>
                <script>
                    alert("New password has been set successfully!")
                </script>
                <?php
                header("Location: https://classdb.it.mtu.edu/~empinnoo/login.php");
            } else {
                //print error messages if query could not be performed
                print "The password was not able to be changed.  Please try again.";
                print $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        //print error messages if query could not be performed due to backend/database issues
        print "The account was not able to be created.  Please try again.";
        print $e->getMessage();
        die();
    }
}
?>