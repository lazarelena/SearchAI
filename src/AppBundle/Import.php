<?php

namespace AppBundle;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\Book;
use AppBundle\GoodReadsAPI;
use AppBundle\GoogleBooksAPI;

class Import
{
	protected $goodreads;

    public function __construct(GoodReadsAPI $goodreads, GoogleBooksAPI $googlebooks)
    {
        $this->goodreads = $goodreads;
        $this->googlebooks = $googlebooks;
    }
	
    public function importFolder($path)
    {
		$books = array();		
		$finder = new Finder();
		if($path && $path != ""){
			$finder->files()->in($path);  //search through folder			
			
			//call GoogleBooksAPI
			$books = array();$books2 = array();
			$googleBooksAPI = $this->googlebooks;
			$goodReadsAPI = $this->goodreads;
			
			foreach ($finder as $file) {	
				$fileName = $this->regex($file);			
				array_push($books, $googleBooksAPI->search($fileName['title'], $fileName['author'])); 			
				array_push($books2, $goodReadsAPI->search($fileName['title'], $fileName['author'])); 				
			}	
			print_r($books);
		}		
    }
	
	public function saveAction()  //save to db
	{
		$book = new Book();
		$book->setTitle('Hallo');
		$book->setAuthor('J.K. Rowling');
		$book->setPrice(19.99);
		$book->setDescription('Ergonomic and stylish!');

		$em = $this->getDoctrine()->getManager();
		$em->persist($book);
		$em->flush();
		
		return new Response('Saved new book with id '.$book->getId());
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
