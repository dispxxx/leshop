<?php
class UserManager
{


	// Properties
	private $db;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Functions


	// Create user
	public function create(Adress $adress, $email, $name, $surname, $password, $password2)
	{
		$user 		= new User($this -> db);

		try
		{
			$user -> setAdress($adress);
			$user -> setEmail($email);
			$user -> setName($name);
			$user -> setSurname($surname);
			$user -> setHash($password, $password2);
		}
		catch (Exception $e)
		{
			$err = $e -> getmessage();
		}

		if (!$err)
		{
			$idAdress 	= $user -> getAdress() -> getId();
			$email 		= $db -> quote($user -> getEmail());
			$name 		= $db -> quote($user -> getName());
			$surname 	= $db -> quote($user -> getSurname());
			$hash 		= $user -> getHash();
			$query		= '	INSERT INTO user (id_adress, email, name, surname, hash)
							VALUES ("'.$idAdress.'""'.$email.'","'.$name.'","'.$surname.'","'.$password.'")';
			$res		= $db -> exec($query);

			if ($res)
			{
				$id = $db -> lastInsertId();

				if ($id)
				{
					return $this -> readById($id);
				}
				else
				{
					throw new Exception('01 : Database error');
				}
			}
			else
			{
				throw new Exception('User already exist');
			}
		}
		else
		{
			throw new Exception($err);
		}
	}


	// Read all users
	public function read($n = 0)
	{
		$n = intval($n);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM user
						ORDER BY `date_registered` ASC
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM user
						ORDER BY `date_registered` ASC';
		}

		$res 	= $db -> query($this -> db, $query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'Section', array($this -> db));
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by id
	public function readById($id)
	{
		$query 	= "SELECT * FROM user WHERE id = '".$id."'";
		$res 	= $db -> query($query);

		if ($res)
		{
			if ($user = $res -> fetchObject('User', array($this -> db)))
			{
				return $user;
			}
			else
			{
				throw new Exception('User not found');
			}
		}
		else
		{
			throw new Exception('Error 02 : Internal server error');
		}
	}
?>