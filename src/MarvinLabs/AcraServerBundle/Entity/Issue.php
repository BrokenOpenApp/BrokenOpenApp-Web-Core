<?php

namespace MarvinLabs\AcraServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 *
 * @ORM\Table(name="acra_issue")
 * @ORM\Entity(repositoryClass="MarvinLabs\AcraServerBundle\Entity\IssueRepository")
 */
class Issue
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="bigint", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="acra_issue_id_seq")
	 */
	private $id;


	/**
	 *
	 * @ORM\ManyToOne(targetEntity="MarvinLabs\AcraServerBundle\Entity\Project")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	private $project;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="issue_id", type="string", length=32, nullable=false)
	 */
	private $issueId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=250, nullable=true)
     *
     * Should really be nullable=false later but for now we have old data TODO
     *
     */
    private $title;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getProject()
	{
		return $this->project;
	}

	/**
	 * @param mixed $project
	 */
	public function setProject($project)
	{
		$this->project = $project;
	}



	/**
	 * @return string
	 */
	public function getIssueId()
	{
		return $this->issueId;
	}

	/**
	 * @param string $issueId
	 */
	public function setIssueId($issueId)
	{
		$this->issueId = $issueId;
	}

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $title
     */
    public function setTitleFromCrash(Crash $crash)
    {
        $bits = explode("\n",trim($crash->getStackTrace()));
        $title = substr(trim($bits[0]),0,250);
        $this->title = trim($title) ? trim($title) : "Issue";
    }




}
