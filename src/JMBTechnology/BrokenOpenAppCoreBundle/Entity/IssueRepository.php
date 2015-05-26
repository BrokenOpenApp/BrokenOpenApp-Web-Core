<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/** *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class IssueRepository extends EntityRepository
{

	function getNextIssueNumberForProject(Project $project) {


		$query = " SELECT COUNT(i.id) AS iCount, MAX(i.number) AS iNumber ".
			" FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue i ".
			" WHERE i.project = :project " .
			" GROUP BY i.project " ;

		$datas = $this->getEntityManager()
			->createQuery($query)
			->setParameters(array('project'=>$project))->getResult();
		;

		$data = array_shift($datas);

		if ($data['iCount'] == 0) {
			return 1;
		} else {
			return $data['iNumber'] + 1;
		}
	}

}
