<?php 
class ItemManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	public function create(Category $category, $name, $price, $stock, $image, $description)
	{
		$item = new Item($this->db);
		$valide = $item->setName($name);
		if($valide === true)
		{
			$valide = $item->setPrice($price);
			if($valide === true)
			{
				$valide = $item->setStock($stock);
				if($valide === true)
				{
					$valide = $item->setImage($image);
					if($valide === true)
					{
						$valide = $item->setDescription($description);
						if($valide === true)
						{
							$name = $db->quote($item->getName());
							$price = $db->quote($item->getPrice());
							$stock = $db->quote($item->getStock());
							$image = $db->quote($item->getImage());
							$description = $db->quote($item->getDescription());
							$idCategory = $item->getCategory->getId();
							$query = "INSERT INTO item (id_category, name, price, stock, image, description) VALUES('".$idCategory."','".$name."''".$price."''".$stock."''".$image."''".$description."')";
							$res =  $db->exec($query);
							if($res)
							{
								$id = $db->lastInsertId();
								if($id)
								{
									return $this-findByID($id);
								}
								else
								{
									return "Internal server Error";
								}
							}
						}
					}
				}
			}
		}
	}
}


 ?>