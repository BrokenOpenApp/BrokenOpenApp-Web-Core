<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Form\Model;


use Symfony\Component\Validator\Constraints as Assert;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\User;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserRegistration
{
	/**
	 * @Assert\Type(type="JMBTechnology\BrokenOpenAppCoreBundle\Entity\User")
	 * @Assert\Valid()
	 */
	protected $user;

	/**
	 * @Assert\NotBlank()
	 * @Assert\True()
	 */
	protected $termsAccepted;

	public function setUser(User $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getTermsAccepted()
	{
		return $this->termsAccepted;
	}

	public function setTermsAccepted($termsAccepted)
	{
		$this->termsAccepted = (Boolean) $termsAccepted;
	}
}

