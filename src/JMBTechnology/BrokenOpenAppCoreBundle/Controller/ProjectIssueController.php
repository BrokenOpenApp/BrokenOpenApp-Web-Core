<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;


use JMBTechnology\BrokenOpenAppCoreBundle\Form\Type\IssueEditTitleFormType;
use Symfony\Component\HttpFoundation\Response;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class ProjectIssueController extends DefaultViewController
{


    protected $project;

    protected $issue;


    protected function build($projectId, $issueId)
    {
        $doctrine = $this->getDoctrine()->getManager();

        $projectRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Project');
        $this->project = $projectRepo->findOneById($projectId);
        if (!$this->project) {
            return new Response('404');
        }

        $issueRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Issue');
        $this->issue = $issueRepo->findOneBy(array('project' => $this->project, 'issueId' => $issueId));
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
        $return = $this->build($projectId, $issueId);
        if ($return) {
            return $return;
        }

        // Dashboard
        $crashRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash');
        $crashes = $crashRepo->newIssueCrashesQuery($this->project, $this->issue->getIssueId())->setMaxResults(15)->getResult();

        return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectIssue:index.html.twig', $this->getViewParameters(
            array(
                'project' => $this->project,
                'issue' => $this->issue,
                'crashes' => $crashes
            )));
    }

    public function editTitleAction($projectId, $issueId)
    {
        $doctrine = $this->getDoctrine()->getManager();


        // project & issue
        $return = $this->build($projectId, $issueId);
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
                $em->flush();
                return $this->redirect($this->generateUrl('_project_issue_index', array('projectId'=>$this->project->getId(), 'issueId'=>$this->issue->getIssueId())));
            }
        }


        return $this->render('JMBTechnologyBrokenOpenAppCoreBundle:ProjectIssue:editTitle.html.twig', array(
            'project' => $this->project,
            'issue' => $this->issue,
            'form' => $form->createView(),
        ));


    }

}


