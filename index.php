<?php

if( ! isset($_GET['s']) ) {

	$sites = array();

	$sites[] = 'http://softag.pt';
	$sites[] = 'http://dev.undandy.com';
	$sites[] = 'http://pedrabase.pt';
	$sites[] = 'http://conpro.pt';
	$sites[] = 'http://etraining.conpro.pt';
	$sites[] = 'http://winewithspirit.net';
	$sites[] = 'http://store.winewithspirit.net';
	$sites[] = 'http://scriptorium.pt';
	$sites[] = 'http://cefosap.com';
	$sites[] = 'http://dorigemlusa.pt';
	$sites[] = 'http://aequalitate.apee.pt';
	$sites[] = 'http://sexto-sentido.apee.pt';
	$sites[] = 'http://apee.pt';
	$sites[] = 'http://www.incp.pt';
	$sites[] = 'http://globalcompact.pt';
	$sites[] = 'http://gltp.pt';
	$sites[] = 'http://srs.apee.pt';
	$sites[] = 'http://capitolio-ongd.org';
	$sites[] = 'http://ire.pt';
	$sites[] = 'http://cvdigital.stepup.pt';
	$sites[] = 'http://globalcompact.pt/eers2013/';
	$sites[] = 'http://www.fabriprint.pt';
#	$sites[] = 'http://dev.ellajoias.com';
	$sites[] = 'http://hclub.pt';
	$sites[] = 'http://artistaparaevento.com.br';


	// LOAD THE PAGE
	sort($sites);
	include('html.php');
	
} else {

	function checkURL($url) {
		$return = array();
		
		$curl = curl_init(); // Initialize libcurl
		curl_setopt($curl, CURLOPT_URL, $url ); // URL to visit
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); // returns a string instead of echoing to screen
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); // follows redirects (recursive)
		curl_setopt($curl, CURLOPT_NOBODY, TRUE); // Only get headers, not content (saves on time)
		$result = curl_exec($curl);
		$errno = curl_errno($curl);
		
		$return['time'] = curl_getinfo($curl, CURLINFO_TOTAL_TIME);
		$return['time'] = number_format($return['time'], 3).'s';
	
		if ( $errno != 0 ) { // curl_errno returns 0 if no error, otherwise returns the error code
			$return['msg'] = "CURL error: ".curl_error($curl); // If there was an error, return the error message
			$return['result'] = false;
		} else {
			$http = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get the HTTP return code
			$return['code'] = $http;
			if ( $http >= 200 && $http < 300 ) { // An HTTP code greater than 200 and less than 300 means a successful load
				$return['msg'] = "Site is up!";
				$return['result'] = true;
			} else {
				$return['msg'] = "Site is down!";
				$return['result'] = false;
			}
		}
		curl_close($curl);
		return (object) $return;
	}

	// CHECK THE SITE
	$site = $_GET['s'];
	$check = checkURL($site);
	$check->url = $site;
	$check->el = $_GET['el'];
	
	header('Content-Type: application/json');
	echo json_encode($check);

}