<?php

namespace AppBundle;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\Book;
use AppBundle\GoodReadsAPI;
use AppBundle\GoogleBooksAPI;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class Import
{
	protected $goodreads;
	protected $googleboks;
	protected $em;
	
    public function __construct(GoodReadsAPI $goodreads, GoogleBooksAPI $googlebooks, EntityManager $em)
    {
        $this->goodreads = $goodreads;
        $this->googlebooks = $googlebooks;
		$this->em = $em;
    }
	
    public function importFolder($path)
    {
		$finder = new Finder();
		if($path && $path != ""){
			$finder->files()->in($path);  //search through folder
			
			foreach ($finder as $file) {	
				$fileName = $this->regex($file);
				$this->save($fileName['title'],$fileName['author'],0,0,'');							
			}
		}
		$this->updateInfoGoogleBooksAPI();		
    }
	public function updateInfoGoogleBooksAPI()
	{
		$books = $this->em->getRepository('AppBundle:Book')->findAll();
		$parsedBooks = $this->googlebooks->parseData($books);
		foreach($parsedBooks as $book)
			$this->save($book[0], $book[1],0,$book[2],$book[3]);
	}
	
	public function save($title, $author, $price, $iban, $description)  //save to db
	{
		$book = $this->em->getRepository('AppBundle:Book')->findOneBy([
			'title' => $title, 
			'author' => $author
		]);

		if ($book == null){ //no brand found. So, persist the new one:		
			$book = new Book();
			$book->setTitle($title);
			$book->setAuthor($author);
			$book->setPrice($price);
			$book->setIban($iban);
			$book->setDescription($description);
			
			print_r('New book:'.$title);
			
		
		} else {
			$book->getPrice() == 0 || $book->getPrice() > $price  ? $book->setPrice($price) :'';
			$book->getIban() == 0 ? $book->setIban($iban)  :'';
			$book->getDescription() == '' ? $book->setDescription($description) :'';
			print_r('Update book:'.$title);
		}
		$this->em->persist($book);
		$this->em->flush();
		
		return true;
	}
	
	public function regex($file){
		if($file){
			$fileName = array('title' => '', 'author'=> '');
			$temp = explode(" - ", $file->getRelativePathname());  //get relative path  Author - Title.extension
			$temp[1] = explode(".", $temp[1]);				       //remove file extension
			
			
			$fileName['title'] = $temp[1][0];
			$fileName['author'] = $temp[0];

			return $fileName;			
		}
	}
}
