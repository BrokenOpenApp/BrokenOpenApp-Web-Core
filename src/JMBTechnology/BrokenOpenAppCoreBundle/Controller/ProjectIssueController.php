<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\IssueHistoryTitle;
use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\IssueEditTitleFormType;
use Symfony\Component\HttpFoundation\Response;
use JMBTechnology\BrokenOpenAppCoreBundle\Security\Authorization\Voter\ProjectVoter;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectIssueController extends DefaultProjectViewController
{


	/** @var  Issue */
    protected $issue;


    protected function buildIssue($projectId, $issueId, $permissionNeeded = ProjectVoter::READ)
    {
		$r = $this->build($projectId, $permissionNeeded);
		if ($r) {
			return $r;
		}

        $doctrine = $this->getDoctrine()->getManager();

		// load
        $issueRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Issue');
        $this->issue = $issueRepo->findOneBy(array('project' => $this->project, 'number' => $issueId));
        if (!$this->issue) {
            return new Response('404');
        }

		return null;
    }

    /**
     * Render the dashboard for a particular app
     */
    public function indexAction($projectId, $issueId)
    {
        $doctrine = $this->getDoctrine()->getManager();


        // project & issue
        $return = $this->buildIssue($projectId, $issueId);
        if ($return) {
            return $return;
        }

        // Dashboard
        $crashRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash');
        $crashes = $crashRepo->findBy(array('issue'=>$this->issue), array('createdAt'=>'DESC'),100);

        return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectIssue:index.html.twig', $this->getViewParameters(
            array(
                'issue' => $this->issue,
                'crashes' => $crashes
            )));
    }

    public function editTitleAction($projectId, $issueId)
    {
        $doctrine = $this->getDoctrine()->getManager();


        // project & issue
        $return = $this->buildIssue($projectId, $issueId, ProjectVoter::WRITE);
        if ($return) {
            return $return;
        }

        // edit title
        $form = $this->createForm(new IssueEditTitleFormType(), $this->issue);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($this->issue);

				$issueHistory = new IssueHistoryTitle();
				$issueHistory->setTitle($this->issue->getTitle());
				$issueHistory->setIssue($this->issue);
				$issueHistory->setUser($this->getUser());
				$em->persist($issueHistory);

                $em->flush();
                return $this->redirect($this->generateUrl('_project_issue_index', array('projectId'=>$this->project->getId(), 'issueId'=>$this->issue->getNumber())));
            }
        }


        return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectIssue:editTitle.html.twig', $this->getViewParameters(array(
            'issue' => $this->issue,
            'form' => $form->createView(),
        )));


    }

}


