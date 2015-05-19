<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserRepository")
 */
class User  implements UserInterface, \Serializable
{

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="user_id_seq")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100, unique=true, nullable=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=64, nullable=true)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=200, unique=true, nullable=false)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	private $email;


	public function __construct()
	{

	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getSalt()
	{
		// bcrypt so no salt
		return null;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getRoles()
	{
		return array('ROLE_USER');
	}

	public function eraseCredentials()
	{
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}




	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->username,
			$this->password,
		));
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->username,
			$this->password,
			) = unserialize($serialized);
	}

}
