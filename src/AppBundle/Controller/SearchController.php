<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;



class SearchController extends Controller
{
	/*
	* request to google books using curl
	* @param title
	* @param author
	* returns response
	*/
	public function requestAction($title, $author){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/books/v1/volumes?q='.$title.'+inauthor:'.$author.'&key=AIzaSyDbn5MQIDr-wZV-N6WiYogQ837EkOPLYIo');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$data = json_decode($response);
		return $data;
	}
	
    /**
     * @Route("/search" )
     */
    public function searchAction()
    {
		$books = array();
		//declaring the Finder Component and selecting the files in folder books 
		$finder = new Finder();
		$finder->files()->in("C:/xampp/htdocs/SearchAI/books");
		
		foreach ($finder as $file) {			
			// Dump the relative path to the file
			$temp = explode(" - ", $file->getRelativePathname());
			$temp[1] = explode(".", $temp[1]);				    //remove file extension
			array_push($books, $this->requestAction(str_replace(" ","+",$temp[1][0]), str_replace(" ","+",$temp[0])));  //remove spaces, make request to google books and add to array
			unset($temp);
		}
		
        return $this->render('search/search-results.html.twig', array(
            'books' => $books
        ));
    }
	
	
}
