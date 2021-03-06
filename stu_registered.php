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
        <div class="currentCourses">
            <table>
                <tbody>
                    <?php
                        /* Fetch the current user's course */
                        $currentUser = $_SESSION["username"];
                        $COURSES = array();
                        $COURSE_TITLES = array();
                        try {
                            $dbh = connectDB();
                            $statement = $dbh->query("select course.course_id, course.title from course left outer join takes on course.course_id = takes.course_id where stu_name = '$currentUser'");
                            $statement->execute();
                            $dbh = null;
                        } catch(PDOException $e) {
                            print "Error!" . $e->getMessage() . "<br/>";
                            die();
                        } 
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            $COURSES[] = array('CourseID' => $row['course_id']);
                            $COURSE_TITLES[] = array('CourseTitle' => $row['title']);
                        }
                        array_map(function($COURSES, $COURSE_TITLES) {
                            echo'<tr>';
                            echo'<td>'.$COURSES['CourseID'].'<td>';
                            echo'<td>'.$COURSE_TITLES['CourseTitle'].'<td>';
                            echo'<tr>';
                        }, $COURSES, $COURSE_TITLES);
                    ?>
                </tbody>
            </table>
        </div>
        <h1>Survey Status</h1>
        <div class="surveyUNCOMPLETED">
            <h3><u>UNCOMPLETED</u></h3> <!-- Uncompleted survey list --> 
            <form method = "post" >
                <table>
                    <tbody>
                        <?php
                            /* Fetch the current user's course */
                            $currentUser = $_SESSION["username"];
                            $COURSES = array();
                            $COURSE_TITLES = array();
                            try {
                                $dbh = connectDB();
                                $statement = $dbh->query("select course.course_id, course.title from course left outer join takes on course.course_id = takes.course_id where stu_name = '$currentUser' and complete = 0");
                                $statement->execute();
                                $dbh = null;
                            } catch(PDOException $e) {
                                print "Error!" . $e->getMessage() . "<br/>";
                                die();
                            } 
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $COURSES[] = array('CourseID' => $row['course_id']);
                                $COURSE_TITLES[] = array('CourseTitle' => $row['title']);
                            }
                            array_map(function($COURSES, $COURSE_TITLES) {
                                echo'<tr>';
                                echo'<td>'.$COURSES['CourseID'].'<td>';
                                echo'<td>'.$COURSE_TITLES['CourseTitle'].'<td>';
                                echo'<td><button value=' . $COURSES['CourseID'] . ' name="todo" />TO-DO</button><td>';
                                echo'<tr>';
                            }, $COURSES, $COURSE_TITLES);
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
        
        <div class="surveyCOMPLETED">
            <h3><u>COMPLETED</u></h3> <!-- Completed survey list --> 
            <form method = "post" >
                <table>
                    <tbody>
                        <?php
                            /* Fetch the current user's course */
                            $currentUser = $_SESSION["username"];
                            $COURSES = array();
                            $COURSE_TITLES = array();
                            try {
                                $dbh = connectDB();
                                $statement = $dbh->query("select distinct course.course_id, course.title, results.timestamp from results left outer join takes on results.course_id = takes.course_id left outer join course on takes.course_id = course.course_id where results.stu_name = '$currentUser' and complete = 1 and results.question_id = 1");
                                $statement->execute();
                                $dbh = null;
                            } catch(PDOException $e) {
                                print "Error!" . $e->getMessage() . "<br/>";
                                die();
                            } 
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $COURSES[] = array('CourseID' => $row['course_id']);
                                $COURSE_TITLES[] = array('CourseTitle' => $row['title']);
                                $timestamp[] = array('timestamp' => $row['timestamp']);
                            }
                            array_map(function($COURSES, $COURSE_TITLES, $timestamp) {
                                echo'<tr>';
                                echo'<td>'.$COURSES['CourseID'].'<td>';
                                echo'<td>'.$COURSE_TITLES['CourseTitle'].'<td>';
                                echo'<td>'.$timestamp['timestamp'].'<td>';
                                echo'<tr>';
                            }, $COURSES, $COURSE_TITLES, $timestamp);
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </body>
</html>
<?php
    if (isset($_POST["todo"])) {
        $_SESSION["courseID"] = $_POST["todo"];
        header("Location: https://classdb.it.mtu.edu/~empinnoo/survey.php");
    }
?>