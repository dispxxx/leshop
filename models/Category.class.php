<?php
class Category
{

	// Properties
	private $id;
	private $name;
	private $description;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Getters
	public function getId()
	{
		return $this -> id;
	}
	public function getName()
	{
		return $this -> name;
	}
	public function getDescription()
	{
		return $this -> description;
	}


	// Setters
	public function setId($id)
	{
		$this -> id = $id();
		return true;
	}
	public function setName($name)
	{
		if (strlen($name) > 1 && strlen($name) < 32)
		{
			$this -> name = $name();
			return true;
		}
		else
		{
			throw new Exception("Invalid name");

		}
	}
	public function setDescription($description)
		{
		if (strlen($description) > 1 && strlen($description) < 512)
		{
			$this  ->  description = $description;
			return true;
		}
		else
		{
			throw new Exception("Invalid description");
		}
	}
}
?>