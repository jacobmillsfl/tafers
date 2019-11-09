<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';
require_once 'DAL/User.php';
require_once 'DAL/File.php';
require_once 'DAL/Song.php';
require_once 'DAL/SongComment.php';
require_once 'DAL/Blog.php';
require_once 'DAL/BlogComment.php';


class Mailer
{
    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getMailSettings() { return "mail_localsettings.php"; }

    public static function sendRegistrationEmail($recipientEmail,$newusername) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($smtpUsername, 'TAFers');
            $mail->addAddress($recipientEmail);
            $mail->addReplyTo($smtpUsername, 'NoReply');

            //Content
            $body = '<p>Greetings! An account was recently created on <a href="https://tafers.net">tafers.net</a> using this email address. Your username is: <b>' . $newusername . '</b></p>';
            $body = $body . '<br/><p>If you believe you have received this message in error, please contact our <a href="mailto:opendevtools@gmail.com">Site Administrators</a>.</p>';

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'TAFers Registration Successful';
            $mail->Body    = $body;

            $altBody = strip_tags($body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();

            // Message sent
            // We may want to log emails in the database...
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public static function sendContactEmail($email_address,$email_subject,$email_body) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($email_address,"TAF User");
            $mail->addAddress($smtpUsername);   // This email is to ourselves
            $mail->addReplyTo($email_address,$email_address);

            //Content

            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body    = $email_body;

            $altBody = strip_tags($email_body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
            // Message sent
            // We may want to log emails in the database...
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public static function sendGenericEmail($email_address,$email_subject,$email_body) {
        include_once(self::getMailSettings());

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->isSMTP();                                // Set mailer to use SMTP
            $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                         // Enable SMTP authentication
            $mail->Username = $smtpUsername;                // SMTP username
            $mail->Password = $smtpPassword;                // SMTP password
            $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                              // TCP port to connect to

            //Recipients
            $mail->setFrom($smtpUsername,"TAF User");
            $mail->addAddress($email_address);
            $mail->addReplyTo($smtpUsername,"TAFers");

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_subject;
            $mail->Body    = $email_body;

            $altBody = strip_tags($email_body);
            $mail->AltBody = $altBody;

            // Set SMTP Options
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
            // Message sent
            // We may want to log emails in the database...
        } catch (Exception $e) {
            // Log error
            die('Mailer Error: ' . $mail->ErrorInfo);
        }
    }
    
    public static function sendFileUploadEmail($userId, $fileId) {
        $subject = "TAFers.NET File Upload";
        $body = "";
        
        $file = new File($fileId);
        $user = new User($userId);
        
        //Content
        $body .= '<p>A new file has been uploaded to TAFers.NET!</p><br>';
        $body .= '<ul>';
        $body .= '<li>Filename: ' . $file->getFileName() . '</li>';
        $body .= '<li>Username: ' . $user->getUsername() . '</li>';
        $body .= '<li>Date: ' . $file->getUploadDate() . '</li>';
        $body .= '</ul><br><br>';
        $body .= '<p>To view this change log in to <a href="https://www.tafers.net">tafers.net</a>';
        
        self::sendDistributedEmail($userId,$subject,$body);
    }
    
    public static function sendSongCreateEmail($userId, $songId) {
        $subject = "TAFers.NET Song Created";
        $body = "";
        
        $song = new Song($songId);
        $user = new User($userId);
        
        //Content
        $body .= '<p>A new song has been added to TAFers.NET!</p><br>';
        $body .= '<ul>';
        $body .= '<li>Songname: ' . $song->getName() . '</li>';
        $body .= '<li>Username: ' . $user->getUsername() . '</li>';
        $body .= '<li>Date: ' . $song->getCreateDate() . '</li>';
        $body .= '</ul><br><br>';
        $body .= '<p>To view this change log in to <a href="https://www.tafers.net">tafers.net</a>';
        
        
        self::sendDistributedEmail($userId,$subject,$body);
    }
    
    public static function sendSongCommentEmail($userId, $songCommentId) {
        $subject = "TAFers.NET Song Comment Created";
        $body = "";
        
        $songComment = new SongComment($songCommentId);
        $song = new Song($songComment->getSongId());
        $user = new User($userId);
        
        //Content
        $body .= '<p>A new song comment was added TAFers.NET!</p><br>';
        $body .= '<ul>';
        $body .= '<li>Songname: ' . $song->getName() . '</li>';
        $body .= '<li>Username: ' . $user->getUsername() . '</li>';
        $body .= '<li>Comment: ' . $songComment->getComment() . '</li>';
        $body .= '<li>Date: ' . $songComment->getCreateDate() . '</li>';
        $body .= '</ul><br><br>';
        $body .= '<p>To view this change log in to <a href="https://www.tafers.net">tafers.net</a>';
        
        self::sendDistributedEmail($userId,$subject,$body);
    }
    
    public static function sendBlogCreateEmail($userId, $blogId) {
        $subject = "TAFers.NET Band Log Created";
        $body = "";
        
        $blog = new Blog($blogId);
        $band = new Band($blog->getBandId());
        $user = new User($userId);
        
                //Content
        $body .= '<p>A Band Log has been added to TAFers.NET!</p><br>';
        $body .= '<ul>';
        $body .= '<li>Project: ' . $band->getName() . '</li>';
        $body .= '<li>Username: ' . $user->getUsername() . '</li>';
        $body .= '<li>Date: ' . $blog->getCreateDate() . '</li>';
        $body .= '</ul><br><br>';
        $body .= '<p>To view this change log in to <a href="https://www.tafers.net">tafers.net</a>';
        
        self::sendDistributedEmail($userId,$subject,$body);
    }
    
    public static function sendBlogCommentEmail($userId, $blogCommentId) {
        $subject = "TAFers.NET Band Log Comment";
        $body = "";
        
        $blogComment = new BlogComment($blogCommentId);
        $blog = new Blog($blogComment->getBlogId());
        $band = new Band($blog->getBandId());
        $user = new User($userId);
        
        //Content
        $body .= '<p>A Band Log has been added to TAFers.NET!</p><br>';
        $body .= '<ul>';
        $body .= '<li>Project: ' . $band->getName() . '</li>';
        $body .= '<li>Username: ' . $user->getUsername() . '</li>';
        $body .= '<li>Comment: ' . $blogComment->getMessage() . '</li>';
        $body .= '<li>Date: ' . $blog->getCreateDate() . '</li>';
        $body .= '</ul><br><br>';
        $body .= '<p>To view this change log in to <a href="https://www.tafers.net">tafers.net</a>';
        
        self::sendDistributedEmail($userId,$subject,$body);
    }
    
    private static function sendDistributedEmail($userId,$email_subject,$email_body) {
        
        include_once(self::getMailSettings());

        $recipients = User::loadall();
        foreach($recipients as $user)
        {
            if ($user->getId() != $userId)
                continue;
        
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->isSMTP();                                // Set mailer to use SMTP
                $mail->Host = $smtpHost;                        // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                         // Enable SMTP authentication
                $mail->Username = $smtpUsername;                // SMTP username
                $mail->Password = $smtpPassword;                // SMTP password
                $mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                              // TCP port to connect to

                //Recipients
                $mail->setFrom($smtpUsername,"TAFers.NET");
                $mail->addAddress($user->getEmail());
                $mail->addReplyTo($smtpUsername,"TAFers.NET");

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $email_subject;
                $mail->Body    = $email_body;

                $altBody = strip_tags($email_body);
                $mail->AltBody = $altBody;

                // Set SMTP Options
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->send();
                // Message sent
                // We may want to log emails in the database...
            } catch (Exception $e) {
                // Log error
                die('Mailer Error: ' . $mail->ErrorInfo);
            }
        
        }
    }

}
