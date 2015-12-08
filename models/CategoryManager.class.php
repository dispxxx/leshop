<?php 
class CategoryManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function create($name, $description)
	{
		$category 	= new Category($this -> db);
		try
		{
			$category -> setName($name);
			$category -> setDescription($description);
		}
		catch (Exception $e)
		{
			$err[] = $e->getMessage();
		}
		
		if(!$err)
		{
			$name = $this->db->quote($category->getName());
			$description = $this->db->quote($category->getDescription());
			$query = "INSERT INTO category (name, description) VALUES ('".$name."', '".$description."')";
			$res = $this->db->exec($query)
			if($res)
				{
					return $this->findById($id);
				}
				else
				{
					return "error";
				}
		}
	}

	public function delete(Category $category)
	{
		$id = $this->db->quote($category->getId());
		$query = "DELETE FROM category WHERE id='".$id."'";
		$res = $this->db->exec($query);
		if($res)
		{
			return true;
		}
		else 
		{
			return "Error";
		}
	}
	
	public function update(Category $category)
	{
		$id = $this->db->intval($category->getId());
		$name = $this->db->quote($category->getName());
		$description = $this->db->quote($category->getDescription());

		$query = "UPDATE category SET name='".$name."', description='".$description."', WHERE id='".$id."'";
		$res = $this->db->exec($query);
		if ($result)
		{
			return $this->readById($id);
		}
		else
		{
			return "Error";
		}
	}
	public function find($id)
	{
		return $this->readById($id); 
	}
	public function findById($id)
	{
		$id = intval($id);
		$query = "SELECT * FROM category WHERE id='".$id."'";
		$result = mysqli_query($this->db, $query);
		if($result)
		{
			$category = mysqli_fetch_object($result, "Category");
			if($rubrique)
			{
				return $rubrique;
			}
			else
			{
				return "Rubrique not found";
			}
		}
		else 
		{
			return "Error";
		}
	}
	public function findByDescription($description)
	{
		return $this->readByDescription($description);
	}
}
?>