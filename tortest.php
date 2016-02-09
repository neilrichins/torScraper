<?php
include_once "torScraper.php";

#########
##Example
#########
//Settings for your Tor Server
$example=new TorScraper();  		// Create a new instance
$example->torpasswd='YOURPASSWORD'; // Password you created for  /etc/tor/torrc  with $ tor --hash-password YOURPASSWORD
//$example->torserver='127.0.0.1';	// IP for tor socks server  Defaults to localhost
//$example->torsockport=9050;		//port of Tor sock server  Defaults to 9050
//$example->torcontrolport=9051;	//port of Tor controller port Defaults to ( Be sure to enable in /etc/tor/torrc )


//Tags to search for on page (Every thing between tags is returned as a scrape from website)
$example->tagstart='<a href="/ip/';	// Where in html to start looking for something useful to scrape
$example->tagend='"';				// Where in html to stop looking for useful data to scrape
//$example->taglimit=9999;  		// Optional maximim size of data after start tag to expect a valid end token


print_r( array_unique($example->curl('http://whatismyipaddress.com/')));  	// Scrape the site for our IP and display unique results
$example->newIp();															// Force Tor to get us a new IP
print_r( array_unique($example->curl('http://whatismyipaddress.com/')));  	// Scrape the site for our IP and display unique results


?>
