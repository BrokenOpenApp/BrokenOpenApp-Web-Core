<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserRepository extends EntityRepository
{


	public function usersToNotifyOnNewIssue(Project $project)
	{

		$query = " SELECT u.id AS id ".
			" FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\User u ".
			" JOIN JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserInProject uip WITH uip.project = :project AND uip.user = u".
			" WHERE  (u.is_super_admin = '1' OR u.is_all_projects_read = '1' OR u.is_all_projects_write = '1' OR ((uip.is_owner = '1' OR uip.is_admin = '1' OR uip.is_write = '1' OR uip.is_read = '1') AND uip.is_accepted = '1'))  " .
			" AND uip.is_send_notification_on_new_issue = '1'".
			" " ;

		return $this->getEntityManager()
			->createQuery($query)
			->setParameters(array('project'=>$project));
	}

}
