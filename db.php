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

    // Returns the number of rows that match the given username and password. (authenticates the student)
    function authenticateStu($user, $passwd) {
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare("SELECT count(*) FROM student ".   
                                    "where stu_name = :username and stu_password = sha2(:passwd,256) ");
            $statement->bindParam(":username", $user);
            $statement->bindParam(":passwd", $passwd);
            $result = $statement->execute();
            $row = $statement->fetch();
            $dbh = null;

            return $row[0];
        }catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Returns the number of rows that match the given username and password. (authenticates the instructor)
    function authenticateInst($user, $passwd) {
        try {
            $dbh = connectDB();
            $statement = $dbh->prepare("SELECT count(*) FROM instructor ".   
                                        "where inst_name = :username and inst_password = sha2(:passwd,256) ");
            $statement->bindParam(":username", $user);
            $statement->bindParam(":passwd", $passwd);
            $result = $statement->execute();
            $row = $statement->fetch();
            $dbh = null;
        
            return $row[0];
        }catch (PDOException $e) {
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }
?>
