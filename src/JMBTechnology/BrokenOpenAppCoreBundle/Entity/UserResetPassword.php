<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Crashes build
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="user_reset_password")
 * @ORM\Entity()
 *
 */
class UserResetPassword
{


	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
	 * @Assert\NotBlank()
	 */
	private $user;

	/**
	 * @var string
	 *
	 * @ORM\Id
	 * @ORM\Column(name="key", type="string", length=250, nullable=false)
	 * @Assert\NotBlank()
	 */
	private $key;

	/**
	 * @var datetime $createdAt
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 * @Assert\NotBlank()
	 */
	private $createdAt;


	/**
	 * @var datetime $createdAt
	 *
	 * @ORM\Column(name="reset_at", type="datetime", nullable=true)
	 */
	private $resetAt;

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

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @return datetime
	 */
	public function getResetAt()
	{
		return $this->resetAt;
	}

	/**
	 * @param datetime $resetAt
	 */
	public function setResetAt($resetAt)
	{
		$this->resetAt = $resetAt;
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
