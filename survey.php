<?php
    session_start();
    require "db.php";
?>
<html>
    <body>
        <form method=post>
            <?php
                    $currentUser = $_SESSION["username"];

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

                    $count = 0;
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $count++;
                        $choice = $row['choice'];
                        ?>
                        <input type="radio" value="<?php echo $choice ?>" name="<?php echo $q_id ?>"><?php echo $choice ?></input><br>
                        <?php
                    }
                }

                /* Creates the essay questions for the survey */
                function createEssay($q_id, $q_text) {
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

if(isset($_POST['submitSurvey'])){
    echo 'Your answers are:<br>';
    echo "1:". $_POST["1"];
    echo '<br>';
    echo "2:". $_POST["2"];
    echo '<br>';
}

?>