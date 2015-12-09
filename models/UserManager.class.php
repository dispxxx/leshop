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
	public function create($email, $name, $surname, $password, $password2)
	{
		$user 		= new User($this -> db);

		try
		{
			$user -> setEmail($email);
			$user -> setName($name);
			$user -> setSurname($surname);
			$user -> setHash($password, $password2);
		}
		catch (Exception $e)
		{
			$err = $e -> getmessage();
		}

		if (!isset($err))
		{
			$email 		= $this -> db -> quote($user -> getEmail());
			$name 		= $this -> db -> quote($user -> getName());
			$surname 	= $this -> db -> quote($user -> getSurname());
			$hash 		= $user -> getHash();
			$query		= '	INSERT INTO user (email, name, surname, hash)
							VALUES ('.$email.','.$name.','.$surname.',"'.$hash.'")';
			$res		= $this -> db -> exec($query);

			if ($res)
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
				throw new Exception('User already exist');
			}
		}
		else
		{
			throw new Exception($err);
		}
	}


	// Read all users
	public function read($n = 0, $filter='date_registration', $order = 'ASC')
	{
		$n 		= intval($n);
		$filter = $this -> db -> quote($filter);
		$order 	= $this -> db -> quote($order);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM user
						ORDER BY '.$filter.' '.$order.'
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM user
						ORDER BY '.$filter.' '.$order;
		}

		$res 	= $this -> db -> query($query);

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


	// Read user by id
	public function readById($id)
	{
		$query 	= 'SELECT * FROM user WHERE id = '.$id;
		$res 	= $this -> db -> query($query);

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
		$query 	= 'SELECT * FROM user WHERE id_adress = '.$id.' ORDER BY id_adress DESC';
		$res 	= $this -> db -> query($query);

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


	// Read user by email
	public function readByEmail($email)
	{
		$email 	= $this -> db -> quote($email);
		$query 	= 'SELECT * FROM user WHERE email = '.$email.' ORDER BY email DESC';
		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$users = $res -> fetchObject('User', array($this -> db));
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
		$name 	= $this -> db -> quote($name);
		$query 	= 'SELECT * FROM user WHERE name = '.$name.' ORDER BY name DESC';
		$res 	= $this -> db -> query($query);

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
		$surname 	= $this -> db -> quote($surname);
		$query 		= 'SELECT * FROM user WHERE surname = '.$surname.' ORDER BY surname DESC';
		$res 		= $this -> db -> query($query);

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
		$query 	= 'SELECT * FROM user WHERE status = '.$status.' ORDER BY email DESC';
		$res 	= $this -> db -> query($query);

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
					ORDER BY date_registration ASC';
		$res 	= $this -> db -> query($query);

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
					ORDER BY date_connection ASC';
		$res 	= $this -> db -> query($query);

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
		$email 				= $this -> db -> quote($user -> getEmail());
		$name 				= $this -> db -> quote($user -> getName());
		$surname 			= $this -> db -> quote($user -> getSurname());
		$hash 				= $user -> getHash();
		$status 			= intval($user -> getStatus());
		$dateConnection 	= date('Y-m-d H:i:s', $user -> getDateConnection());
		$query 				= '	UPDATE  user
								SET 	email 			= '.$email.',
										name 			= '.$name.',
										surname 		= '.$surname.',
										`hash` 			= "'.$hash.'",
										`status` 		= '.$status.',
										date_connection = "'.$dateConnection.'"
										WHERE id 	= '.$id;
		$res 				= $this -> db -> exec($query);

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