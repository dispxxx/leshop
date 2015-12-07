<?php
class User
{


	// Properties
	private $id;
	private $id_address;
	private $address;
	private $email;
	private $hash;
	private $name;
	private $surname;
	private $status;
	private $date_registration;
	private $date_connection;
	private $db;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Getters


	// Get user id
	public function getId()
	{
		return $this -> id;
	}


	// Get user adress
	public function getAdress()
	{
		if (!$this -> address)
		{
			$addressManager = new AddressManager($this -> db);
			$this -> address = $addressManager -> readById($this -> id_address);
		}
		return $this -> address;
	}


	// Get user email
	public function getEmail()
	{
		return $this -> email;
	}


	// Get user hash
	public function getHash()
	{
		return $this -> hash;
	}


	// Get user name
	public function getName()
	{
		return $this -> name;
	}


	// Get user surname
	public function getSurname()
	{
		return $this -> surname;
	}


	// Get user status
	public function getStatus()
	{
		return $this -> status;
	}


	// Get user registration date
	public function getDateRegistration()
	{
		return $this -> date_registration;
	}


	// Get user last connection date
	public function getDateConnection()
	{
		return $this -> date_connection;
	}


	// Setters


	// Set user adress
	public function setAdress(Adress $adress)
	{
		$this -> id_adress = $adress -> getId();
		return true;
	}


	// Set user email
	public function setEmail($email)
	{
		if (strlen($email) > 5 && strlen($email) < 63)
		{
			if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,5}$#", $email))
			{
				$this ->email = $email;
				return true;
			}
			else
			{
				throw new Exception('Email format invalid');
			}
		}
		else
		{
			throw new Exception('Email format invalid');
		}
	}


	// Set user hash
	public function setHash($password, $password2)
	{
		if (strlen($password) > 7 && strlen($password) < 32)
		{
			if ($password == $password2)
			{
				$this ->password = password_hash($password, PASSWORD_DEFAULT);
				return true;
			}
			else
			{
				throw new Exception("Passwords don't match");
			}
		}
		else
		{
			throw new Exception('Password must be between 6 and 31 characters');
		}
	}


	// Set user name
	public function setName($name)
	{
		if (strlen($login) > 1 && strlen($login) < 32)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#", $login))
			{
				$this ->login = $login;
				return true;
			}
			else
			{
				throw new Exception('Invalid name');
			}
		}
		else
		{
			throw new Exception("Name must be between 2 and 31 characters");
		}
	}


	// Set user surname
	public function setSurname($surname)
	{
		if (strlen($login) > 1 && strlen($login) < 32)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#", $login))
			{
				$this ->login = $login;
				return true;
			}
			else
			{
				throw new Exception('Invalid surname');
			}
		}
		else
		{
			throw new Exception("Surname must be between 2 and 31 characters");
		}
	}


	// Set user status
	public function setStatus($status)
	{
		if ($status == 0)
		{
			$this -> status = 0;
			return true;
		}
		else if ($status == 1)
		{
			$this -> status = 1;
			return true;
		}
		else if ($status == 2)
		{
			$this -> status = 2;
			return true;
		}
		else
		{
			throw new Exception('Invalid status');
		}
	}


	// Set last connection date
	public function setDateConnection($date)
	{
		if (ctype_digit(strtotime($date)))
		{
			$this -> date_connection = $date;
			return true;
		}
		else
		{
			throw new Exception('Format needs to be a timestamp');
		}
	}
?>