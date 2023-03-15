<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/success.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/PHPMailer/src/PHPMailer.php';
?>
<main class="container-fluid py-5 mt-sm-1">    
    <form action="index.php?page=resetPassword" method="post">
        <div class="row">
        <h3 class="text-center col-12">Resetowanie hasła</h3>
        </div>
        <div class="row mt-3">
            <p class="text-center col-12 text-justify">Podaj adres e-email, który został powiązany z kontem.<br>Zostanie na niego wysłane nowe hasło</p>
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-2 mt-1" for="email">Email</label>
            <input type="email" class="form-control col-sm-8 col-md-8" id="email" name="email-to-send">
        </div>
        <div class="text-center mt-3 mt-sm-3">
            <input type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1" name="send-email" value="Wyślij">
            <input type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1" name="cancel-email" value="Anuluj">
        </div>
    </form>
    <?php
    
        if(isset($_POST['cancel-email'])) header ("Location: index.php");
        if(isset($_POST['email-to-send']))
        {
            $email = filter_var($_POST['email-to-send'], FILTER_SANITIZE_STRING);
            
            if(!empty($email))
            {
                $check_email = new Db();
                $result = mysqli_query($check_email->connectDb(), "SELECT email FROM users WHERE login=(SELECT login FROM users WHERE email='".$email."')"); //tutaj poprawic na select login from users where email
                $row = mysqli_fetch_assoc($result);
                
                if($email == $row['email'])
                {
                    $tmp_pass = rand();
                    
                    if($_POST['send-email'])
                    {
                        $mail = new PHPMailer\PHPMailer\PHPMailer();
                        
                        $mail->PluginDir = $_SERVER['DOCUMENT_ROOT']."/classes/PHPMailer/src/";
                        $mail->Host = "";
                        $mail->Port = 465;	

                        $mail->SMTPKeepAlive = true;  					
                        $mail->SMTPAuth = true;
                        $mail->Username = "";
                        $mail->Password = "";	

                        $mail->SetLanguage("pl", $_SERVER['DOCUMENT_ROOT']."/classes/PHPMailer/language/");				
                        $mail->CharSet = "UTF-8";	
                        $mail->ContentType = "text/html";					

                        $mail->From = "l";	
                        $mail->FromName = "Trening";
                        $mail->Subject = "Nowe hasło";
                        $mail->Body = '<h3>Poniżej znajduje się Twoje nowe hasło. Po zalogowaniu zmień je natychmiast!</h3>'
                                      . '<p>Hasło: '.$tmp_pass.'</p>';

                        $mail->AddAddress($email);

                        if($mail->Send())
                        {
                            mysqli_query($check_email->connectDb(), "UPDATE users as u,(SELECT login from users WHERE email='".$email."') as e SET u.password='".password_hash($tmp_pass, PASSWORD_ARGON2I)."' WHERE u.login=e.login");
                        
                            success("Email został wysłany");
                            
                            header("Refresh: 2, url=index.php");
                        }
                        $mail->SmtpClose();  
                    }
                }
                else error ("Podany email nie istnieje w naszej bazie");
            }
            else error ("Wprowaź email");
        }
    ?>
</main>
