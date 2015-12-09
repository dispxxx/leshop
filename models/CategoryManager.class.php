<?php
class CategoryManager
{

	// Properties
	private $db;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Create new category
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
			$err = $e -> getMessage();
		}

		if (!isset($err))
		{
			$name 			= $this -> db -> quote($category -> getName());
			$description 	= $this -> db -> quote($category -> getDescription());
			$query 			= '	INSERT INTO category (name, description)
								VALUES ('.$name.', '.$description.')';
			$res 			= $this -> db -> exec($query);

			if($res)
				{
					$id = $this -> db -> lastInsertId();

					if ($id)
					{
						return $this -> readById($id);
					}
					else
					{
						throw new Exception('Database error');
					}
				}
				else
				{
					throw new Exception("Database error");
				}
		}
		else
		{
			throw new Exception($err);
		}
	}


	// Read categories
	public function read($n = 0)
	{
		$n = intval($n);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM category
						ORDER BY `name` ASC
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM category
						ORDER BY `name` ASC';
		}

		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$categories = $res -> fetchAll(PDO::FETCH_CLASS, 'Category', array($this -> db));
			return $categories;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read category by id
	public function readById($id)
	{
		$id 	= intval($id);
		$query 	= "SELECT * FROM category WHERE id='".$id."'";
		$res 	= $this -> db -> exec($query);
		if($res)
		{
			$category = $res -> fetchObject("Category", array($this -> db));
			if($rubrique)
			{
				return $category;
			}
			else
			{
				return "Category not found";
			}
		}
		else
		{
			return "Error";
		}
	}


	// Read category by name
	public function readByName($name)
	{
		$name 	= $this -> db -> quote($name);
		$query 	= 'SELECT * FROM category WHERE name = '.$name;
		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$categories = $res -> fetchAll(PDO::FETCH_CLASS, 'Category', array($this -> db));
			return $categories;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read category by description
	public function readByDescription($description)
	{
		$description 	= $this -> db -> quote($description);
		$query 			= 'SELECT * FROM category WHERE description = '.$description;
		$res 			= $this -> db -> query($query);

		if ($res)
		{
			$categories = $res -> fetchAll(PDO::FETCH_CLASS, 'Category', array($this -> db));
			return $categories;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Update category
	public function update(Category $category)
	{
		$id = $this -> db -> intval($category -> getId());
		$name = $this -> db -> quote($category -> getName());
		$description = $this -> db -> quote($category -> getDescription());

		$query = "UPDATE category SET name='".$name."', description='".$description."', WHERE id='".$id."'";
		$res = $this -> db -> exec($query);
		if ($result)
		{
			return $this -> readById($id);
		}
		else
		{
			return "Error";
		}
	}


	// Delete category
	public function delete(Category $category)
	{
		$id = $this -> db -> quote($category -> getId());
		$query = "DELETE FROM category WHERE id='".$id."'";
		$res = $this -> db -> exec($query);
		if($res)
		{
			return true;
		}
		else
		{
			return "Error";
		}
	}
}
?>