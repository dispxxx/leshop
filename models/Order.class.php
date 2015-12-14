<?php
class Order
{


	// Properties
	private $id;
	private $id_user;
	private $user;
	private $id_delivery;
	private $delivery;
	private $id_billing;
	private $billing;
	private $status;
	private $price;
	private $date_update;
	private $date_pay;
	private $date_send;
	private $date_reception;
	private $items = array();
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
	public function getUser()
	{
		if (!$this -> user)
		{
			$userManager = new UserManager($this -> db);
			$this -> user = $userManager -> readById($this -> user_id);
		}
		return $this -> user;
	}
	public function getDelivery()
	{
		if (!$this -> delivery)
		{
			$adressManager = new AdressManager($this -> db);
			$this -> delivery = $adressManager -> readById($this -> delivery_id);
		}
		return $this -> delivery;
	}
	public function getBilling()
	{
		if (!$this -> billing)
		{
			$adressManager = new AdressManager($this -> db);
			$this -> billing = $adressManager -> readById($this -> billing_id);
		}
		return $this -> billing;
	}
	public function getStatus()
	{
		return $this -> status;
	}
	public function getPrice()
	{
		return $this -> price;
	}
	public function getDateUpdate()
	{
		return $this -> dateUpdate;
	}
	public function getDatePay()
	{
		return $this -> datePay;
	}
	public function getDateSend()
	{
		return $this -> dateSend;
	}
	public function getDateReception()
	{
		return $this -> dateReception;
	}
	public function getItems()
	{
		if(empty($this -> items))
		{
			$query = '	SELECT item.*,quantity
						FROM link_order_item
						LEFT JOIN item
						ON item.id=link_order_item.id_item
						WHERE id_order= '.$this -> id;
			$res = $this -> db -> query($query);

			if ($res)
			{
				$items = $res -> fetchAll(PDO::FETCH_CLASS, "Item", array($this -> db));

				if ($items)
				{
					for ($i=0, $c = count($items); $i < $c; $i++)
					{
						$this -> items[] = array('item'=>$items[$i], 'quantity'=>$items[$i] -> quantity);
					}
				}
				else
				{
					throw new Exception('Database error');
				}
			}
			else
			{
				throw new Exception('Database error');
			}
		}
		return $this -> items;
	}


	// Update item in order
	public function updateItem(Item $item, $quantity)
	{
		if ($quantity <= 0)
		{
			$query 	= "	DELETE FROM link_order_item
						WHERE id_order='".$this -> id."'
						AND id_item='".$item -> getId()."'";
			$res 	= $this -> db -> exec($query);

			if ($res)
			{
				$this -> items = array();
				return $this -> getItems();
			}
			else
			{
				throw new Exception('Database error');
			}
		}
		else
		{
			$items = $this -> getItems();

			for ($i=0, $c = count($items); $i < $c; $i++)
			{
				if ($items[$i] -> getId() == $item -> getId())
				{
					$query = "	UPDATE link_order_item
								SET quantity='".intval($quantity)."'
								WHERE id_order='".$this -> id."'
								AND id_item='".$item -> getId()."'";
					$res 	= $this -> db -> exec($query);

					if ($res)
					{
						$this -> items = array();
						return $this -> getItems();
					}
					else
					{
						throw new Exception('Database error');
					}
				}
			}
			$query 	= "	INSERT INTO link_order_item (id_order, id_item, quantity)
						VALUES('".$this -> id."', '".$item -> getId()."', '".intval($quantity)."')";
			$res 	= $this -> db -> exec($query);

			if ($res)
			{
				$this -> items = array();
				return $this -> getItems();
			}
			else
			{
				throw new Exception('Database error');
			}
		}
	}


	// Setters
	public function setUser(User $user)
	{
		$this -> id_user = $user -> getId();
		return true;
	}
	public function setAddressDelivery(Address $address)
	{
		$this -> id_delivery = $address -> getId();
		return true;
	}
	public function setAddressBilling(Address $address)
	{
		$this -> id_billing = $address -> getId();
		return true;
	}
	public function setStatus($status)
	{
		$this -> status = $status;
		return true;
	}
	public function setPrice($price)
	{
		if (ctype_digit($price))
		{
			$this -> price = $price;
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");
		}
	}
	public function setDateUpdate($dateUpdate)
	{
		$this -> dateUpdate = $dateUpdate;
		return true;
	}
	public function setDatePay($datePay)
	{
		$this -> datePay = $datePay;
		return true;
	}
	public function setDateSend($dateSend)
	{
		$this -> dateSend = $dateSend;
		return true;
	}
	public function setDateReception($dateReception)
	{
		$this -> dateReception = $dateReception;
		return true;
	}
}
?>