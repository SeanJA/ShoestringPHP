<?php
class Url extends sModel {
	function tinyFromUrl($url){
		$q = new sQuery();
		$result = $q->from('urls');
		        ->where('url', $url, '=')
		        ->limit(1)
		        ->selectRow();
		//that was equivalent to:
		//SELECT `url` FROM `urls` WHERE `url` = '$url' LIMIT 1
		if($result){
			$result = $result['tiny_url'];
		}
		return $result;
	}
	function newTinyUrl($tinyUrl, $url){
		$q = new sQuery();
		$q->from('urls');
		$q->set('tiny_url', $tinyUrl);
		$q->set('url', $url);
		return $q->insert();
		//that was equivalent to:
		//INSERT INTO `urls` (tiny_url, url) VALUES ('$tinyUrl', '$url');
		//get last insert id
	}
	function urlFromTiny($tinyUrl){
		$q = new sQuery();
		$q->from('urls');
		$q->where('tiny_url', $tinyUrl);
		$result = $q->selectRow();
		//that was equivalent to:
		//SELECT tiny_url FROM urls WHERE tiny_url = 'tinyUrl' LIMIT 1;
		if($result){
			$result = $result['url'];
		}
		return $result;
	}
	function getAllUrls(){
		$q = new sQuery();
		$q->from('urls');
		$result = $q->selectAll();
		return $result;
	}
}
