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
					throw new Exception('Database error');
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
			return $users;
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
			throw new Exception('Internal server error');
		}
	}


	// Read by adress
	public function readByAdress(Adress $adress)
	{
		$id 	= $adress -> getId();
		$query 	= 'SELECT * FROM user WHERE id_adress = "'.$id.'"';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('No user found');
		}
	}


	// Read user by email
	public function readByEmail($email)
	{
		$email 	= $db -> quote($email);
		$query 	= 'SELECT * FROM user WHERE email = "'.$email.'"';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by name
	public function readByName($name)
	{
		$name 	= $db -> quote($name);
		$query 	= 'SELECT * FROM user WHERE name = "'.$name.'"';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by surname
	public function readBySurname($surname)
	{
		$surname 	= $db -> quote($surname);
		$query 		= 'SELECT * FROM user WHERE surname = "'.$surname.'"';
		$res 		= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by status
	public function readByStatus($status)
	{
		$status = intval($status);
		$query 	= 'SELECT * FROM user WHERE status = "'.$status.'"';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by Date registration
	public function readByDateRegistration($min, $max)
	{
		$min 	= intval($min);
		$max 	= intval($max);
		$query 	= '	SELECT *
					FROM user
					WHERE date_registration >= '.$min.' AND date_registration <= '.$max.'
					ORDER BY login DESC';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read user by Date connection
	public function readByDateConnection($min, $max)
	{
		$min 	= intval($min);
		$max 	= intval($max);
		$query 	= '	SELECT *
					FROM user
					WHERE date_connection >= '.$min.' AND date_connection <= '.$max.'
					ORDER BY login DESC';
		$res 	= $db -> query($query);

		if ($res)
		{
			$users = $res -> fetchAll(PDO::FETCH_CLASS, 'User', array($this -> db));
			return $users;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Update user
	public function update(User $user)
	{
		$id 				= intval($user -> getId());
		$adressId			= intval($user -> getAdress() -> getId());
		$email 				= $db -> quote($user -> getEmail());
		$name 				= $db -> quote($user -> getName());
		$surname 			= $db -> quote($user -> getSurname());
		$hash 				= $user -> getHash();
		$status 			= intval($user -> getStatus());
		$dateConnection 	= date('Y-m-d H:i:s', $user -> getDateConnection());
		$query 				= "	UPDATE user
								SET 	email 		= '".$email."',
										login 		= '".$name."',
										`password` 	= '".$hash."',
										`status` 	= '".$status."',
										avatar 		= '".$avatar."',
										date_ban 	= '".$dateBan."'
										WHERE id 	= '".$id."'";
		$res 				= $db -> exec($query);

		if ($res)
		{
			return $this -> readById($id);
		}
		else
		{
			throw new Exception('Database error');
		}
	}

	// Delete user
	public function delete(User $user)
	{
		$id 	= intval($user -> getId());
		$query 	= 'DELETE FROM user WHERE id = '.$id;
		$res 	= $db -> exec($query);

		if ($res)
		{
			return true;
		}
		else
		{
			throw new Exception('Database error');
		}
	}
?>