<?php
    class Db
    {
        public function createBasicDatabase()
        {   
            require_once $_SERVER['DOCUMENT_ROOT'].'/config/settings.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
            
            $con = new mysqli($host, $dbuser, $dbpassword, null,$port);
            
            if ($con->connect_errno)
            {
                echo error("Connect failed");
                exit();
            }
            
            if (!$con->query("CREATE DATABASE IF NOT EXISTS $dbname;"))
            {
                echo error("Couldn't create database");
            }
            
            
            $con = new mysqli($host, $dbuser, $dbpassword, $dbname, $port);
            
            if ($con->connect_error)
            {
                die("Connection failed: " . $con->connect_error);
            }
            
            $usersTable = "CREATE TABLE IF NOT EXISTS users(id INT(6) AUTO_INCREMENT PRIMARY KEY,login VARCHAR(50) NOT NULL,firstname VARCHAR(100) NOT NULL,lastname VARCHAR(100) NOT NULL,email VARCHAR(200) NOT NULL,password VARCHAR(1000) NOT NULL,rights INT(6));";
            $addressesTables = "CREATE TABLE IF NOT EXISTS addresses(id INT(6) AUTO_INCREMENT PRIMARY KEY,path VARCHAR(200) NOT NULL);";
            $mondayTable = "CREATE TABLE IF NOT EXISTS monday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $tuesdayTable = "CREATE TABLE IF NOT EXISTS tuesday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $wednesdayTable = "CREATE TABLE IF NOT EXISTS wednesday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $thursdayTable = "CREATE TABLE IF NOT EXISTS thursday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $fridayTable = "CREATE TABLE IF NOT EXISTS friday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $saturdayTable = "CREATE TABLE IF NOT EXISTS saturday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $sundayTable = "CREATE TABLE IF NOT EXISTS sunday(id INT(6) AUTO_INCREMENT PRIMARY KEY,user_id INT(6),workoutname VARCHAR(200) NOT NULL,series INT(6) NOT NULL,repetitions INT(6) NOT NULL,INDEX(user_id),FOREIGN KEY(user_id) REFERENCES users(id));";
            $addressPath = "INSERT IGNORE INTO addresses(path) VALUES ('Location: /admin/');";
            $addressPath2 = "INSERT IGNORE INTO addresses(path) VALUES ('Location: /app/');";
            $addressPath3 = "INSERT IGNORE INTO addresses(path) VALUES (' ');";
            
            if (mysqli_select_db($con, $dbname))
            {
                $con->query($usersTable);
                $con->query($addressesTables);
                $con->query($mondayTable);
                $con->query($tuesdayTable);
                $con->query($wednesdayTable);
                $con->query($thursdayTable);
                $con->query($fridayTable);
                $con->query($saturdayTable);
                $con->query($sundayTable);
                $con->query($addressPath);
                $con->query($addressPath2);
                $con->query($addressPath3);
                
                echo error("Tables created successfully");
            }
            else
            {
                echo error("Nie utworznono tateli"), $con->error;
            }

            $con->close();
        }
        
        public function connectDb()
        {
            include $_SERVER['DOCUMENT_ROOT']."/config/settings.php";
            
            $con = new mysqli($host,$dbuser,$dbpassword,$dbname,$port);
            
            if ($con->connect_errno)
            {
                printf("Connect failed: %s\n", $con->connect_error);
                exit();
            }
            
            if ($conn->connect_error)
            {
                die("Connection failed: " . $con->connect_error);
                exit();
            }
            else return $con;
            
            mysqli_close($con);
        }
    }
?>

