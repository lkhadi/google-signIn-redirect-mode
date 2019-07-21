<?php 
class auth{
	function __construct(){
		require_once 'vendor/autoload.php';
		$this->client = new Google_Client();
		$this->client->setAuthConfigFile('vendor/client_secret.json');
		$this->client->setRedirectUri("http://localhost/gsign_redirect/verify_user.php");
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
		if($payload){
			print_r($payload);
		}else{
			echo "login failed";
		}
	}
}
?>