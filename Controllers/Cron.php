<?php

/**
 * Created by PhpStorm.
 * User: Replace
 * Date: 15.11.2016 г.
 * Time: 12:45 ч.
 */
class Cron
{
    public function toro()
    {

        require_once "Classes/PHPMailer/PHPMailerAutoload.php";
        $birthdays = "";
        $query = "SELECT * FROM users";

        $stmt = Connection::$connection->prepare($query);
        $stmt->execute();
        $usersData = $stmt->fetchAll();


        foreach ($usersData as $user) {
            $dateArr = explode('-', $user['birthday']);
            $dateMonth = $dateArr[1];
            $dateDay = $dateArr[2];


            $user_birtday_previous_year = new DateTime(date("Y", strtotime("-1 year")) . "-" . $dateMonth . "-" . $dateDay);
            $user_birtday_this_year = new DateTime(date("Y") . "-" . $dateMonth . "-" . $dateDay);
            $user_birtday_next_year = new DateTime(date("Y", strtotime("+1 year")) . "-" . $dateMonth . "-" . $dateDay);
            $now = new DateTime(date("Y-m-d"));

            if ($user['is_delete'] == null) {
                $diff_p_y = $now->diff($user_birtday_previous_year)->format("%r%a");
                $diff_t_y = $now->diff($user_birtday_this_year)->format("%r%a");
                $diff_n_y = $now->diff($user_birtday_next_year)->format("%r%a");
                if ($diff_p_y == 14 || $diff_p_y == 7 || $diff_t_y == 14 || $diff_t_y == 7 || $diff_n_y == 14 || $diff_n_y == 7) {
                    $birthdays .= "Предстоящ рожден ден на " . $user['first_name'] . " " . $user['middle_name'] . " " . $user['surname'] . " дата : " . $user['birthday'] . ".<br/>";
                }

            } else {
                continue;
            }
        }
        //var_dump($futureBirthdays);

        if ($birthdays == "") {

            die();
        }

        $mail = new PHPMailer();

        $mail->SMTPDebug = 0;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'valeri@mediabasket.eu';                 // SMTP username
        $mail->Password = 'valeri93';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->CharSet = 'UTF-8';


        $mail->setFrom('valeri@mediabasket.eu', 'Панел за рожденни дни');
        $mail->addAddress(CRON_EMAIL, 'Valeri Penev');     // Add a recipient


        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Предстоящи рождени дни';
        $mail->Body = $birthdays;

        $mail->send();
        /*if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }*/

        die();
    }
}