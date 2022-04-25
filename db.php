<?php
    /* Creates connection to the database */
    function connectDB() {
        $config = parse_ini_file("db.ini");
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    /* Check if it's the user's first login by checking the database */
    function isFirstLogin($username, $firstLoginQuery) {
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare($firstLoginQuery);
            $statement->bindParam(":userVal", $username);
            $statement->execute();
            $row = $statement->fetch();
            return $row[0];
            $dbh = null;
        } catch(PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }

    /* Connect to database to find login information */
    function authenticate($username, $password, $loginQuery) {
        $hashedPassword = sha1($password); // hashes using sha1 algorithm
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare($loginQuery);
            $statement->bindParam(":userVal", $username);
            $statement->bindParam(":passVal", $hashedPassword);
            $statement->execute();
            $row = $statement->fetch();
            return $row[0];
            $dbh = null;
        } catch(PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
        
    }

    /* Connect to database to change login information */
    function editAccount($username, $oldPassword, $newPassword, $editQuery) {
        $oldHashedPassword = sha1($oldPassword);
        $newHashedPassword = sha1($newPassword);
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare($editQuery);
            $statement->bindParam(":userVal", $username);
            $statement->bindParam(":oldPassVal", $oldHashedPassword);
            $statement->bindParam(":newPassVal", $newHashedPassword);
            $statement->execute();
            $row = $statement->fetch();
            return $row[0];
            $dbh = null;
        } catch(PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }

    /* Creates the multiple choice questions for the survey */
    function createMultipleChoice() {

    }

    /* Creates the essay questions for the survey */
    function createEssay() {
        
    }

    /* Fetch the current user's course */
    $dbh = connectDB();
    $statement = $dbh->query("select title from course where stu_name = "); //select user's information
    $statement->bindParam(":userVal", $username);
    $statement->execute();
    $COURSES = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $Courses[] = array('tagName' => $row['tag_name']);
    }
?>