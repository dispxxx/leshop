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
	public function getDelete(Address $address)
	{
		$id = $address->getId();
		$query = "DELETE FROM address WHERE id='".$id."'";
		$res = $db->exec($query);
		return "internal Server error"; 
	}
	
}
?>