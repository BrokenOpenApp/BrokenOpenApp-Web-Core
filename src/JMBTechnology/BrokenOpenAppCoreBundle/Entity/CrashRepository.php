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
	 * Get the number of issues per application
	 */
	public function newAllApplicationsQuery() {    	
    	$query = "SELECT DISTINCT c.packageName as packageName "
        			. "FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c "
        			. "ORDER BY c.packageName ASC ";
    	    	
        return $this->getEntityManager()
        		->createQuery($query);
	}
	
	/**
	 * Get the issue details 
	 *  
	 * @param string $issueFingerPrint
	 * 
	 * @return array
	 */
    public function newIssueDetailsQuery(Project $project, $issueFingerPrint)
    {
    	$where = " c.project = :project ";
    	$params = array('project'=>$project);
    	
    	if ($issueFingerPrint!=null) {
    		$where .= 'AND c.fingerprint=:fingerprint ';
    		$params['fingerprint'] = $issueFingerPrint;
    	}
    	
    	$query = "SELECT c.issueFingerPrint as issueFingerPrint, "
        				. "COUNT(c.id) as crashNum, "
        				. "MAX(c.userCrashDate) as latestCrashDate "
        			. "FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c "
        			. "WHERE " . $where 
        			. "GROUP BY c.issueId "
        			. "ORDER BY latestCrashDate DESC ";
    	    	
        return $this->getEntityManager()
        		->createQuery($query)
        		->setParameters($params);
    }
	
	/**
	 * Get the issue details 
	 *  
	 * @param String $issueFingerPrint
	 * 
	 * @return array
	 */
    public function newIssueCrashesQuery(Project $project, $issueFingerPrint)
    {
    	$where = " c.project = :project ";
    	$params = array('project'=>$project);
    	
    	if ($issueFingerPrint!=null) {
    		$where .= 'AND i.fingerprint=:fingerprint ';
    		$params['fingerprint'] = $issueFingerPrint;
    	}
    	
    	$query = "SELECT c "
        			. "FROM JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash c "
					. " JOIN c.issue i "
        			. "WHERE " . $where 
        			. "ORDER BY c.userCrashDate DESC ";
    	    	
        return $this->getEntityManager()
        		->createQuery($query)
        		->setParameters($params);     
    }
	
	/**
	 * Get the latest issues (crashes that are supposed to be similar)
	 *  
	 * @param string $packageName A package name to get only for this particular app or null
	 * @param number $limit The max number of issues to return (-1 for all)
	 * 
	 * @return array
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


	/**
	 * Get the latest issues (crashes that are supposed to be similar)
	 *
	 * @param string $packageName A package name to get only for this particular app or null
	 * @param number $limit The max number of issues to return (-1 for all)
	 *
	 * @return array
	 */
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
