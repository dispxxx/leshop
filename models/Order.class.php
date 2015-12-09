<?php 
class Order
{
	private $db;
	private $id;
	private $id_user;
	private $user;
	private $id_delivery;
	private $id_billing;
	private $address;
	private $status;
	private $price;
	private $date_update;
	private $date_pay;
	private $date_send;
	private $date_recption;
	private $item_list;

	public function __construct($db)
	{
		$this->db = $db;
	}
				/*GETER*/
	public function getId()
	{
		return $this->id;
	}
	public function getUser()
	{
		return $this->user;
	}
	public function getAdress()
	{
		return $this->adress;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getPrice()
	{
		return $this->price;
	}
	public function getDatePay()
	{
		return $this->datePay;
	}
	public function getDateSend()
	{
		return $this->dateSend;
	}
	public function getDateReception()
	{
		return $this->dateReception;
	}
	public function getItemList()
	{
		if(!$this->item_list)
		{
			$this->item_list = array();
			$query = "SELECT item.*,quantity FROM link_order_item LEFT JOIN item ON item.id=link_order_item.id_item  WHERE $id_order= '".$this->id."'";
			$res = $this->db->query($query);
			$list = $res->fetchAll(PDO::FETCH_CLASS, "Item", array($this->db));
			$i = 0;
			$max = count($list);
			while ($i < $max)
			{
				$this->item_list[] = array ('item'=>$list[$i], 'quantity'=$list[$i]->quantity);
				$i++;
			}
			return $this->item_list;
			
		}
	}

					/*	SETER*/
	public function setUser(Category $user)
	{
		$this->user = $user;
		$this->id_user = $user->getId();
		return true;
	}
	public function setAddressDelivery(Address $address)
	{
		$this->address = $address;
		$this->id_delivery = $address->getId();
		return true;
	}
	public function setAddressBilling(Address $address)
	{
		$this->address = $address;
		$this->id_billing = $address->getId();
		return true;
	}
	public function setStatus($status)
	{
		$this->status = $status;
		return true;
	}
	public function setPrice($price)
	{
		if (ctype_digit($price))
		{
			$this->price = $price;	
			return true;
		}
		else
		{
			throw new Exception("vous devez rentrer un nombre");		
		}
	}
	public function setDateUpdate($dateUpdate)
	{
		$this->dateUpdate = $dateUpdate;
		return true;
	}
	public function setDatePay($datePay)
	{
		$this->datePay = $datePay;
		return true;
	}
	public function setDateSend($dateSend)
	{
		$this->dateSend = $dateSend;
		return true;
	}
	public function setDateReception($dateReception)
	{
		$this->dateReception = $dateReception;
		return true;
	}
	public function addItem(Item $item, $quantity)
	{
		/*var_dump($this);*/
		// $this->item_list 3
		$idItem = $item->getId();
		$idOrder = $this->getId();
		$quantity = intval($quantity);
		$price = ($item->getPrice())*$quantity;
		$this->item_list[] = array('quantity'=>$quantity,'price'=>$price,'item'=>$item);
		$query = "INSERT INTO link_order_item (id_order, id_item, quantity, price) VALUES('".$idItem."','".$idOrder."', '".$quantity."', '".$price."')";
		$res =  $this->db->exec($query);
		if($res)
		{
			$id = $this->db->lastInsertId();
			if($id)
			{
				return $this->findByID($id);
			}
			else
			{
				return "Internal server Error";
			}
		}
		/*var_dump($this);*/
		// $this->item_list 4
	}
	public function updateItem(Item $item, $quantity)
	{
		if()
			obj dans panier
			if qqt=0 ->supr
		$idItem = $item->getId();
		$idOrder = $this->getId();
		$quantity = intval($quantity);
		$price = ($item->getPrice())*$quantity;
		/*marche pas*/
		if
		$this->item_list[] = array('quantity'=>$quantity,'price'=>$price,'item'=>$item);
		$query = "UPDATE link_order_item (id_order, id_item, quantity, price) VALUES('".$idItem."','".$idOrder."', '".$quantity."', '".$price."')";
		$res =  $this->db->exec($query);
		if($res)
		{
			$id = $this->db->lastInsertId();
			if($id)
			{
				return $this->findByID($id);
			}
			else
			{
				return "Internal server Error";
			}
		}
	}
}


 ?>