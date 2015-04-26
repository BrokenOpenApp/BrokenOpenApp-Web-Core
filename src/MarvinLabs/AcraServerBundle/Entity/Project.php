<?php

namespace MarvinLabs\AcraServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppFilter
 *
 *
 * @ORM\Table(name="acra_project")
 * @ORM\Entity(repositoryClass="MarvinLabs\AcraServerBundle\Entity\ProjectRepository")
 */
class Project
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="text", nullable=false)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="incoming_crash_id", type="string", nullable=false, length=100, unique = true)
	 */
	private $incoming_crash_id;

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
	public function getIncomingCrashId()
	{
		return $this->incoming_crash_id;
	}

	/**
	 * @param string $incoming_crash_id
	 */
	public function setIncomingCrashId($incoming_crash_id)
	{
		$this->incoming_crash_id = $incoming_crash_id;
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


}