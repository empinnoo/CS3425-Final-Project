<?php
    session_start();
    require "db.php";
?>
<html>
    <body>
        <?php include 'inst_sidebar.html'; ?>
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
                        try {
                            $dbh = connectDB();
                            $statement = $dbh->query("select course.course_id, course.title from course left outer join teaches on course.course_id = teahces.course_id where inst_name = '$currentUser'");
                            $statement->execute();
                            $dbh = null;
                        } catch(PDOException $e) {
                            print "Error!" . $e->getMessage() . "<br/>";
                            die();
                        } 
                        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                            $courseID = $row['course_id'];
                            $courseTitle = $row['title'];
                            ?> <h3><?php echo $courseID ?> <?php echo $courseTitle ?></h3> <?php
                            printStudents($courseID);
                        }
                        
                        function printStudents ($courseID) {
                            try {
                                $dbh = connectDB();
                                $statement = $dbh->query("select stu_name from takes where course_id = '$courseID'");
                                $statement->execute();
                                $dbh = null;
                            } catch(PDOException $e) {
                                print "Error!" . $e->getMessage() . "<br/>";
                                die();
                            } 
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                $student = $row['student'];
                                ?> <?php echo $student ?> <br> <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>