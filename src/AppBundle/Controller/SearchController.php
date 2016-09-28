<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Import;
use AppBundle\GoogleBooksAPI;
use AppBundle\GoodReadsAPI;



class SearchController extends Controller
{
	
    /**
     * @Route("/search" )
     */
    public function searchAction()
    {
		//import files
		$import = new Import();
		$files = $import->importFolder("C:/xampp/htdocs/SearchAI/books");
		
		//call GoogleBooksAPI
		$books = array();$books2 = array();
		$googleBooksAPI = new GoogleBooksAPI();
		$goodReadsAPI = new GoodReadsAPI();
		
		foreach ($files as $file) {	
			$fileName = $this->regex($file);			
			array_push($books, $googleBooksAPI->requestAction($fileName['title'], $fileName['author'])); 			
			array_push($books2, $goodReadsAPI->requestAction($fileName['title'], $fileName['author'])); 
			
		}	
		print_r($books2);		
        return $this->render('search/search-results.html.twig', array(
            'books' => $books,
            'books2' => $books2
			
        ));
    }
	
	public function regex($file){
		if($file){
			$fileName = array('title' => '', 'author'=> '');
			$temp = explode(" - ", $file->getRelativePathname());  //get relative path  Author - Title.extension
			$temp[1] = explode(".", $temp[1]);				       //remove file extension
			
			$fileName['title'] = str_replace(" ","+",$temp[1][0]);
			$fileName['author'] = str_replace(" ","+",$temp[0]);

			return $fileName;			
		}
	}
	
	
}
