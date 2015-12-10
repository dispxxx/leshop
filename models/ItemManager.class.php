<?php
class ItemManager
{

	// Properties
	private $db;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Create new item
	public function create(Category $category, $name, $price, $stock, $image, $description)
	{
		$errors = array();
		$item = new Item($this -> db);

		try
		{
			$item -> setCategory($category);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		try
		{
			$item -> setName($name);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		try
		{
			$item -> setPrice($price);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		try
		{
			$item -> setStock($stock);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		try
		{
			$item -> setImage($image);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		try
		{
			$item -> setDescription($description);
		}
		catch (Exception $e)
		{
			$errors[] = $e -> getMessage();
		}
		if (count($errors) == 0)
		{
			$name 			= $this -> db -> quote($item -> getName());
			$price 			= $this -> db -> quote($item -> getPrice());
			$stock 			= $this -> db -> quote($item -> getStock());
			$image 			= $this -> db -> quote($item -> getImage());
			$description 	= $this -> db -> quote($item -> getDescription());
			$idCategory 	= $item -> getCategory() -> getId();
			$query 			= '	INSERT INTO item (id_category, name, price, stock, image, description)
								VALUES('.$idCategory.','.$name.','.$price.','.$stock.','.$image.','.$description.')';
			$res 			= $this -> db	 -> exec($query);

			if($res)
			{
				$id = $this -> db	 -> lastInsertId();
				if($id)
				{
					return $this-> readByID($id);
				}
				else
				{
					throw new Exception('Internal server Error');
				}
			}
		}
	}


	// Read all items
	public function read($n = 0, $filter = 'name', $order = 'ASC')
	{
		$n = intval($n);
		$filter = $this -> db -> quote($filter);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM item
						ORDER BY '.$filter.' DESC
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM item
						ORDER BY '.$filter.' DESC';
		}

		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$items = $res -> fetchAll(PDO::FETCH_CLASS, 'Item', array($this -> db));
			return $items;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read item by ID
	public function readById($id)
	{
		$query 	= 'SELECT * FROM item WHERE id = '.$id;
		$res 	= $this -> db -> query($query);

		if ($res)
		{
			if ($item = $res -> fetchObject('Item', array($this -> db)))
			{
				return $item;
			}
			else
			{
				throw new Exception('Item not found');
			}
		}
		else
		{
			throw new Exception('Internal server error');
		}
	}


	// Read items by category
	public function readByCategory(Category $category, $filter = 'name', $order = 'ASC')
	{
		$idCategory = $category -> getId();
		$query 		= '	SELECT * FROM item
						WHERE id_category='.$idCategory.'
						ORDER BY '.$filter.' '.$order;
		$res 		= $this -> db -> query($query);

		if ($res)
		{
			$items 	= $res -> fetchAll(PDO::FETCH_CLASS, 'Item', array($this -> db));
			return $items;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read item by name
	public function readByName($name)
	{
		$name 	= $this -> db -> quote($item -> getName());
		$query 	= 'SELECT * FROM item WHERE name='.$name;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$item = $res -> fetchObject('Item', array($this -> db));

			if ($item)
			{
				return $item;
			}
			else
			{
				throw new Exception('Item not found');
			}
		}
		else
		{
			throw new Exception('Internal Server Error');
		}
	}


	// Update item
	public function update(Item $item)
	{
		$idCategory 	= $item -> getCategory() -> getId();
		$id 			= intval($id);
		$name 			= $this -> db -> quote($item -> getName());
		$price 			= $this -> db -> quote($item -> getPrice());
		$stock 			= $this -> db -> quote($item -> getStock());
		$image 			= $this -> db -> quote($item -> getImage());
		$description 	= $this -> db -> quote($item -> getDescription());
		$query 			= '	UPDATE item
							SET name='.$name.',
								price='.$price.',
								stock='.$stock.',
								image='.$image.',
								description='.$description.',
								id_category='.$idCategory.'
							WHERE id='.$id;
		$res 			= $this -> db -> exec($query);

		if($res)
		{
			$id = $this -> db -> lastInsertId();

			if($id)
			{
				return $this -> findByID($id);
			}
			else
			{
				throw new Exception('Internal server Error');
			}
		}
	}


	// Delete item
	public function delete(Item $item)
	{
		$id 	= $item -> getId();
		$query 	= 'DELETE FROM item WHERE id='.$id;
		$res 	= $this -> db -> exec($query);

		if ($res)
		{
			return true;
		}
		else
		{
			throw new Exception('Database error');
		}
	}
}
?>
