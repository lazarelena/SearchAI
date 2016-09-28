<?php

namespace AppBundle;
use Symfony\Component\HttpFoundation\Response;

class GoodReadsAPI
{	    
	public function requestAction($title, $author){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.goodreads.com/search.xml?key=c5V2su1u0BPZmbgl5002A&q='.$title);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);		
		$data = simplexml_load_string($response);
		//print_r($data->search->results->work);
		return $data->search->results;
	}
}
