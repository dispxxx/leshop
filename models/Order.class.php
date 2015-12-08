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
	public function addLinkOrderItem(Item $item, Order $order)
	{
		$idItem = $order->getItem->getId()->
	}
}


 ?>