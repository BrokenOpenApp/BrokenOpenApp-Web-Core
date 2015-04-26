<?php

namespace MarvinLabs\AcraServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes
 *
 * @ORM\Table(name="acra_crash_features")
 * @ORM\Entity()
 *
 */
class CrashFeatures
{

	/**
	 * @ORM\ID
	 * @ORM\ManyToOne(targetEntity="MarvinLabs\AcraServerBundle\Entity\Crash")
	 * @ORM\JoinColumn(name="crash_id", referencedColumnName="id", nullable=false)
	 */
	private $crash;


    /**
     * @var string
     *
	 * @ORM\ID
     * @ORM\Column(name="key", type="text", nullable=false)
     */
    private $feature;

	/**
	 * @return mixed
	 */
	public function getCrash()
	{
		return $this->crash;
	}

	/**
	 * @param mixed $crash
	 */
	public function setCrash($crash)
	{
		$this->crash = $crash;
	}

	/**
	 * @return string
	 */
	public function getFeature()
	{
		return $this->feature;
	}

	/**
	 * @param string $feature
	 */
	public function setFeature($feature)
	{
		$this->feature = $feature;
	}

}