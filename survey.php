<?php
session_start();
require "db.php";
?>
<html>

<body>
    <form method=post>
        <?php
        $currentUser = $_SESSION["username"];
        $course_id = $_SESSION['courseID'];

        $query = "select * from survey";
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare($query); //prepare statement to prevent SQL injection
            $statement->execute();
            $dbh = null;
        } catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
        $count = 0;
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $q_id = $row['question_id'];
            $q_text = $row['q_text'];
            $q_type = $row['q_type'];
            $count++;
            if (strcmp($q_type, 'Multiple Choice') == 0) {
                createMultipleChoice($q_id, $q_text);
            } else {
                createEssay($q_id, $q_text);
            }
        }

        /* Creates the multiple choice questions for the survey */
        function createMultipleChoice($q_id, $q_text)
        {
            $query = "select * from mult_choice where question_id = '$q_id'";
            try {
                $dbh = connectDB();
                $statement = $dbh->prepare($query); //prepare statement to prevent SQL injection
                $statement->execute();
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!" . $e->getMessage() . "<br/>";
                die();
            }
        ?>
            <p>Q<?php echo $q_id ?>: <?php echo $q_text ?></p>
            <?php

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $choice = $row['choice'];
            ?>
                <input type="radio" value="<?php echo $choice ?>" name="<?php echo $q_id ?>"><?php echo $choice ?></input><br>
            <?php
            }
        }

        /* Creates the essay questions for the survey */
        function createEssay($q_id, $q_text)
        {
            ?>
            <p>Q<?php echo $q_id ?>: <?php echo $q_text ?></p>
            <?php
            ?>
            <input type="text" name="<?php echo $q_id ?>"><br>
        <?php
        }
        ?>
        <br><button type="submit" name="submitSurvey">Submit</button>
    </form>
</body>

</html>

<?php

// If the submit survey button is clicked
if (isset($_POST['submitSurvey'])) {

    // Put information into results table
    for ($i = 1; $i <= $count; $i++) {
        $a_text = $_POST["$i"];

        $query = "Insert into results values('$i','$currentUser','$course_id','$a_text',current_timestamp)"; //query to update results

        try {
            $dbh = connectDB();
            $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
            $step->execute();
            $dbh = null;
        } catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Update takes table that student has completed the survey
    $query = "Update takes set complete = 1 where stu_name = '$currentUser' and course_id = '$course_id'"; //query to update takes table

        try {
            $dbh = connectDB();
            $step = $dbh->prepare($query); //prepare statement to prevent SQL injection
            $step->execute();
            $dbh = null;
        } catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }

    // Redirect back to registered page
    header("Location: https://classdb.it.mtu.edu/~empinnoo/stu_registered.php");
}

?>