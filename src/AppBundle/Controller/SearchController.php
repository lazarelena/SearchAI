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
		$goodreads = $this->get('app.goodreads');
		$googlebooks = $this->get('app.googlebooks');
		$import = new Import($goodreads, $googlebooks);
		$import->importFolder("C:/xampp/htdocs/SearchAI/books");
				
        return new Response();
    }
	
	
	
	
}
