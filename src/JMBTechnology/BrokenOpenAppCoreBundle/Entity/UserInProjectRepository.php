<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class UserInProjectRepository extends EntityRepository
{

	/**
	 * Get the latest issues (crashes that are supposed to be similar)
	 *
	 * @param string $packageName A package name to get only for this particular app or null
	 * @param number $limit The max number of issues to return (-1 for all)
	 *
	 * @return array
	 */
	public function getForProject(Project $project)
	{

		$query = " SELECT u.id AS id, ".
			" u.email AS email, ".
			" uip.is_write AS write, ".
			" uip.is_admin AS admin, ".
			" uip.is_accepted AS accepted ".
			" FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserInProject uip ".
			" JOIN uip.user u ".
			" WHERE (uip.is_read = '1' OR uip.is_write = '1'  OR uip.is_admin = '1'  )  AND uip.project = :project " .
			" ORDER BY u.email ASC " ;

		return $this->getEntityManager()
			->createQuery($query)
			->setParameters(array('project'=>$project));
	}


}
