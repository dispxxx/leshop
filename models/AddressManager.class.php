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
	}

}
?>