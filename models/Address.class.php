<?php 
class Address
{
	private $id;
	private $id_user;
	private $street;
	private $city;
	private $citycode;
	private $country;
	
public function __construct($db)
{
	$this->db = $db;
}

// ____ Getter _____

	public function getId()
	{
		return $this->id;
	}
	public function getIduser()
	{
		return $this->id_user;
	}
	public function getStreet()
	{
		return $this->street;
	}
	public function getCity()
	{
		return $this->city;
	}
	public function getCitycode()
	{
		return $this->citycode;
	}
	public function getCountry()
	{
		return $this->country;
	}

// _____ setter_____

	public function setId($id)
	{	
		$this->id = $id();
		return true;
	}
	public function setIduser($id_user)
	{	
		$this->id_user = $id_user();
		return true;
	}
	public function setStreet($street)
	{	
		if (strlen($street) > 1 && strlen($street) < 64)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#"))
			{
				$this ->street = $street;
				return true;
			}
			else
			{
				throw new Exception('Invalid street');
			}
		}
		else
		{
			throw new Exception("Street must be between 2 and 31 characters");
		}
	}
	public function setCity($city)
	{	
		if (strlen($city) > 1 && strlen($city) < 64)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#"))
			{
				$this ->city = $city;
				return true;
			}
			else
			{
				throw new Exception('Invalid city');
			}
		}
		else
		{
			throw new Exception("City must be between 2 and 31 characters");
		}
	}
	public function setCitycode($citycode)
	{
		if (strlen($citycode) > 1 && strlen($citycode) < 64)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#"))
			{
				$this ->citycode = $citycode;
				return true;
			}
			else
			{
				throw new Exception('Invalid citycode');
			}
		}
		else
		{
			throw new Exception("Citycode must be between 2 and 31 characters");
		}
	}
	public function setCountry($country)
	{
		if (strlen($country) > 1 && strlen($country) < 64)
		{
			if (preg_match("#[a-zA-Z0-9]+[ -_']*$#", $login))
			{
				$this ->country = $country;
				return true;
			}
			else
			{
				throw new Exception('Invalid country');
			}
		}
		else
		{
			throw new Exception("Country must be between 2 and 31 characters");
		}
	}
} 
?>