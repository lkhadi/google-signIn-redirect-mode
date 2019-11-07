<?php
include 'config.php';
class auth{
	function __construct(){
		require_once 'vendor/autoload.php';
		$config = array(
			'client_id' => CLIENT_ID,
			'client_secret' => CLIENT_SECRET,
			'access_type' => 'offline'
		);
		$this->client = new Google_Client($config);
		// $this->client->setAuthConfigFile('vendor/client_secret.json');
		$this->client->setRedirectUri("http://localhost/verify_user.php");
		$this->client->setScopes(array(
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile"
		));
	}

	function login(){
		$auth_url = $this->client->createAuthUrl();
		header("Location: ".$auth_url);
	}

	function verification($code){
		$id_token = $this->client->authenticate($code);
		$payload = $this->client->verifyIdToken($id_token['id_token']);
		// $this->client->setAccessToken($id_token['access_token']);
		session_start();
		$_SESSION['refresh_token'] = $this->client->getRefreshToken();
		$_SESSION['access_token'] = $this->client->getAccessToken();
		if($payload){
			print_r($payload);
			
		}else{
			echo "login failed";
		}
	}

	function getRefreshToken(){
		return $_SESSION['refresh_token'];
	}

	function getNewAccess(){
		$this->client->setAccessToken($_SESSION['access_token']);
		if($this->client->isAccessTokenExpired()){
			return $this->client->refreshToken($_SESSION['refresh_token']);
		}else{
			return "Not yet";
		}
	}
}
?>