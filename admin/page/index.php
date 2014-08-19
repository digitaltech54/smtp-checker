<?php

/**
 * Created by Konstantin Kolodnitsky
 * Date: 25.11.13
 * Time: 14:57
 */
class page_index extends Page {

    public $title='Dashboard';

    function initMainPage() {
        $this->add('View_Box')
            ->setHTML('Welcome to SMTP Checker Type in details of your SMTP server and we will send a test-mail');

        $f=$this->add('Form');

        $f->addField('line','server','SMTP server')
            ->setFieldHint('Separate multiple servers with ";"');
        $f->addField('line','port')->set('993');
        $f->addField('Checkbox','auth');

        $f->addField('line','username');
        $f->addField('line','password');

        $f->addField('dropdown','protocol')
            ->setValueList(['none','tls'=>'TLS','ssl'=>'SSL']);

        $f->addField('line','from_email');
        $f->addField('line','from_name');

        $f->addField('line','to_email');

        $f->addField('line','subject');
        $f->addField('text','body');

        $f->set($f->recall('options',[]));

        $f->addSubmit(['Send','icon'=>'mail']);


        $f->onSubmit([$this, 'sendMail']);


    }
    function sendMail($form){
        $form->memorize('options',$form->get());


        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $form['server'];  // Specify main and backup SMTP servers
        $mail->Port = $form['port'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = (boolean)$form['auth'];                               // Enable SMTP authentication
        $mail->Username = $form['username'];                 // SMTP username
        $mail->Password = $form['password'];                           // SMTP password
        $mail->SMTPSecure = $form['protocol'];                            // Enable encryption, 'ssl' also accepted

        $mail->From = $form['from_email'];
        $mail->FromName = $form['from_name'];
        $mail->addAddress($form['to_email'], $form['to_name']);     // Add a recipient

        $mail->Subject = $form['subject'];
        $mail->Body    = $form['body'];

        if(!$mail->send()) {
            return $form->error('server','Mailer Error: ' . $mail->ErrorInfo);
        } else {
            return 'Message has been sent';
        }
    }

    function page_test(){
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.exposuredigital.com';  // Specify main and backup SMTP servers
        $mail->Port = 993;
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'user@example.com';                 // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted

        $mail->From = 'from@example.com';
        $mail->FromName = 'Mailer';
        $mail->addAddress('me@nearly.guru', 'Joe User');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //$mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }


    }
}
