<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project;
use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
abstract class DefaultProjectViewController extends Controller
{

	/** @var  Project */
	protected $project;


	protected function build($projectId, $permissionNeeded = ProjectVoter::READ) {
		$doctrine = $this->getDoctrine()->getManager();

		// load
		$projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
		$this->project = $projectRepo->findOneById($projectId);
		if (!$this->project) {
			return  new Response( '404' );
		}

		// permissions
		if (false === $this->get('security.context')->isGranted($permissionNeeded, $this->project)) {
			return  new Response( '403' );
		}

		return null;
	}


	/**
     * Get the common paramaters to pass to the views
     */
    public function getViewParameters($additionalParameters=array()) {
    	return array_merge( array(
				'project'=>$this->project,
				'isCurrentUserWriteProject'=>$this->get('security.context')->isGranted(ProjectVoter::WRITE, $this->project),
				'isCurrentUserAdminProject'=>$this->get('security.context')->isGranted(ProjectVoter::ADMIN, $this->project),
    		), $additionalParameters);
    }
    

}
