<?php
    /* Creates connection to the database */
    function connectDB() {
        $config = parse_ini_file("db.ini");
        $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    /* Check if it's the user's first login by checking the database */
    function isFirstLogin($username) {
        $stu_first_login = "select first_login from student where stu_name = :userVal";
        $inst_first_login = "select first_login from instructoe where inst_name = :userVal";
        $isFirstLogin = True;

        try {
            $dbh = connectDB();
            $statement = $dbh->prepare("select first_login from :tableVal where stu_name = :userVal");
            $statement->bindParam(":userVal", $username);
            $statement->execute();
            $dbh = null;
        } catch(PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }

    /* Connect to database to find login information */
    function authenticate($username, $password, $loginQuery) {
        $password = sha1($_POST['testPassword']); // hashes using sha1 algorithm
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare($loginQuery);
            $statement->bindParam(":userVal", $username);
            $statement->bindParam(":passVal", $password);
            $statement->execute();
            $dbh = null;
        } catch(PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
        
    }
?>