<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="proguard_mapping", uniqueConstraints={@ORM\UniqueConstraint(name="proguard_mapping_unique", columns={"project_id","package_name", "app_version_code"})})
 * @ORM\Entity()
 * @UniqueEntity({"project","packageName", "appVersionCode"})
 * @ORM\HasLifecycleCallbacks
 */
class ProGuardMapping
{

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="bigint", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="crash_id_seq")
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
	 * @ORM\Column(name="package_name", type="text", nullable=false)
	 */
	private $packageName;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="app_version_code", type="bigint", nullable=false)
	 */
	private $appVersionCode;


	/**
	 * @ORM\Column(type="string", length=255, nullable=false)
	 */
	public $path;

	/**
	 * @var datetime $createdAt
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;


	/**
	 * @return int
	 */
	public function getAppVersionCode()
	{
		return $this->appVersionCode;
	}

	/**
	 * @param int $appVersionCode
	 */
	public function setAppVersionCode($appVersionCode)
	{
		$this->appVersionCode = $appVersionCode;
	}

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
	public function getPackageName()
	{
		return $this->packageName;
	}

	/**
	 * @param string $packageName
	 */
	public function setPackageName($packageName)
	{
		$this->packageName = $packageName;
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
	 * @return mixed
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param mixed $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
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



	public function getAbsolutePath()
	{
		return null === $this->path
			? null
			: $this->getUploadRootDir().'/'.$this->path;
	}

	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;

	/**
	 * @return mixed
	 */
	public function getFile()
	{
		return $this->file;
	}

	protected function getUploadRootDir()
	{
		// the absolute directory path where uploaded
		// documents should be saved
		return __DIR__.'/../../../../'.$this->getUploadDir();
	}


	protected function getUploadDir()
	{
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		return 'uploads/proguardmappings';
	}

	private $temp;

	/**
	 * Sets file.
	 *
	 * @param UploadedFile $file
	 */
	public function setFile(UploadedFile $file = null)
	{
		$this->file = $file;
		// check if we have an old image path
		if (isset($this->path)) {
			// store the old name to delete after the update
			$this->temp = $this->path;
			$this->path = null;
		} else {
			$this->path = 'initial';
		}
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload()
	{
		if (null !== $this->getFile()) {
			// do whatever you want to generate a unique name
			$filename = sha1(uniqid(mt_rand(), true));
			$this->path = $filename.'.'.$this->getFile()->guessExtension();
		}
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload()
	{
		if (null === $this->getFile()) {
			return;
		}

		// if there is an error when moving the file, an exception will
		// be automatically thrown by move(). This will properly prevent
		// the entity from being persisted to the database on error
		$this->getFile()->move($this->getUploadRootDir(), $this->path);

		// check if we have an old image
		if (isset($this->temp)) {
			// delete the old image
			unlink($this->getUploadRootDir().'/'.$this->temp);
			// clear the temp image path
			$this->temp = null;
		}
		$this->file = null;
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload()
	{
		$file = $this->getAbsolutePath();
		if ($file) {
			unlink($file);
		}
	}

	/**
	 * @ORM\PrePersist()
	 */
	public function beforeFirstSave() {
		$this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
	}

}


//http://symfony.com/doc/2.3/cookbook/doctrine/file_uploads.html

