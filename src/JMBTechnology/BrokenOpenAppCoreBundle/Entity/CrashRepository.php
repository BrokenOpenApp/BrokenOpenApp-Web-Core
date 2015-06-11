<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CrashRepository
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class CrashRepository extends EntityRepository
{

	/**
	 *
	 */
	public function newAllApplicationsQuery() {
    	$query = "SELECT DISTINCT c.packageName as packageName "
        			. "FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c "
        			. "ORDER BY c.packageName ASC ";

        return $this->getEntityManager()
        		->createQuery($query);
	}

	/**
	 * Get the latest issues (crashes that are supposed to be similar)
	 *
	 * 
	 * @return
	 */
    public function newLatestIssuesQuery(Project $project, $packageName=null)
    {
    	$where = "  i.project =:project ";
    	$params = array(  'project'=>$project);
    	
    	if ($packageName!=null) {
    		$where .= 'AND c.packageName=:packageName ';
    		$params['packageName'] = $packageName;
    	}

		$query = " SELECT i.fingerprint AS fingerprint ,".
            " i.title AS title, ".
			" i.number AS issueNumber, " .
			" COUNT (c.id) AS crashNum,".
			" MAX(c.userCrashDate) as latestCrashDate ".
			" FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c ".
			" JOIN c.issue i ".
			" WHERE ". $where .
			"GROUP BY i.id ".
			"ORDER BY latestCrashDate DESC ";

    	return $this->getEntityManager()
		    	->createQuery($query)
		    	->setParameters($params);   
    }


    public function newCrashesToProcessQuery()
    {

		$query = " SELECT c.id AS id ".
			" FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c ".
			" WHERE c.issue IS NULL AND c.stackTrace IS NOT NULL " .
			"ORDER BY c.createdAt ASC " ;

    	return $this->getEntityManager()
		    	->createQuery($query)
		    	->setParameters(array());
    }
}
