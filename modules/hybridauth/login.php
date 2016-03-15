<? require_once $_SERVER['DOCUMENT_ROOT'].'/engine/core/pageController.php';

 require_once 'modules/hybridauth/functions.php';
 $modHybridauth->initfacebook();  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="public/css.css" type="text/css">
</head>
<body>
<center>
<br />
<h1>Hybridauth Tiny Social Hub</h1> 
<?php
	// if we got an error then we display it here
	if( $error ){
		echo '<p><h3 style="color:red">Error!</h3>' . $error . '</p>';
		echo "<pre>Session:<br />" . print_r( $_SESSION, true ) . "</pre><hr />";
	}
?>
<br />
<table width="500" border="0" cellpadding="2" cellspacing="2">
  <tr> 
    <td align="left" valign="top"> 
		<fieldset>
        <legend>Sign-in with one of these providers</legend>
			&nbsp;&nbsp;<a href="?provider=Google">Sign-in with Google</a><br /> 
			&nbsp;&nbsp;<a href="?provider=Yahoo">Sign-in with Yahoo</a><br /> 
			&nbsp;&nbsp;<a href="?provider=Facebook">Sign-in with Facebook</a><br />
			&nbsp;&nbsp;<a href="?provider=Twitter">Sign-in with Twitter</a><br />
			&nbsp;&nbsp;<a href="?provider=MySpace">Sign-in with MySpace</a><br />  
			&nbsp;&nbsp;<a href="?provider=Live">Sign-in with Windows Live</a><br />  
			&nbsp;&nbsp;<a href="?provider=LinkedIn">Sign-in with LinkedIn</a><br /> 
			&nbsp;&nbsp;<a href="?provider=Foursquare">Sign-in with Foursquare</a><br /> 
			&nbsp;&nbsp;<a href="?provider=AOL">Sign-in with AOL</a><br />  
      </fieldset> 
	</td> 
<?php 
	// try to get already authenticated provider list
	try{
		$hybridauth = new Hybrid_Auth( $modHybridauth->config );

		$connected_adapters_list = $hybridauth->getConnectedProviders(); 

		if( count( $connected_adapters_list ) ){
?> 
    <td align="left" valign="top">  
		<fieldset>
			<legend>Providers you are logged with</legend>
			<?php
				foreach( $connected_adapters_list as $adapter_id ){
					echo '&nbsp;&nbsp;<a href="profile.php?provider=' . $adapter_id . '">Switch to <b>' . $adapter_id . '</b>  account</a><br />'; 
				}
			?> 
		</fieldset> 
	</td>		
<?php
		}
	}
	catch( Exception $e ){
		echo "Ooophs, we got an error: " . $e->getMessage();

		echo " Error code: " . $e->getCode();

		echo "<br /><br />Please try again.";

		echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>"; 
	}
?> 
  </tr> 
</table>

	<br />
	<br />
	
<table width="60%" border="0" cellspacing="10">
	<tr>  
	<td>
	<hr /> 
	This example show how users can login with providers using <b>HybridAuth</b>. It also show how to grab their profile, update their status or to grab their freinds list from services like facebook, twitter, myspace.
	<br />
	<br />
	If you want even more providers please goto to HybridAuth web site and download the <a href="http://hybridauth.sourceforge.net/download.html">Additional Providers Package</a>.
	</td>
	</tr>
</table>
</html>
