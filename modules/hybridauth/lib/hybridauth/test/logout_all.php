<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';
   $config = dirname(__FILE__) . '/../config.php';
   require_once( "modules/hybridauth/lib/hybridauth/Hybrid/Auth.php" );

	try{
		$hybridauth = new Hybrid_Auth( $config );

		// logout the user from $provider
		$hybridauth->logoutAllProviders(); 

		// return to login page
		$hybridauth->redirect( "login.php" );
    }
	catch( Exception $e ){
		echo "<br /><br /><b>Oh well, we got an error :</b> " . $e->getMessage();

		echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 
	}
