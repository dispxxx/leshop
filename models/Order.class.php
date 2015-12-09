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
<<<<<<< HEAD
	private $items = array();
	private $db;


=======
	private $items;
	private $db;


>>>>>>> origin/master
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
<<<<<<< HEAD
		if(empty($this -> items))
=======
		if(!$this -> items)
>>>>>>> origin/master
		{
			$query = '	SELECT item.*,quantity
						FROM link_order_item
						LEFT JOIN item
						ON item.id=link_order_item.id_item
<<<<<<< HEAD
						WHERE id_order= '.$this -> id;
=======
						WHERE $id_order= '.$this -> id;
>>>>>>> origin/master

			$res = $this -> db -> query($query);

			if ($res)
<<<<<<< HEAD
			{
				$items = $res -> fetchAll(PDO::FETCH_CLASS, "Item", array($this -> db));

				if ($items)
				{
					$i = 0;
					$len = count($items);
					while ($i < $len)
					{
						$this->items[] = array('item'=>$items[$i], 'quantity'=>$items[$i]->quantity);
						$i++;
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

	public function updateItem(Item $item, $quantity)
	{
		if ($quantity <= 0)
		{
			$query = "DELETE FROM link_order_item WHERE id_order='".$this->id."' AND id_item='".$item->getId()."'";
			//
			$this->items = array();
			return $this->getItems();
		}
		else
		{
			$list = $this->getItems();
			$i = 0;
			$len = count($list);
			while ($i < $len)
			{
				if ($list[$i]->getId() == $item->getId())
				{
					$query = "UPDATE link_order_item SET quantity='".intval($quantity)."' WHERE id_order='".$this->id."' AND id_item='".$item->getId()."'";
					// $db->exec
					$this->items = array();
					return $this->getItems();
				}
				$i++;
			}
			$query = "INSERT INTO link_order_item (id_order, id_item, quantity) VALUES('".$this->id."', '".$item->getId()."', '".intval($quantity)."')";
			// $db->exec
			$this->items = array();
			return $this->getItems();
=======
			{
				$items = $res -> fetchAll(PDO::FETCH_CLASS, "Item", array($this -> db));

				if ($items)
				{
					$this -> items = $items;
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
>>>>>>> origin/master
		}
		return $this -> items
	}
<<<<<<< HEAD
=======


>>>>>>> origin/master
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
?>