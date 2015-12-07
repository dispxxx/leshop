<?php
class User
{


	// Properties
	private $id;
	private $id_adress;
	private $adress;
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
	public function getId()
	{
		return $this -> id;
	}
	public function getIdAdress()
	{
		return $this -> id_adress;
	}
	public function getEmail()
	{
		return $this -> email;
	}
	public function getHash()
	{
		return $this -> hash;
	}
	public function getName()
	{
		return $this -> name;
	}
	public function getSurname()
	{
		return $this -> surname;
	}
	public function getStatus()
	{
		return $this -> status;
	}
	public function getDateRegistration()
	{
		return $this -> date_registration;
	}
	public function getDateConnection()
	{
		return $this -> date_connection;
	}


	// Setters
	public function setAdress(Adress $adress)
	{

	}
?>