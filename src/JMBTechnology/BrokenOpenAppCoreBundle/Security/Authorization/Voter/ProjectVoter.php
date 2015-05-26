<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter;


use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectVoter implements  VoterInterface
{

	/**
	 *
	 */
	protected $em;

	public function __construct($entityManager)
	{
		$this->em = $entityManager;
	}

	const READ = "readProject";
	const WRITE = "writeProject";
	const ADMIN = "adminProject";
	const OWNER = "ownerProject";


	public function supportsAttribute($attribute)
	{
		return in_array($attribute, array(
			self::READ,
			self::WRITE,
			self::ADMIN,
			self::OWNER,
		));
	}

	public function supportsClass($class)
	{
		$supportedClass = 'JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project';

		return $supportedClass === $class || is_subclass_of($class, $supportedClass);
	}


	/**
	 * @var \JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project $project
	 */
	public function vote(TokenInterface $token, $project, array $attributes)
	{
		// check if class of this object is supported by this voter
		if (!$this->supportsClass(get_class($project))) {
			return VoterInterface::ACCESS_ABSTAIN;
		}

		// check if the voter is used correct, only allow one attribute
		// this isn't a requirement, it's just one easy way for you to
		// design your voter
		if (1 !== count($attributes)) {
			throw new \InvalidArgumentException(
				'Only one attribute is allowed for VIEW or EDIT'
			);
		}

		// set the attribute to check against
		$attribute = $attributes[0];

		// check if the given attribute is covered by this voter
		if (!$this->supportsAttribute($attribute)) {
			return VoterInterface::ACCESS_ABSTAIN;
		}

		// get current logged in user
		$user = $token->getUser();

		// make sure there is a user object (i.e. that the user is logged in)
		if (!$user instanceof UserInterface) {
			return VoterInterface::ACCESS_DENIED;
		}


		// does user have any general rights?
		switch($attribute) {
			case self::READ:
				if ($user->getIsSuperAdmin() || $user->isIsAllProjectsAdmin() || $user->isIsAllProjectsWrite() || $user->isIsAllProjectsRead()  ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::WRITE:
				if ($user->getIsSuperAdmin() || $user->isIsAllProjectsAdmin() || $user->isIsAllProjectsWrite()  ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::ADMIN:
				if ($user->getIsSuperAdmin() || $user->isIsAllProjectsAdmin()  ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::OWNER:
				if ($user->getIsSuperAdmin() ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;
		}

		// Does user have any rights in project
		$userInProject = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:UserInProject')
			->findOneBy(array('project'=>$project,'user'=>$user));

		if (!$userInProject) {
			return VoterInterface::ACCESS_DENIED;
		}

		switch($attribute) {
			case self::READ:
				if ($userInProject->getIsOwner() || ( ( $userInProject->getIsAdmin() || $userInProject->getIsWrite() || $userInProject->getIsRead()  ) && $userInProject->getIsAccepted() ) ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::WRITE:
				if ($userInProject->getIsOwner() || ( ( $userInProject->getIsAdmin() || $userInProject->getIsWrite()  ) && $userInProject->getIsAccepted() ) ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::ADMIN:
				if ($userInProject->getIsOwner() || ( $userInProject->getIsAdmin() && $userInProject->getIsAccepted() ) ) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;

			case self::OWNER:
				if ($userInProject->getIsOwner()) {
					return VoterInterface::ACCESS_GRANTED;
				}
				break;
		}

		return VoterInterface::ACCESS_DENIED;
	}

}


