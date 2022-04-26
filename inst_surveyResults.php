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
                    $statement = $dbh->query("select course.course_id, course.title from course left outer join teaches on course.course_id = teaches.course_id where inst_name = '$currentUser'");
                    $statement->execute();
                    $dbh = null;
                } catch (PDOException $e) {
                    print "Error!" . $e->getMessage() . "<br/>";
                    die();
                }
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $courseID = $row['course_id'];
                    $courseTitle = $row['title'];
                ?> <h3><?php echo $courseID ?> <?php echo $courseTitle ?></h3> <?php
                    responseRate($courseID);
                    multChoiceResults($courseID);
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php

// Function to print off the response rate for the results
function responseRate($courseID)
{
    $totalStu = 0.0;
    $completedStu = 0.0;

    // Query to get total count of students in a given class
    try {
        $dbh = connectDB();
        $statement = $dbh->query("select count(stu_name) from takes where course_id = '$courseID'");
        $statement->execute();
        $totalStu = $statement->fetch();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }

    // Query to get total count of students who completed survey for a given class
    try {
        $dbh = connectDB();
        $statement = $dbh->query("select count(stu_name) from takes where course_id = '$courseID' and complete = 1");
        $statement->execute();
        $completedStu = $statement->fetch();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }

    // Printing information for the response rate
    $percentage = floatval($completedStu[0]) / floatval($totalStu[0]) * 100;
?> Response Rate: <?php echo $completedStu[0] ?> / <?php echo $totalStu[0] ?>  (<?php echo $percentage ?>%)<br> <?php
}

// Function to print off the mutliple choice results
function multChoiceResults($courseID) {
    //frequency for each choice
    try {
        $dbh = connectDB();
        $statement = $dbh->query("select count(a_text) from results where question_id = and course_id = '$courseID', survey.q_text, mult_choice.choice from survey left outer join mult_choice on survey.question_id = mult_choice.question_id where q_type = 'Multiple Choice'");
        $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }


    ?>
    <table>
        <tr>
            <td>Response Option</td>
            <td>Frequency</td>
            <td>Percent</td>
        </tr>
        <tbody>
            <?php
            // Query to find multiple choice question and get information
            try {
                $dbh = connectDB();
                $statement = $dbh->query("select survey.question_id, survey.q_text, mult_choice.choice from survey left outer join mult_choice on survey.question_id = mult_choice.question_id where q_type = 'Multiple Choice'");
                $statement->execute();
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!" . $e->getMessage() . "<br/>";
                die();
            }
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo'<tr>';
                echo'<td>'.$row['question_text'].'<td>';
                echo'<td>'.$row['question_id'].'<td>';
                echo'<td>'.$row['question_id'].'<td>';
                echo'<tr>';
            }
            ?>
        </tbody>
    </table>
    <?php
}

function essayResults($courseID) {
    ?>
    <table>
        <tr>
            <td>Frequency</td>
            <td>Percent</td>
        </tr>
        <tbody>
            <?php
            // Query to find multiple choice question and get information
            try {
                $dbh = connectDB();
                $statement = $dbh->query("select question_id, q_text from survey where q_type = 'Essay'");
                $statement->execute();
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!" . $e->getMessage() . "<br/>";
                die();
            }
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo'<tr>';
                echo'<td>'.$row['question_text'].'<td>';
                echo'<td>'.$row['question_id'].'<td>';
                echo'<tr>';
            }
            ?>
        </tbody>
    </table>
    <?php
    try {
        $dbh = connectDB();
        $statement = $dbh->query("select count(a_text) from results where question_id = and course_id = '$courseID'");
        $statement->execute();
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

?>