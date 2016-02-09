<?php
/**
 * Class TorScraper
 * 		PHP class for anonymously data mining websites
 *
 * @author Neil Q. Richins
 * @copyright GNU GENERAL PUBLIC LICENSE Version 3
 */
class TorScraper{

	// Password for Tor control port
	public $torpasswd=''; 			    // Unhashed Tor control passowrd
	public $torserver='127.0.0.1';		// IP for tor socks server  (Usually localhost)
	public $torsockport=9050; 			// port of Tor sock server
	public $torcontrolport=9051;		// port of Tor controller port (enable in /etc/tor/torrc)

	//Tag search start and end strings (Every thing between tags is returned as a scrape from website
	public $tagstart='<div>';
	public $tagend='</div>';
	//Maximim size of data after start tag to expect a valid end token
	public $taglimit=9999;

	// Type of browser to tell site we are using
	public $browser='Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';

	public $html;

	public	function newIp(){
		// Ask Tor to make us a new circuit with a new ip
		$fp = fsockopen($this->torserver,$this->torcontrolport, $errno, $errstr, 30);
		if ($fp) {
			fwrite($fp,"authenticate \"$this->torpasswd\"\n");
				$null=fread($fp, 128);
			fwrite($fp,"signal newnym\n");
				$null=fread($fp, 128);
			@fwrite($fp,"quit\n");
				$null=fread($fp, 128);
				sleep (.5);
			fclose($fp);
			sleep(2);
			return TRUE;
		}else{
			return FALSE;
		}

		}
	public function curl($site){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT,$this->browser);
		curl_setopt($curl, CURLOPT_URL, $site);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60); 
		curl_setopt($curl, CURLOPT_HTTPGET, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_PROXY, "$this->torserver:$this->torsockport");
		curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

		if (($this->tagStart="") || ($this->tagEnd="")){
			return curl_exec($curl);
		}else{
			return $this->parse(curl_exec($curl));
		}
	}

	function parse($html){
		$data=[];
		$end=0;
		while ($pos=strpos($html,$this->tagstart,$end)){
		
			$start=$pos+strlen($this->tagstart);
			$end=strpos($html,$this->tagend,$start);
			if ($start &&($end>$start) && ($end-$start<$this->taglimit)){
				$data[]=substr($html,$start,$end-$start)."\n";
			}
		}

		return $data;
	}
}
?>
