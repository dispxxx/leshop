<?php
class User
{
	private $id;
	private $login;
	private $password;
	private $email;
	private $avatar;
	private $date;
	private $last_date;

	public function getId()
	{
		return $this->id;
	}
	public function getLogin()
	{
		return $this->login;
	}
	public function getHash()
	{
		return $this->password;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getAvatar()
	{
		return $this->avatar;
	}
	public function getDate()
	{
		return $this->date;
	}
	public function getLastDate()
	{
		return $this->last_date;
	}

	public function setLogin($login)
	{
		if (strlen($login) > 3 && strlen($login) < 32)
		{
			$this->login = $login;
			return true;
		}
		else
		{
			return "Login incorrect";
		}
	}
	public function setEmail($email)
	{
		if (strlen($email) > 3 && strlen($email) < 52)
		{
			$this->email = $email;
			return true;
		}
		else
		{
			return "Email incorrect";
		}
	}
	public function editPassword($password1, $password2)
	{
		if (strlen($password) > 5)
		{
			if ($password1 == $password2)
			{
				$this->password = password_hash($password1, PASSWORD_BCRYPT, array("cost"=>10));
				return true;
			}
			else
			{
				return "Les mots de passe ne correspondent pas";
			}
		}
		else
		{
			return "Password trop court";
		}
	}
	public function setPassword($password1, $password2)
	{
		if (strlen($password1) > 5)
		{
			if ($password1 == $password2)
			{
				$this->password = password_hash($password1, PASSWORD_BCRYPT, array("cost"=>10));
				return true;
			}
		}
		else
		{
			return "Mot de passe trop court";
		}
	}
	public function verifPassword($password)
	{
		return (password_verify($password, $this->password));
	}
	public function setAvatar($avatar)
	{
		if (filter_var($avatar, FILTER_VALIDATE_URL))
		{
			$this->avatar = $avatar;
			return true;
		}
		else
		{
			return "URL incorrecte";
		}
	}
}

?>