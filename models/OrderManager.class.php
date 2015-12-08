<?php 
class OrderManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function create(User $user)
	{
		$order = new Order($this->db);
		$idUser = $order->getUser()->getId();

		$query = "INSERT INTO order (id_user) VALUES('".$idUser."')";
		try
		{
			$res =  $db->exec($query);
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
		$id = $db->lastInsertId();
		if($id)
		{
			return $this-findByID($id);
		}
	}
}
?>