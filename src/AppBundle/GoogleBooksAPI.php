<?php

namespace AppBundle;
use Symfony\Component\HttpFoundation\Response;

class GoogleBooksAPI
{	    
	public function search($title, $author){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/books/v1/volumes?q=".$title."+inauthor:".$author."&maxResults=1&key=AIzaSyDbn5MQIDr-wZV-N6WiYogQ837EkOPLYIo");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$data = json_decode($response);
		return $data;
	}
	public function parseData($books){
		$parsedBooks = array();
		foreach($books as $book){		
			$temp = $this->search(str_replace(" ","+",$book->getTitle()), str_replace(" ","+",$book->getAuthor()));
 			
			$title = $temp->items[0]->volumeInfo->title;									
			$author = $temp->items[0]->volumeInfo->authors[0];
			$description = $temp->items[0]->volumeInfo->description;
			if($temp->items[0]->volumeInfo->industryIdentifiers[0]->type == 'ISBN_10')
				$iban = $temp->items[0]->volumeInfo->industryIdentifiers[0]->identifier;
			else $iban = $temp->items[0]->volumeInfo->industryIdentifiers[1]->identifier;
			
			$book = array($title,$author,$iban,$description);
			array_push($parsedBooks, $book);
		}	
		return $parsedBooks;
	}
}
