<?php

namespace AppBundle;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\Book;

class Import
{	
    public function importFolder($path)
    {
		$books = array();		
		$finder = new Finder();
		if($path && $path != ""){
			$finder->files()->in($path);  //search through folder
			return $finder;
		}else throw new Exception("No path given.");
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
}
