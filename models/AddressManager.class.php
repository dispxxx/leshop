<?php
class AddressManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	public function create(User $user, $street, $city, $citycode, $country)
	{
		$errors = array();
		$address = new Address($this->db);
		try
		{
			$address->setStreet($street);
		}
		catch(Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$address->setCity($city);
		}
		catch(Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$address->setCitycode($citycode);
		}
		catch(Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		try
		{
			$address->setCountry($country);
		}
		catch(Exception $e)
		{
			$errors[] = $e->getMessage();
		}
		if(count($errors) == 0)
		{
			$street = $db->quote($address->getStreet());
			$city = $db->quote($address->getCity());
			$citycode = $db->quote($address->getCitycode());
			$country = $db->quote($address->getCountry());
			$iduser = $address->getUser()->getId();
			$query = "INSERT INTO item (id_user, street, city, citycode, country) VALUES('".$iduser."','".$street."''".$city."''".$citycode."''".$country."')";
			if($res)
			{	
				$id = $db->lastInsertId();
				if($id)
				{
					return $this->readById($id);
				}
				else
				{
					return "Internal server Error"
				}
			}
		}
	}

	public function read($n = 0)
	{
		$n = intval($n);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM address
						ORDER BY `id` ASC
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM address
						ORDER BY `id` ASC';
		}

		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'Address', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}
	public function readById(Address $address)
	{
		$idCategory = $category -> getId();
		$query 		= '	SELECT * FROM address
						WHERE id="'.$id.'"'; 
		$res 		= $this -> db -> query($query);

		if ($res)
		{
			$items 	= $res -> fetchAll(PDO::FETCH_CLASS, 'Address', array($this -> db));
			return $address;
		}
		else
		{
			throw new Exception('Database error');
		}
	}

	public function readByStreet($street)
	{
		$street = $this -> db -> quote($address -> getStreet());
		$query 	= 'SELECT * FROM address WHERE street='.$street;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$address = $res -> fetchObject('Address', array($this -> db));

			if ($address)
			{
				return $address;
			}
			else
			{
				throw new Exception('Address not found');
			}
		}
		else
		{
			throw new Exception('Internal Server Error');
		}
	}

	public function readByCity($city)
	{
		$city = $this -> db -> quote($city -> getCity());
		$query 	= 'SELECT * FROM address WHERE city='.$city;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$address = $res -> fetchObject('Address', array($this -> db));

			if ($address)
			{
				return $address;
			}
			else
			{
				throw new Exception('Address not found');
			}
		}
		else
		{
			throw new Exception('Internal Server Error');
		}
	}

	public function readByCitycode($citycode)
	{
		$citycode = $this -> db -> quote($address -> getCitycode());
		$query 	= 'SELECT * FROM address WHERE citycode='.$citycode;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$address = $res -> fetchObject('Address', array($this -> db));

			if ($address)
			{
				return $address;
			}
			else
			{
				throw new Exception('Address not found');
			}
		}
		else
		{
			throw new Exception('Internal Server Error');
		}
	}

	public function readByCountry($country)
	{
		$country = $this -> db -> quote($address -> getCountry());
		$query 	= 'SELECT * FROM address WHERE country='.$country;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$address = $res -> fetchObject('Address', array($this -> db));

			if ($address)
			{
				return $address;
			}
			else
			{
				throw new Exception('Address not found');
			}
		}
		else
		{
			throw new Exception('Internal Server Error');
		}
	}

	public function update(Address $address)
	{
		$idUser   = $address->getAddress()->getId();
		$id       = intval($id);
		$street   = $db->quote($address->getStreet());
		$city     = $db->quote($address->getCity());
		$citycode = $db->quote($address->getCitycode());
		$country  = $db->quote($adress->getCountry());
		$query    = "UPDATE address SET street ='".$street."', city ='".$city."', citycode='".$citycode."', country='".$country."' WHERE id='".$id."' ";
		$res      = $db->exec($query);
		if($res)
		{
			$id = $db->lastInsertId();
			if($id)
			{
				return $this->readById($id);
			}
			else
			{
				throw new Exception('Database error')
			}
		}
	}
	public function delete(Address $address)
	{
		$id    = $address->getId();
		$query = "DELETE FROM address WHERE id='".$id."'";
		$res   = $this -> db -> exec($query);
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