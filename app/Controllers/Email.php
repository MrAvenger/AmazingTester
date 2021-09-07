<?php namespace App\Controllers;

use App\Models\UserModel;

class Email extends BaseController
{
    public function send_verify($user){
        $message = "Здравствуйте, ".$user['last_name']." ".$user['first_name']." ".$user['middle_name'].". Пожалуйста, активируйте свой аккаунт ".anchor('activate/'.$user['email_verification_code'],'Активировать','');
        $email = \Config\Services::email();
        $email->setFrom('amazing.tester.service@gmail.com', 'AmazingTester');
        $email->setTo($user['email']);
        $email->setSubject('Активация аккаунта | AmazingTester');
        $email->setMessage($message);//your message here 
        $email->send();
        $email->printDebugger(['headers']);
    }

    public function send_reset($user){
        $message = "Здравствуйте, ".$user['last_name']." ".$user['first_name']." ".$user['middle_name'].". Для сброса пароля аккаунта, нажмите на ссылку: ".anchor('reset/'.$user['token'],'Сбросить пароль','');
        $email = \Config\Services::email();
        $email->setFrom('amazing.tester.service@gmail.com', 'AmazingTester');
        $email->setTo($user['email']);
        $email->setSubject('Восстановление пароля | AmazingTester');
        $email->setMessage($message);//your message here
        $email->send();
        $email->printDebugger(['headers']);
    }
}