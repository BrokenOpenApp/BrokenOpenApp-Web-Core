<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="incoming_crash_acra")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class IncomingCrashACRA
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="incoming_crash_acra_id_seq")
	 */
	private $id;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	private $project;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="incoming_crash_key", type="string", nullable=false, length=250, unique = true)
	 */
	private $incoming_crash_key;

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
	 * @return string
	 */
	public function getIncomingCrashKey()
	{
		return $this->incoming_crash_key;
	}

	/**
	 * @param string $incoming_crash_key
	 */
	public function setIncomingCrashKey($incoming_crash_key)
	{
		$this->incoming_crash_key = $incoming_crash_key;
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
	 * @ORM\PrePersist()
	 */
	public function beforeFirstSave() {
		$this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
	}

}