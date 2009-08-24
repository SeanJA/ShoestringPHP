<?php
class Url extends sModel {
	function tinyFromUrl($url){
		$q = new sQuery();
		$q->from('urls');
		$q->addWhere('url', $url, '=');
		$q->setLimit(1);
		$result = $q->selectRow();
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
		$q->addField('tiny_url', $tinyUrl);
		$q->addField('url', $url);
		return $q->insert();
		//that was equivalent to:
		//INSERT INTO `urls` (tiny_url, url) VALUES ('$tinyUrl', '$url');
		//get last insert id
	}
	function urlFromTiny($tinyUrl){
		$q = new sQuery();
		$q->from('urls');
		$q->addWhere('tiny_url', $tinyUrl);
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
