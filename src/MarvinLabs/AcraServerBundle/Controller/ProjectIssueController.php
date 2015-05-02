<?php

namespace MarvinLabs\AcraServerBundle\Controller;


use MarvinLabs\AcraServerBundle\Form\Type\IssueEditTitleFormType;
use Symfony\Component\HttpFoundation\Response;


class ProjectIssueController extends DefaultViewController
{


    protected $project;

    protected $issue;


    protected function build($projectId, $issueId)
    {
        $doctrine = $this->getDoctrine()->getManager();

        $projectRepo = $doctrine->getRepository('MLabsAcraServerBundle:Project');
        $this->project = $projectRepo->findOneById($projectId);
        if (!$this->project) {
            return new Response('404');
        }

        $issueRepo = $doctrine->getRepository('MLabsAcraServerBundle:Issue');
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
        $crashRepo = $doctrine->getRepository('MLabsAcraServerBundle:Crash');
        $crashes = $crashRepo->newIssueCrashesQuery($this->project, $this->issue->getIssueId())->setMaxResults(15)->getResult();

        return $this->render('MLabsAcraServerBundle:ProjectIssue:index.html.twig', $this->getViewParameters(
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


        return $this->render('MLabsAcraServerBundle:ProjectIssue:editTitle.html.twig', array(
            'project' => $this->project,
            'issue' => $this->issue,
            'form' => $form->createView(),
        ));


    }

}


