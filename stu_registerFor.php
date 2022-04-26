<?php
session_start();
require "db.php";
?>
<html>

<body>
    <?php include 'stu_sidebar.html'; ?>
    <style>
        body {
            margin-top: 5%;
            margin-left: 20%;
        }
    </style>
    <h1>Courses</h1>
    <div class="courseList">
        <form method="post">
            <table>
                <tbody>
                    <?php
                    /* Fetch the current user's course */
                    $currentUser = $_SESSION["username"];
                    $COURSES = array();
                    $COURSE_TITLES = array();
                    $COURSE_CREDITS = array();
                    try {
                        $dbh = connectDB();
                        $statement = $dbh->query("select course_id, title, credit from course where course_id NOT IN (select course_id from takes where stu_name = '$currentUser')");
                        $statement->execute();
                        $dbh = null;
                    } catch (PDOException $e) {
                        print "Error!" . $e->getMessage() . "<br/>";
                        die();
                    }
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $COURSES[] = array('CourseID' => $row['course_id']);
                        $COURSE_TITLES[] = array('CourseTitle' => $row['title']);
                        $COURSE_CREDITS[] = array('CourseCredit' => $row['credit']);
                    }
                    array_map(function ($COURSES, $COURSE_TITLES, $COURSE_CREDITS) {
                        echo '<tr>';
                        echo '<td>' . $COURSES['CourseID'] . '<td>';
                        echo '<td>' . $COURSE_TITLES['CourseTitle'] . '<td>';
                        echo '<td>' . $COURSE_CREDITS['CourseCredit'] . '<td>';
                        echo '<td><input type="submit" value="Register" class="register-btn" name="markCompleted" /><td>';
                        echo '<td><input type="hidden" value=' . $COURSES['CourseID'] . ' name="courseID" /><td>';
                        echo '<tr>';
                    }, $COURSES, $COURSE_TITLES, $COURSE_CREDITS);
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>
<?php
// User clicked the register button
if (isset($_POST["markCompleted"])) {
    $courseID = $_POST['courseID'];
    $query = "Insert into takes values('$currentUser','$courseID',0)"; //query to update password

    try {
        $dbh = connectDB();
        $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
        //$step->bindParam(':courseID', $_POST["courseID"]);

        if ($step->execute()) {
            //if successful, shows popup and refresh page
?>
            <script>
                alert("Registered course successfully!")
            </script>

<?php
            header("Location: https://classdb.it.mtu.edu/~empinnoo/stu_registerFor.php");
        } else {
            //print error messages if query could not be performed
            print "The course was unable to be registered.  Please try again.";
            print $e->getMessage();
        }
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}
?>