<?php
// src/AppBundle/Entity/Book.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BookRepository")
 * @ORM\Table(name="book")
 */
class Book
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
     * @ORM\Column(type="integer")
     */
    private $iban;
	
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;
	
	/**
     * @ORM\Column(type="string", length=100)
     */
    private $author;
	
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;
	
    /**
     * @ORM\Column(type="text")
     */
    private $description;
	
	public function getId(){
		return $this->id;
	}
	
	public function getTitle(){
		return $this->title;
	}
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getAuthor(){
		return $this->author;
	}
	public function setAuthor($author){
		$this->author = $author;
	}
	
	public function getPrice(){
		return $this->price;
	}
	public function setPrice($price){
		$this->price = $price;
	}
	
	public function getIban(){
		return $this->iban;
	}
	public function setIban($iban){
		$this->iban = $iban;
	}
	
	
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($description){
		$this->description = $description;
	}
	
}
