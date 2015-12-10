<?php
class OrderManager
{


	// Properties
	private $db;


	// Constructor
	public function __construct($db)
	{
		$this -> db = $db;
	}


	// Create new order
	public function create(User $user)
	{
		$order = new Order($this -> db);
		$idUser = $order -> getUser() -> getId();

		$query = "INSERT INTO order (id_user) VALUES('".$idUser."')";
		try
		{
			$res =  $db -> exec($query);
		}
		catch(Exception $e)
		{
			return $e -> getMessage();
		}
		$id = $db -> lastInsertId();
		if($id)
		{
			return $this-findByID($id);
		}
	}


	// Read orders
	public function read($n = 0, $filter = 'price', $order = 'ASC')
	{
		$n 		= intval($n);
		$filter = $this -> db -> quote($filter);
		$order 	= $this -> db -> quote($order);

		if ($n > 0)
		{
			$query = '	SELECT *
						FROM order
						ORDER BY '.$filter.' '.$order.'
						LIMIT '.$n;
		}
		else
		{
			$query = '	SELECT *
						FROM order
						ORDER BY '.$filter.' '.$order;
		}

		$res 	= $this -> db -> query($query);

		if ($res)
		{
			$orders = $res -> fetchAll(PDO::FETCH_CLASS, 'Order', array($this -> db));
			return $orders;
		}
		else
		{
			throw new Exception('Database error');
		}
	}


	// Read order by id
	public function readById($id)
	{
		$id 	= intval($id);
		$query 	= "SELECT * FROM order WHERE id=".$id;
		$res 	= $this -> db -> query($query);

		if($res)
		{
			$order = $res -> fetchObject("Order", array($this -> db));

			if($order)
			{
				return $order;
			}
			else
			{
				return "Order not found";
			}
		}
		else
		{
			return "Error";
		}
	}


	// Read order by id user



	// Read order by id delivery



	// Read order by id billing



	// Read order by status



	// Read order by price



	// Read order by date pay



	// Read order by date sent


	// Update order
	public function update (Order $order)
	{
		$id 			= intval($order -> getId());
		$id_delivery 	= intval($order -> getDelivery() -> getId());
		$id_billing 	= intval($order -> getBilling() -> getId());
		$status 		= intval($order -> getStatus());
		$price 			= floatval($order -> getPrice());
		$date_update 	= date('Y-m-d H:i:s', strtotime($order -> getDateUpdate()));
		$date_pay 		= date('Y-m-d H:i:s', strtotime($order -> getDatePay()));
		$date_send 		= date('Y-m-d H:i:s', strtotime($order -> getDateSend()));
		$date_reception = date('Y-m-d H:i:s', strtotime($order -> getDateReception()));

		$query 	= '	UPDATE order
					SET id_delivery 	= '.$id_delivery.',
						id_billing 		= '.$id_billing.',
						status 			= '.$status.',
						price 			= '.$price.',
						date_update 	= '.$date_update.',
						date_pay 		= '.$date_pay.',
						date_send 		= '.$date_send.',
						date_reception 	= '.$date_reception.'
						WHERE id 		= '.$id;
		$res 	= $this -> db -> exec($query);

		if ($res)
		{
			return $this -> readById($id);
		}
		else
		{
			throw new Exception('Internal server error');
		}
	}


	// Delete order
	public function delete (Order $order)
	{

	}


	// Update order price
	public function updatePrice(Order $order)
	{
		$id 		= $order -> getId();
		$query 		= 'SELECT price FROM link_order_item WHERE id_order = '.$id;
		$res 		= $this -> db -> query($query);
		$prices 	= $res -> fetchAll(PDO::FETCH_CLASS, "Link_order_item", array($this -> db));

		/* utiliser le tableau $listPrice, additionner tous les résultats et obtenir $price*/
		$query = "UPDATE order SET price='".$price."' WHERE id='".$id."' ";
		$res = $db -> exec($query);
		if($res)
		{
			$id = $db -> lastInsertId();
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