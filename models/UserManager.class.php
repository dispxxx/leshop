<?php
class UserManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function create($login, $password1, $password2, $email, $avatar)
	{
		$errors = array();
		$user = new User();
		$errors[] = $user->setLogin($login);
		$errors[] = $user->setPassword($password1, $password2);
		$errors[] = $user->setEmail($email);
		$errors[] = $user->setAvatar($avatar);
		$errors = array_filter($errors, function($val)
		{
			return $val !== true;
		});
		if (count($errors) == 0)
		{
			$login = mysqli_real_escape_string($this->db, $user->getLogin());
			$email = mysqli_real_escape_string($this->db, $user->getEmail());
			$password = $user->getHash();
			$avatar = mysqli_real_escape_string($this->db, $user->getAvatar());
			$query = "INSERT INTO user (login, password, email, avatar) VALUES('".$login."', '".$password."', '".$email."', '".$avatar."')";
			$res = mysqli_query($this->db, $query);
			if ($res)
			{
				$id = mysqli_insert_id($this->db);
				if ($id)
				{
					return $this->findById($id);
				}
				else
				{
					return "Internal server error";
				}
			}
			else
			{
				return mysqli_error($this->db);
			}
		}
		else
		{
			return $errors;
		}
	}
	public function delete(User $user)
	{
		$id = $user->getId();
		$query = "DELETE FROM user WHERE id='".$id."'";
		$res = mysqli_query($this->db, $query);
		if ($res)
		{
			return true;
		}
		else
		{
			return "Internal Server Error";
		}
	}
	public function update(User $user)
	{
		$id = $user->getId();
		$login = mysqli_real_escape_string($this->db, $user->getLogin());
		$password = mysqli_real_escape_string($this->db, $user->getHash());
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$avatar = mysqli_real_escape_string($this->db, $user->getAvatar());
		/*/!\*/$query = "UPDATE user SET login='".$login."', password='".$password."', email='".$email."', avatar='".$avatar."' WHERE id='".$id."'";
		$res = mysqli_query($this->db, $query);
		if ($res)
		{
			return $this->findById($id);
		}
		else
		{
			return "Internal Server Error";
		}
	}
	public function find($id)
	{
		return $this->findById($id);
	}
	public function findById($id)
	{
		$id = intval($id);
		$query = "SELECT * FROM user WHERE id='".$id."'";
		$res = mysqli_query($this->db, $query);
		if ($res)
		{
			$user = mysqli_fetch_object($res, "User");
			if ($user)
			{
				return $user;
			}
			else
			{
				return "User not found";
			}
		}
		else
		{
			return "Internal Server Error";
		}
	}
	public function getLast()
	{
		$query = "SELECT * FROM user WHERE (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(last))<3 ORDER BY login";
		$res = mysqli_query($this->db, $query);
		$listUser = array();
		while ($user = mysqli_fetch_object($res, 'User'))
		{
			$listUser[] = $user;
		}
		return $listUser;
	}
	public function getLastDate()
	{
		if(isset($_SESSION['login']))
		{
			$mysql_last_date = mysqli_query("SELECT last_date FROM user WHERE login=".$_SESSION['login']);
			$reponse_date = mysqli_fetch_assoc($mysql_last_date);
			$_SESSION["last_date"] = $reponse_date["last_date"];
			mysqli_query("UPDATE user SET last_date='".date("U")."' WHERE login=".$_SESSION['login']);
		}
	}
	public function findByLogin($login)
	{
		if (strlen(trim($login)) > 0)
		{
			$login = mysqli_real_escape_string($this->db, $login);
			$query = "SELECT * FROM user WHERE login='".$login."'";
			$res = mysqli_query($this->db, $query);
			if ($res)
			{
				$user = mysqli_fetch_object($res, "User");
				if ($user) {
					return $user;
				}
				else
					return "User not found";
			}
			else
			{
				return "Internal Server Error";
			}
		}
		else
		{
			return "User not found";
		}
	}
	public function getCurrent()
	{
		if (isset($_SESSION['id']))
		{
			$query = "SELECT * FROM user WHERE id='".$_SESSION['id']."'";
			$res = mysqli_query($this->db, $query);
			if ($res)
			{
				$user = mysqli_fetch_object($res, "User");
				if ($user)
				{
					return $user;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	public function getNbPost($id)
	{
		$postManager = new PostManager($this->db);
		$postList = $postManager->findByIdAuthor($id);
		if ($postList)
		{
			if (is_string($postList))
			{
				$errors[] = $postList;
				return $errors;
			}
			else
			{
				$postNb = count($postList);
				if ( $postNb == NULL )
				{
					$postNb = 0;
					return $postNb;
				}
				else
				{
					return $postNb;
				}
			}
		}
		else
		{
			return "Pas de messages postés";
		}

	}
}
?>