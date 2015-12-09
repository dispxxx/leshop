<?php
class Item
{


	// Properties
	private $db;
	private $id;
	private $id_category;
	private $category;
	private $name;
	private $price;
	private $stock;
	private $image;
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
	public function getCategory()
	{
		if (!$this -> category)
		{
			$categoryManager = new CategoryManager($this -> db);
			$this -> category = $categoryManager -> readById($this -> id_category);
		}
		return $this -> category;
	}
	public function getName()
	{
		return $this -> name;
	}
	public function getPrice()
	{
		return $this -> price;
	}
	public function getStock()
	{
		return $this -> stock;
	}
	public function getImage()
	{
		return $this -> image;
	}
	public function getDescription()
	{
		return $this -> description;
	}


	// Setters
	public function setCategory(Category $category)
	{
		$this -> id_category = $category -> getId();
		return true;
	}
	public function setName($name)
	{
		if(strlen($name)> 1 && strlen($name)< 31)
		{
			$this -> name = $name;
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
			$this -> price = $price;
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");
		}
	}
	public function setStock($stock)
	{
		if (ctype_digit($stock))
		{
			$this -> stock = intval($stock);
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");
		}
	}
	public function setImage($image)
	{
		if ( $image_proprietes = @getimagesize($image) )
		{
			if ($image_proprietes[0] > 800 || $image_proprietes[1] > 800)
			{
				throw new Exception("Invalid image dimensions (max 800px wide, 800px high)");
			}
			else if (@filesize($image) > 1e6)
			{
				throw new Exception("Invalid image size (max 1 MB)");
			}
			else
			{
				$this -> image = $image;
				return true;
			}
		}
		else
		{
			throw new Exception("Invalid filetype");
		}
	}
	public function setDescription($description)
	{
		if(strlen($description) > 1 && strlen($description) < 255)
		{
			$this -> description = ($description);
			return true;
		}
		else
		{
			throw new Exception("Description must be under 255 characters");
		}
	}

}
?>