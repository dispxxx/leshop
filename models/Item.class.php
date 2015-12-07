<?php 
class Item
{
	private $db;
	private $id;
	private $id_category;
	private $category;
	private $name;
	private $price;
	private $stock;
	private $image;
	private $description;

	public function __construct($db)
	{
		$this->db = $db;
	}
				/*GETER*/
	public function getId()
	{
		return $this->id;
	}
	public function getCategory()
	{
		return $this->category;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getPrice()
	{
		return $this->price;
	}
	public function getStock()
	{
		return $this->stock;
	}
	public function getImage()
	{
		return $this->image;
	}
	public function getDescription()
	{
		return $this->description;
	}

					/*	SETER*/
	public function setCategory(Category $category)
	{
		$this->category = $category;
		$this->id_category = $category->getId();
		return true;
	}
	public function setName($name)
	{
		if(strlen($name)> 1 && strlen($name)< 31)
		{
			$this->name = $name;
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nom de moins de 32caractères");
		}
	}
	public function setPrice($price)
	{
		if (ctype_digit($price))
		{
			$this->price = $price;	
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");		
		}
	}
	public function setStock($stock)
	{
		if (ctype_digit($price))
		{
			$this->stock = intval($stock);
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");		
		}
	}
	public function setImage($image)
	{
		
	}
	public function setDescription($description)
	{
		if(strlen($descritpion) >1 && strlen($description) < 256)
		{
			$this->description = ($stock);
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer une description de moins de 256caractères");
		}
	}

}


 ?>