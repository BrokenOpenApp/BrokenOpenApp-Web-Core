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
	 * @ORM\Column(type="string", length=64, nullable=true)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=200, unique=true, nullable=false)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_super_admin", type="boolean", nullable=false)
	 */
	private $is_super_admin = false;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="is_create_project", type="boolean", nullable=false)
	 */
	private $is_create_project = false;

	public function __construct()
	{

	}

	public function getUsername()
	{
		return $this->email;
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
		$roles = array('ROLE_USER');
		if ($this->is_create_project) { $roles[] = 'ROLE_CREATE_PROJECT'; }
		if ($this->is_super_admin) { $roles[] = 'ROLE_SUPER_ADMIN'; }
		return $roles;
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
	 * @return string
	 */
	public function getIsCreateProject()
	{
		return $this->is_create_project;
	}

	/**
	 * @param string $is_create_project
	 */
	public function setIsCreateProject($is_create_project)
	{
		$this->is_create_project = $is_create_project;
	}

	/**
	 * @return string
	 */
	public function getIsSuperAdmin()
	{
		return $this->is_super_admin;
	}

	/**
	 * @param string $is_super_admin
	 */
	public function setIsSuperAdmin($is_super_admin)
	{
		$this->is_super_admin = $is_super_admin;
	}




	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->email,
			$this->password,
			$this->is_create_project,
			$this->is_super_admin
		));
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized)
	{
		list (
			$this->id,
			$this->email,
			$this->password,
			$this->is_create_project,
			$this->is_super_admin
			) = unserialize($serialized);
	}

}
