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
	public function editPrice(Order $order)
	{
		$id = $order->getId();
		$query = "SELECT price FROM link_order_item";
		$res = $this->db->exec($query);
		$listPrice = $res->fetchAll(PDO::FETCH_CLASS, "Link_order_item", array($this->db));
		return $listPrice;
		/* utiliser le tableau $listPrice, additionner tous les résultats et obtenir $price*/
		$query = "UPDATE order SET price='".$price."' WHERE id='".$id."' ";
		$res = $db->exec($query);
		if($res)
		{
			$id = $db->lastInsertId();
			if($id)
			{
				return $this-findByID($id);
			}
			else
			{
				return "Internal server Error";
			}
		}
	}
}
?>