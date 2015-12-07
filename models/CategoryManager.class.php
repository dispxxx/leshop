<?php 
class CategoryManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function create(User $id, $name, $description)
	{
		$Category = new Category();
		$valid = $category->setId($id);
		// var_dump($valide);
		if($valid === true)
		{
			$valid = $categoty->setName($name);
			
			if ($valid === true)
			{
				$valid = $category->setDescription($description);
				
				if($valide === true)
				{
					
					$name = mysqli_real_escape_string($this->db, $category->getName());
					$description = mysqli_real_escape_string($this->db, $category->getDescription());
						
					$id = $category->getId();
					$query = "INSERT INTO category (id, name, description) VALUES ('".$name."', '".$id."','".$description."', '".$image."')";
					
					$result = mysqli_query($this->db, $query);
					if($result)
					{
						$id = mysqli_insert_id($this->db);
						if($id)
						{
							return $this->readById($id);
						}
							else
							{
								return "error";
							}
					}
					else
					{
						return mysqli_error($this->db);	
					}
				}
				else
				{
					return $valide;
				}
			}
			else
			{
				return $valide;
			}
		}
		else
		{
			return $valide;
		}
	}


	public function delete(Category $category)
	{
		$id = $category->getId();
		$query = "DELETE FROM category WHERE id='".$id."'";
		$result = mysqli_query($this->db, $query);
		if($result)
		{
			return true;
		}
		else 
		{
			return "Error";
		}
	}
	
	public function update(Rubrique $rubrique)
	{

		$id = intval();
		$name = mysqli_real_escape_string($this->db, $category->getName());
		$description = mysqli_real_escape_string($this->db, $category->getDescription()); 
		
		$id = $category->getId();

		$query = "UPDATE category SET name='".$name."', description='".$description."', WHERE id='".$id."'";
		$result = mysqli_query($this->db, $query);

		if ($result)
		{
			return $this->readById($id);
		}
		else
		{
			return "Error";
		}
	}
	public function read($id)
	{
		return $this->readById($id); 
	}
	public function readById($id)
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
	public function readByDescription($description)
	{
		return $this->readByDescription($description);
	}
}
?>