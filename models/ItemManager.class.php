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
		$errors = array();
		$item = new Item($this->db);
		try
		{
			$item->setName($name);
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$item->setDescription($description);
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$item->setImage($image);
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$item->setStock($stock);
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$item->setPrice($price);
		}
		catch (Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		if(count($errors) == 0)
		{
			$name = $db->quote($item->getName());
			$price = $db->quote($item->getPrice());
			$stock = $db->quote($item->getStock());
			$image = $db->quote($item->getImage());
			$description = $db->quote($item->getDescription());
			$idCategory = $item->getCategory()->getId();
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
	public function getDelete(Item $item)
	{
		$id = $item->getId();
		$query = "DELETE FROM item WHERE id='".$id."'";
		$res = $db->exec($query);
		return "internal Server Error";
	}
	public function edit(Item $item)
	{
		$idCategory = $item->getCategory()->getId();
		$id = intval($id);
		$name = $db->quote($item->getName());
		$price = $db->quote($item->getPrice());
		$stock = $db->quote($item->getStock());
		$image = $db->quote($item->getImage());
		$description = $db->quote($item->getDescription());
		$query = "UPDATE item SET name='".$name."', price='".$price."', stock='".$stock."',image='".$image."', description='".$description."', id_category='".$idCategory."' WHERE id='".$id."' ";
		$res = $db->exec($query);
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

	public function getLast()
	{
		$query = "SELECT * FROM item ORDER BY date DESC LIMIT 20";
		$res = $db->exec($query);
		$listItem = $res->fetchAll(PDO::FETCH_CLASS, "Item", array($this->db));
		return $listItem;
	}

	public function getByCategory(Category $category, $filter="name", $order="ASC")
	{
		if($filter == "name" || $filter == "price" || )
		{
			if($order == "ASC" || $order == "DESC")
			{
				$idCategory = $category->getId();
				$query = "SELECT * FROM item WHERE id_category='".$idCategory."' ORDER BY '".$filter."' '".$order."'";
				$res = $this->db->query($query);
				$listItem = $res->fetchAll(PDO::FETCH_CLASS, "Item", array($this->db));
				return $listItem;
			}
		}
	}
	public function getByName($order="ASC")
	{
		if($order == "ASC" || $order == "DESC")
			{
			$query = "SELECT * FROM item ORDER BY name '".$order."'";
			$res = $this->db->query($query);
			$listItem = $res->fetchAll(PDO::FETCH_CLASS, "Item", array($this->db));
			return $listItem;
			}
	}
	public function readByName($name)
	{
		$name = $db->quote($item->getName());
		$query = "SELECT * FROM item WHERE name='".$name."'";
		$res = $this->db->query($query);
		if($res)
		{
			$item = $res->fetchObject("Item", array($this->db));
			if ($item)
			{
				return $item;
			}
			else
			{
				return "Item not found";
			}
		}
		else
		{
			return "Internal Server Error";
		}
	}
}
?>
