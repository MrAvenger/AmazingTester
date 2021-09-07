<?php
		require_once APPPATH.'libraries/GoogleApi/vendor/autoload.php';
		$google_client=new \Google_Client();
		$google_client->setClientId('450338540051-07h0036mi5htlgb6c83me28n7jrgbu9u.apps.googleusercontent.com'); //Идентификатор клиента
		$google_client->setClientSecret('QEuv92X7lKvGB6rwdeFJ1wAz'); //Секретный код
		$google_client->setRedirectUri('http://localhost/Codeigniter4/login'); //Ссылка перенаправления после авторизации
		$google_client->addScope('email');
		$google_client->addScope('profile');
?>