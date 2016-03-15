<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   require_once 'modules/hybridauth/functions.php';
   require_once 'modules/hybridauth/lib/hybridauth/Hybrid/Auth.php';
  // ini_set('display_errors', 1);
  // ini_set('error_reporting', E_ALL);   
 //  $pageController->pr($_POST);
 //  $pageController->pr($_GET);  
   
  // $pageController->pr($modHybridauth->config);
   
   $_GET['provider']= "Facebook";
   
   $modHybridauth->initfacebook();
   
   
	$user_data = NULL;
	try{
            $hybridauth = new Hybrid_Auth( $modHybridauth->config );
            $provider = @ trim( strip_tags( $_GET["provider"] ) );
            if( !  $hybridauth->isConnectedWith( $provider ) ){ 
                 header( "Location: login.php?error=Your are not connected to $provider or your session has expired" );
            }
            $adapter = $hybridauth->getAdapter( $provider );
            $user_data = $adapter->getUserProfile();
        }
	catch( Exception $e ){  
		switch( $e->getCode() ){ 
			case 0 : echo "Unspecified error."; break;
			case 1 : echo "Hybriauth configuration error."; break;
			case 2 : echo "Provider not properly configured."; break;
			case 3 : echo "Unknown or disabled provider."; break;
			case 4 : echo "Missing provider application credentials."; break;
			case 5 : echo "Authentication failed. " 
					  . "The user has canceled the authentication or the provider refused the connection."; 
			case 6 : echo "User profile request failed. Most likely the user is not connected "
					  . "to the provider and he should to authenticate again."; 
				   $adapter->logout(); 
				   break;
			case 7 : echo "User not connected to the provider."; 
				   $adapter->logout(); 
				   break;
		} 
		echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();
		echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";  
	}

require_once "projects/{$pageController->variables->project_name}/lib/members.php";  
   
//echo "user_data = $user_data->email";

//$user_data->email="ktosta@sdfsd.pl";
$modHybridauth->register(array('email'=>$user_data->email));
$modHybridauth->login(array('email'=>$user_data->email));

//header('location:/');

?>