<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes Features
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="crash_features")
 * @ORM\Entity()
 *
 */
class CrashFeatures
{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash")
	 * @ORM\JoinColumn(name="crash_id", referencedColumnName="id", nullable=false)
	 */
	private $crash;


    /**
     * @var string
     *
	 * @ORM\Id
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