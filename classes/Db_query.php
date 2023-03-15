<?php
    require_once __DIR__.'/Db.php';
    
    class Db_query extends Db
    {
        public function authorization()
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/session.php';            
            
            if((isset($_POST['login']) && isset($_POST['password'])) || $_SESSION['logged'] == 1)
            {
                $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING); //bez pieczne filtrowanie loginu
                
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING); //bezpieczne filtrowanie hasła
                
                if((!empty($login) && !empty($password))) //gdy coś jest wpisane lub gdy sesja jest aktywna
                { 
                    $result = mysqli_query($this->connectDb(), "SELECT login,firstname,lastname,email,password,rights FROM users WHERE login='$login'");
             
                    while($row = mysqli_fetch_assoc($result))
                    {
                        if(($login === $row['login'] && password_verify($password, $row['password'])) || $_SESSION['logged'] == 1)
                        {
                            start_session();
                            //to co dzieje się po zalogowaniu
                            $_SESSION['logged'] = 1;
                            
                            $_SESSION['login'] = $login;
                            
                            $_SESSION['firstname'] = $row['firstname']." ";
                            
                            $_SESSION['lastname'] = $row['lastname']." ";
                            
                            $_SESSION['email'] = $row['email'];
                            
                            $_SESSION['time'] = time();
  
                            if($row['rights'] == 1)
                            {
                                $query = mysqli_query($this->connectDB(), "SELECT path FROM addresses WHERE id=1");

                                $row = mysqli_fetch_assoc($query);

                                header($row['path']);
                            }
                            else
                            {
                                $query = mysqli_query($this->connectDB(), "SELECT path FROM addresses WHERE id=2");

                                $row = mysqli_fetch_assoc($query);

                                header($row['path']);
                            }      
                        }
                    } 
                } 
                if(empty($login) && empty($password) && $_SESSION['logged'] == 0) echo error("Wprowadź login i hasło"); //wyświetla błąd gdy nic nie jest wpisane
                
                if((!empty($login) && !empty($password)) && $_SESSION['logged'] == 0) echo error("Złe dane logowania"); // wyświetla błąd gdy są wpisane błędne dane logoweania
            }
        }
        
        public function checkUserExist()
        {
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/session.php';
            require_once $_SERVER['DOCUMENT_ROOT'].'/functions/success.php';
            
            if(isset($_POST['newlogin']) && isset($_POST['newpassword']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['captcha']))
            {
                $login = filter_var($_POST['newlogin'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['newpassword'], FILTER_SANITIZE_STRING);
                $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
                $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $captcha = filter_var($_POST['captcha'], FILTER_SANITIZE_STRING);
                
                if(isset($_POST['save-user']))
                {
                    if(!empty($login) && !empty($password) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($captcha))
                    {
                        $query = mysqli_query($this->connectDb(), "SELECT login FROM users where login='$login'");

                        $row = mysqli_fetch_assoc($query);

                        if($login == $row['login'])
                        {
                            error ("Taki login juz istnieje");
                        }
                        else
                        {
                            session_start();
                            if($captcha == $_SESSION['captcha_text'])
                            {
                                mysqli_query($this->connectDb(), "INSERT INTO users(login,password,firstname,lastname,email,rights) VALUES('$login','".password_hash($password, PASSWORD_ARGON2I)."','$firstname','$lastname', '$email',0)");
                                success("Konto zostało utworzone");
                                $url = "index.php";
                                if (!headers_sent())
                                {
                                    header('Refresh: 2, url='.$url);
                                    exit;
                                }
                                else
                                {
                                    echo '<script type="text/javascript">';
                                    echo 'setTimeout(function(){window.location.href="'.$url.'";},2000)';
                                    echo '</script>';
                                    exit;
                                }
                            }
                            else
                                error ("Niepoprawny kod");
                        }     
                    }
                    else
                        error ("Wprowadź wszystkie dane");
                }
            }
            if(isset($_POST['cancel-user'])) 
            {
                $url = "index.php";
                if (!headers_sent()) {
                    header('Location: '.$url);
                    exit;
                } else {
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="'.$url.'";';
                        echo '</script>';
                        exit;
                }
            }
        }
        
        public function getworkout($actions=false)
        {            
            setcookie("id", $_GET['id']);
            
            $result = mysqli_query($this->connectDB(),"SELECT workoutname FROM ".$this->get_day()." "
                                                                . "WHERE user_id=(SELECT id FROM users WHERE login='".$_SESSION['login']."')");
            
            $row = mysqli_fetch_assoc($result);
 
            if($actions == true)
            {
                if($row['workoutname'] != "")
                {
                    echo
                        "<div class='col-md-9 mb-5 mt-5' id='scrollTable'><table class='table'>
                         <thead>
                         <tr>
                             <th>Lp.</th>
                             <th>Ćwiczenie</th>
                             <th>Ilość serii</th>
                             <th>Ilość powt.</th>
                             <th class='action'>Akcja</th>
                         </tr>
                         </thead>";
                }
                else error ("Nic tu jeszcze nie ma");
            }

            if($actions == false)
            {
                if($row['workoutname'] != "")
                {
                    echo
                        "<div class='col-md-7 mb-5 mt-5' id='scrollTableWithoutActions'><table class='table'>
                         <tr>
                             <th>Lp.</th>
                             <th>Ćwiczenie</th>
                             <th>Ilość serii</th>
                             <th>Ilość powt.</th>
                         </tr>";
                }
                else error ("Aby zacząć musisz dodać ćwiczenie");
            }

            $result = mysqli_query($this->connectDB(),"SELECT id,workoutname,series,repetitions FROM ".$this->get_day()." "
                                                                . "WHERE user_id=(SELECT id FROM users WHERE login='".$_SESSION['login']."')");
        
            while($row = mysqli_fetch_assoc($result))
            {
                if($actions == true)
                {
                    $tbody = "<tr>"
                        . "<td>".++$counter."</td>"
                        . "<td>".$row['workoutname']."</td>"
                        . "<td>".$row['series']."</td>"
                        . "<td>".$row['repetitions']."</td>"
                        . "<td>"
                            . "<form action='index.php' method='get'>"
                            . "<div class='changes'><a href='?page=updateWorkout&id=".$row['id']."'><input class='update btn ml-2 mb-2 mb-md-0' type='button' value='Zmień'></a>"
                            . "<a href='?page=deleteWorkout&id=".$row['id']."'><input class='delete btn ml-2' type='button' value='Usuń'></a></div>"
                            . "</form>"
                        . "</td>"
                  . "</tr>";
                }
                else
                {
                    
                    $tbody = "<tr>"
                        . "<td>".++$counter."</td>"    
                        . "<td>".$row['workoutname']."</td>"
                        . "<td>".$row['series']."</td>"
                        . "<td>".$row['repetitions']."</td>"
                  . "</tr>";
                }
            
                echo $tbody;
            } 
            echo "</table></div>";
        }
        
        public function addworkout($workout="",$series="",$repetitions="", $day="")
        {            
            if($workout != "" && $series != "" && $repetitions != "" && $day != "")
            {
            mysqli_query($this->connectDB(), "INSERT INTO $day (user_id,workoutname,series,repetitions) "
                                                        . "VALUES ((SELECT id FROM users WHERE login='".$_SESSION['login']."')"
                                                        . ",'$workout','$series','$repetitions')");
            }
        }
        
        public function update_workout($workname, $series, $repetitions , $id)
        {                        
            if($workname != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET workoutname='$workname' WHERE id='$id'");
            }
            
            if($series != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET series='$series' WHERE id='$id'");
            }
            
            if($repetitions != "")
            {
                mysqli_query($this->connectDB(), "UPDATE ".$this->get_day()." SET repetitions='$repetitions' WHERE id='$id'");
            } 
        }
        
        public function delete_workout($id)
        {
            mysqli_query($this->connectDB(), "DELETE FROM ".$this->get_day()." WHERE id='$id'");
        }
        
        public function get_day($language = "en")
        {
            $day;
            if($language == "en")
            {
                if(Date("D") == "Mon") $day = "monday";
                if(Date("D") == "Tue") $day = "tuesday";
                if(Date("D") == "Wed") $day = "wednesday";
                if(Date("D") == "Thu") $day = "thursday";
                if(Date("D") == "Fri") $day = "friday";
                if(Date("D") == "Sat") $day = "saturday";
                if(Date("D") == "Sun") $day = "sunday";
            }
            if($language == "pl")
            {
                if(Date("D") == "Mon") $day = "Poniedziałek";
                if(Date("D") == "Tue") $day = "Wtorek";
                if(Date("D") == "Wed") $day = "Sroda";
                if(Date("D") == "Thu") $day = "Czwartek";
                if(Date("D") == "Fri") $day = "Piątek";
                if(Date("D") == "Sat") $day = "Sobota";
                if(Date("D") == "Sun") $day = "Niedziela";
            }
            
            return $day;
        }
        
        public function change_user_data($firstname="", $lastname="", $email="", $old_password="", $new_password="")
        {            
            if($firstname != "" && $lastname != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET firstname='$firstname' WHERE login='".$_SESSION['login']."'");
                mysqli_query($this->connectDb(), "UPDATE users SET lastname='$lastname' WHERE login='".$_SESSION['login']."'");
            }
                       
            if($email != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET email='$email' WHERE login='".$_SESSION['login']."'");
            }
                       
            if($old_password != "" && $new_password != "")
            {
                mysqli_query($this->connectDb(), "UPDATE users SET password='".password_hash($new_password, PASSWORD_ARGON2I)."' WHERE login='".$_SESSION['login']."'"); 
            }
        }
    }
?>
