<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes build
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="user_in_project")
 * @ORM\Entity(repositoryClass="JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserInProjectRepository")
 *
 */
class UserInProject
{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 */
	private $user;


	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	private $project;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_owner", type="boolean", nullable=false)
	 */
	private $is_owner = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_admin", type="boolean", nullable=false)
	 */
	private $is_admin = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_write", type="boolean", nullable=false)
	 */
	private $is_write = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_read", type="boolean", nullable=false)
	 */
	private $is_read = false;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="is_accepted", type="boolean", nullable=false)
	 */
	private $is_accepted = false;

	/**
	 * @return boolean
	 */
	public function getIsAccepted()
	{
		return $this->is_accepted;
	}

	/**
	 * @param boolean $is_accepted
	 */
	public function setIsAccepted($is_accepted)
	{
		$this->is_accepted = $is_accepted;
	}

	/**
	 * @return boolean
	 */
	public function getIsAdmin()
	{
		return $this->is_admin;
	}

	/**
	 * @param boolean $is_admin
	 */
	public function setIsAdmin($is_admin)
	{
		$this->is_admin = $is_admin;
	}

	/**
	 * @return boolean
	 */
	public function getIsOwner()
	{
		return $this->is_owner;
	}

	/**
	 * @param boolean $is_owner
	 */
	public function setIsOwner($is_owner)
	{
		$this->is_owner = $is_owner;
	}

	/**
	 * @return boolean
	 */
	public function getIsRead()
	{
		return $this->is_read;
	}

	/**
	 * @param boolean $is_read
	 */
	public function setIsRead($is_read)
	{
		$this->is_read = $is_read;
	}

	/**
	 * @return boolean
	 */
	public function getIsWrite()
	{
		return $this->is_write;
	}

	/**
	 * @param boolean $is_write
	 */
	public function setIsWrite($is_write)
	{
		$this->is_write = $is_write;
	}

	/**
	 * @return mixed
	 */
	public function getProject()
	{
		return $this->project;
	}

	/**
	 * @param mixed $project
	 */
	public function setProject($project)
	{
		$this->project = $project;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}






}


