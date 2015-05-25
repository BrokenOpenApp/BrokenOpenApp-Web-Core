<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User  implements AdvancedUserInterface, \Serializable
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
	 * @var boolean
	 *
	 * @ORM\Column(name="is_super_admin", type="boolean", nullable=false)
	 */
	private $is_super_admin = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_create_project", type="boolean", nullable=false)
	 */
	private $is_create_project = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_locked", type="boolean", nullable=false)
	 */
	private $is_locked = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_all_projects_read", type="boolean", nullable=false)
	 */
	private $is_all_projects_read = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_all_projects_write", type="boolean", nullable=false)
	 */
	private $is_all_projects_write = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_all_projects_admin", type="boolean", nullable=false)
	 */
	private $is_all_projects_admin = false;

	/**
	 * @var datetime $createdAt
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;


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
	 * @return boolean
	 */
	public function getIsCreateProject()
	{
		return $this->is_create_project;
	}

	/**
	 * @param boolean $is_create_project
	 */
	public function setIsCreateProject($is_create_project)
	{
		$this->is_create_project = $is_create_project;
	}

	/**
	 * @return boolean
	 */
	public function getIsSuperAdmin()
	{
		return $this->is_super_admin;
	}

	/**
	 * @param boolean $is_super_admin
	 */
	public function setIsSuperAdmin($is_super_admin)
	{
		$this->is_super_admin = $is_super_admin;
	}

	/**
	 * @return boolean
	 */
	public function getIsLocked()
	{
		return $this->is_locked;
	}

	/**
	 * @param boolean $is_locked
	 */
	public function setIsLocked($is_locked)
	{
		$this->is_locked = $is_locked;
	}

	/**
	 * @return boolean
	 */
	public function isIsAllProjectsAdmin()
	{
		return $this->is_all_projects_admin;
	}

	/**
	 * @param boolean $is_all_projects_admin
	 */
	public function setIsAllProjectsAdmin($is_all_projects_admin)
	{
		$this->is_all_projects_admin = $is_all_projects_admin;
	}

	/**
	 * @return boolean
	 */
	public function isIsAllProjectsRead()
	{
		return $this->is_all_projects_read;
	}

	/**
	 * @param boolean $is_all_projects_read
	 */
	public function setIsAllProjectsRead($is_all_projects_read)
	{
		$this->is_all_projects_read = $is_all_projects_read;
	}

	/**
	 * @return boolean
	 */
	public function isIsAllProjectsWrite()
	{
		return $this->is_all_projects_write;
	}

	/**
	 * @param boolean $is_all_projects_write
	 */
	public function setIsAllProjectsWrite($is_all_projects_write)
	{
		$this->is_all_projects_write = $is_all_projects_write;
	}

	/**
	 * @return datetime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param datetime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
	}




	/** @see \Serializable::serialize() */
	public function serialize()
	{
		return serialize(array(
			$this->id,
			$this->email,
			$this->password,
			$this->is_create_project,
			$this->is_super_admin,
			$this->is_locked,
			$this->is_all_projects_read,
			$this->is_all_projects_write,
			$this->is_all_projects_admin
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
			$this->is_super_admin,
			$this->is_locked,
			$this->is_all_projects_read,
			$this->is_all_projects_write,
			$this->is_all_projects_admin
			) = unserialize($serialized);
	}

	/**
	 * Checks whether the user's account has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw an AccountExpiredException and prevent login.
	 *
	 * @return bool true if the user's account is non expired, false otherwise
	 *
	 * @see AccountExpiredException
	 */
	public function isAccountNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is locked.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a LockedException and prevent login.
	 *
	 * @return bool true if the user is not locked, false otherwise
	 *
	 * @see LockedException
	 */
	public function isAccountNonLocked()
	{
		return !$this->is_locked;
	}

	/**
	 * Checks whether the user's credentials (password) has expired.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a CredentialsExpiredException and prevent login.
	 *
	 * @return bool true if the user's credentials are non expired, false otherwise
	 *
	 * @see CredentialsExpiredException
	 */
	public function isCredentialsNonExpired()
	{
		return true;
	}

	/**
	 * Checks whether the user is enabled.
	 *
	 * Internally, if this method returns false, the authentication system
	 * will throw a DisabledException and prevent login.
	 *
	 * @return bool true if the user is enabled, false otherwise
	 *
	 * @see DisabledException
	 */
	public function isEnabled()
	{
		return true;
	}

	/**
	 * @ORM\PrePersist()
	 */
	public function beforeFirstSave() {
		$this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
	}


}
