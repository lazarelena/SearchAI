<?php

namespace AppBundle;
use Symfony\Component\HttpFoundation\Response;

class GoogleBooksAPI
{	    
	public function requestAction($title, $author){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q='.$title.'+inauthor:'.$author.'&key=AIzaSyDbn5MQIDr-wZV-N6WiYogQ837EkOPLYIo');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$data = json_decode($response);
		return $data;
	}
}
