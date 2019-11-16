<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();


        $email = $_SESSION['mail'];
      $url = 'http://pec.paavai.edu.in/techfinix19/regis/download.php?id='.$_SESSION['id'];
        $subject = "You have successfully registered for Techfinix'19";
        $message = "
                    Dear ".$_SESSION["name"].",<br>
                          <p>You have been successfully registered for Techfinix'19.We are looking forward for you. For any queries contact us at \"techfinix19@paavai.edu.in\".  </p><br><br>
                   <br>
           
                   <br>
                  <br>
                  With regards,<br>
                  TECHFINIX'19 TEAM ,<br>
                  Paavai Engineering College,<br>
                  Namakkal -637018.<br>";

        $filename = $_FILES['attachment']['name'];
        $location = 'attachment/' . $filename;
        move_uploaded_file($_FILES['attachment']['tmp_name'], $location);

        //Load composer's autoloader
        require 'vendor/autoload.php';

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'techfinix19@paavai.edu.in';     // Your Email/ Server Email
            $mail->Password = 'Convenor@123$';                     // Your Password
            $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );
            $mail->SMTPSecure = 'TLS';
            $mail->Port = 587;

            //Send Email
            $mail->setFrom('techfinix19@paavai.edu.in');

            //Recipients
            $mail->addAddress($email);
            $mail->addReplyTo('techfinix19@paavai.edu.in');

            //Attachment
            if(!empty($filename)){
                $mail->addAttachment($location, $filename);
            }

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $_SESSION['message'] = 'Message has been sent';
        } catch (Exception $e) {
            $_SESSION['message'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        }

        header('location:pass.php');
