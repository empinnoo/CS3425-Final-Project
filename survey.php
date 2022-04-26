<?php
    session_start();
    require "db.php";
?>
<html>
    <body>
        <form method=post>
            <?php
                if (isset($_POST["todo"])) {
                    $currentUser = $_SESSION["username"];
                    $courseID = $_POST['courseID'];

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
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $q_id = $row['question_id'];
                        $q_text = $row['q_text'];
                        $q_type = $row['q_type'];
                        if (strcmp($q_type, 'Multiple Choice') == 0) {
                            createMultipleChoice($q_id, $q_text);
                        } else {
                            createEssay($q_id, $q_text);
                        }
                    }
                }

                /* Creates the multiple choice questions for the survey */
                function createMultipleChoice($q_id, $q_text) {
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
                        <input type="radio" value="<?php $choice ?>" name="<?php $q_id ?>"><?php $choice ?></input>
                        <?php
                    }
                }

                /* Creates the essay questions for the survey */
                function createEssay($q_id, $q_text) {
                    ?>
                    <p>Q<?php echo $q_id ?>: <?php echo $q_text ?></p>
                    <?php
                    ?>
                    <input type="text" name="<?php $q_id ?>">
                    <?php
                }
            ?>
            <button type="submit" name="submitSurvey">Submit</button>
        </form>
    </body>
</html>
