<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Issue
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="issue",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="issue_fingerprint_unique", columns={"project_id","fingerprint"}),
 *   @ORM\UniqueConstraint(name="issue_number_unique", columns={"project_id","number"})})
 * @ORM\Entity(repositoryClass="JMBTechnology\BrokenOpenAppCoreBundle\Entity\IssueRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity({"project","fingerprint"})
 * @UniqueEntity({"project","number"})
 */
class Issue
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="bigint", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="boa_issue_id_seq")
	 */
	private $id;


	/**
	 *
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	private $project;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="number", type="bigint", nullable=false)
	 */
	private $number;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fingerprint", type="string", length=32, nullable=false)
	 */
	private $fingerprint;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=250, nullable=false)
     */
    private $title;

	/**
	 * @var datetime $createdAt
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;


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
	 * @return int
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @param int $number
	 */
	public function setNumber($number)
	{
		$this->number = $number;
	}

	/**
	 * @return string
	 */
	public function getFingerprint()
	{
		return $this->fingerprint;
	}

	/**
	 * @param string $fingerPrint
	 */
	public function setFingerprint($fingerPrint)
	{
		$this->fingerprint = $fingerPrint;
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
	 * @return datetime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param datetime $createdAt
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
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


	/**
	 * @ORM\PrePersist()
	 */
	public function beforeFirstSave() {
		$this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
	}




}
