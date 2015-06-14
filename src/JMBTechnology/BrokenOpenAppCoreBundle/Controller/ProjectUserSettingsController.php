<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\UserInProject;
use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectUserSettingsController extends DefaultProjectViewController
{


	/**
	 *
	 */
	public function indexAction($projectId)
	{

		// project
		$return = $this->build($projectId, ProjectVoter::READ);
		if ($return) {
			return $return;
		}


		$doctrine = $this->getDoctrine()->getManager();

		$uipRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:UserInProject');
		$uip = $uipRepo->findOneBy(array('project'=>$this->project,'user'=>$this->getUser()));

		if (!$uip) {
			// This might happen if the user is geven rights to all projects
			$uip = new UserInProject();
			$uip->setUser($this->getUser());
			$uip->setProject($this->project);
			// in this case, they don't get any emails so the default for this is false
			$uip->setIsSendNotificationOnNewIssue(false);
		}

		if ($this->getRequest()->getMethod() == 'POST') {
			if ($this->getRequest()->request->get('action') == 'setIsSendNotificationOnNewIssueOff') {
				$uip->setIsSendNotificationOnNewIssue(false);
				$doctrine->persist($uip);
				$doctrine->flush();
			} else if ($this->getRequest()->request->get('action') == 'setIsSendNotificationOnNewIssueOn') {
				$uip->setIsSendNotificationOnNewIssue(true);
				$doctrine->persist($uip);
				$doctrine->flush();
			}
		}


		return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectUserSettings:index.html.twig', $this->getViewParameters(array(
			'userInProject'=>$uip,
		)));

	}





}

