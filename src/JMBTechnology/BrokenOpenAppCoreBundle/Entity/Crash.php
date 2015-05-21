<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crashes
 *
 *
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 *
 * @ORM\Table(name="crash")
 * @ORM\Entity(repositoryClass="JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Crash
{
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="SEQUENCE")
	 * @ORM\SequenceGenerator(sequenceName="acra_crash_id_seq")
	 */
    private $id;

	/**
	 *
     * If we have Issue field, do we also need Project field? Yes.
     *
     * We get a crash, save it for posterity as fast as possible and work out which issue it is later.
     *
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project")
	 * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
	 */
	private $project;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\IncomingCrashACRA")
	 * @ORM\JoinColumn(name="incoming_crash_acra_id", referencedColumnName="id", nullable=true)
	 */
	private $incomingCrashACRA;

	/**
	 *
     * This can be null (and we also have an project field) because we get a crash, save it for posterity as fast as possible and work out which issue it is later.
     *
	 * @ORM\ManyToOne(targetEntity="JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue")
	 * @ORM\JoinColumn(name="issue_id", referencedColumnName="id", nullable=true)
	 */
	private $issue;

	/**
	 *
	 * @var string
	 *
	 * @ORM\Column(name="reporter_ip", type="string", length=250, nullable=true)
	 */
	private $reporter_ip;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;



    /**
     * @var string
     *
     * @ORM\Column(name="report_id", type="text", nullable=true)
     */
    private $reportId;

    /**
     * @var string
     *
     * @ORM\Column(name="app_version_code", type="text", nullable=true)
     */
    private $appVersionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="app_version_name", type="text", nullable=true)
     */
    private $appVersionName;

    /**
     * @var string
     *
     * @ORM\Column(name="package_name", type="text", nullable=true)
     */
    private $packageName;

    /**
     * @var string
     *
     * @ORM\Column(name="file_path", type="text", nullable=true)
     */
    private $filePath;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_model", type="text", nullable=true)
     */
    private $phoneModel;

    /**
     * @var string
     *
     * @ORM\Column(name="android_version", type="text", nullable=true)
     */
    private $androidVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="text", nullable=true)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="product", type="text", nullable=true)
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_mem_size", type="bigint", nullable=true)
     */
    private $totalMemSize;

    /**
     * @var integer
     *
     * @ORM\Column(name="available_mem_size", type="bigint", nullable=true)
     */
    private $availableMemSize;

    /**
     * @var string
     *
     * @ORM\Column(name="stack_trace", type="text", nullable=true)
     */
    private $stackTrace;

    /**
     * @var string
     *
     * @ORM\Column(name="user_comment", type="text", nullable=true)
     */
    private $userComment;

    /**
     * @var datetime
     *
     * @ORM\Column(name="user_app_start_date", type="datetime", nullable=true)
     */
    private $userAppStartDate;

    /**
     * @var datetime
     *
     * @ORM\Column(name="user_crash_date", type="datetime", nullable=true)
     */
    private $userCrashDate;

    /**
     * @var string
     *
     * @ORM\Column(name="dumpsys_meminfo", type="text", nullable=true)
     */
    private $dumpsysMeminfo;

    /**
     * @var string
     *
     * @ORM\Column(name="dropbox", type="text", nullable=true)
     */
    private $dropbox;

    /**
     * @var string
     *
     * @ORM\Column(name="logcat", type="text", nullable=true)
     */
    private $logcat;

    /**
     * @var string
     *
     * @ORM\Column(name="eventslog", type="text", nullable=true)
     */
    private $eventslog;

    /**
     * @var string
     *
     * @ORM\Column(name="radiolog", type="text", nullable=true)
     */
    private $radiolog;

    /**
     * @var string
     *
     * @ORM\Column(name="is_silent", type="text", nullable=true)
     */
    private $isSilent;

    /**
     * @var string
     *
     * @ORM\Column(name="device_id", type="text", nullable=true)
     */
    private $deviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="installation_id", type="text", nullable=true)
     */
    private $installationId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="text", nullable=true)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="media_codec_list", type="text", nullable=true)
     */
    private $mediaCodecList;

    /**
     * @var string
     *
     * @ORM\Column(name="thread_details", type="text", nullable=true)
     */
    private $threadDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="application_log", type="text", nullable=true)
     */
    private $applicationLog;

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->setCreatedAt(new \DateTime(null, new \DateTimeZone('UTC')));
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
	public function getIncomingCrashACRA()
	{
		return $this->incomingCrashACRA;
	}

	/**
	 * @param mixed $incomingCrashACRA
	 */
	public function setIncomingCrashACRA($incomingCrashACRA)
	{
		$this->incomingCrashACRA = $incomingCrashACRA;
	}




	/**
	 * @return mixed
	 */
	public function getIssue()
	{
		return $this->issue;
	}

	/**
	 * @param mixed $issue
	 */
	public function setIssue($issue)
	{
		$this->issue = $issue;
	}

	/**
	 * @return string
	 */
	public function getReporterIp()
	{
		return $this->reporter_ip;
	}

	/**
	 * @param string $reporter_ip
	 */
	public function setReporterIp($reporter_ip)
	{
		$this->reporter_ip = $reporter_ip;
	}





    /**
     * Set threadDetails
     *
     * @param string $threadDetails
     * @return Crash
     */
    public function setThreadDetails($threadDetails)
    {
        $this->threadDetails = $threadDetails;
    
        return $this;
    }

    /**
     * Get threadDetails
     *
     * @return string
     */
    public function getThreadDetails()
    {
        return $this->threadDetails;
    }

    /**
     * Set applicationLog
     *
     * @param string applicationLog
     * @return Crash
     */
    public function setApplicationLog($applicationLog)
    {
        $this->applicationLog = $applicationLog;
    
        return $this;
    }

    /**
     * Get applicationLog
     *
     * @return string
     */
    public function getApplicationLog()
    {
        return $this->applicationLog;
    }

    /**
     * Set mediaCodecList
     *
     * @param string $createdAt
     * @return Crash
     */
    public function setMediaCodecList($mediaCodecList)
    {
        $this->mediaCodecList = $mediaCodecList;
    
        return $this;
    }

    /**
     * Get mediaCodecList
     *
     * @return string
     */
    public function getMediaCodecList()
    {
        return $this->mediaCodecList;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Crash
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set reportId
     *
     * @param string $reportId
     * @return Crash
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
    
        return $this;
    }

    /**
     * Get reportId
     *
     * @return string 
     */
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * Set appVersionCode
     *
     * @param string $appVersionCode
     * @return Crash
     */
    public function setAppVersionCode($appVersionCode)
    {
        $this->appVersionCode = $appVersionCode;
    
        return $this;
    }

    /**
     * Get appVersionCode
     *
     * @return string 
     */
    public function getAppVersionCode()
    {
        return $this->appVersionCode;
    }

    /**
     * Set appVersionName
     *
     * @param string $appVersionName
     * @return Crash
     */
    public function setAppVersionName($appVersionName)
    {
        $this->appVersionName = $appVersionName;
    
        return $this;
    }

    /**
     * Get appVersionName
     *
     * @return string 
     */
    public function getAppVersionName()
    {
        return $this->appVersionName;
    }

    /**
     * Set packageName
     *
     * @param string $packageName
     * @return Crash
     */
    public function setPackageName($packageName)
    {
        $this->packageName = $packageName;
    
        return $this;
    }

    /**
     * Get packageName
     *
     * @return string 
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * Set filePath
     *
     * @param string $filePath
     * @return Crash
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    
        return $this;
    }

    /**
     * Get filePath
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set phoneModel
     *
     * @param string $phoneModel
     * @return Crash
     */
    public function setPhoneModel($phoneModel)
    {
        $this->phoneModel = $phoneModel;
    
        return $this;
    }

    /**
     * Get phoneModel
     *
     * @return string 
     */
    public function getPhoneModel()
    {
        return $this->phoneModel;
    }

    /**
     * Set androidVersion
     *
     * @param string $androidVersion
     * @return Crash
     */
    public function setAndroidVersion($androidVersion)
    {
        $this->androidVersion = $androidVersion;
    
        return $this;
    }

    /**
     * Get androidVersion
     *
     * @return string 
     */
    public function getAndroidVersion()
    {
        return $this->androidVersion;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Crash
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set product
     *
     * @param string $product
     * @return Crash
     */
    public function setProduct($product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return string 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set totalMemSize
     *
     * @param integer $totalMemSize
     * @return Crash
     */
    public function setTotalMemSize($totalMemSize)
    {
        $this->totalMemSize = $totalMemSize;
    
        return $this;
    }

    /**
     * Get totalMemSize
     *
     * @return integer 
     */
    public function getTotalMemSize()
    {
        return $this->totalMemSize;
    }

    /**
     * Set availableMemSize
     *
     * @param integer $availableMemSize
     * @return Crash
     */
    public function setAvailableMemSize($availableMemSize)
    {
        $this->availableMemSize = $availableMemSize;
    
        return $this;
    }

    /**
     * Get availableMemSize
     *
     * @return integer 
     */
    public function getAvailableMemSize()
    {
        return $this->availableMemSize;
    }

    /**
     * Set stackTrace
     *
     * @param string $stackTrace
     * @return Crash
     */
    public function setStackTrace($stackTrace)
    {
        $this->stackTrace = $stackTrace;
    
        return $this;
    }

    /**
     * Has stackTrace
     *
     * @return boolean
     */
    public function hasStackTrace()
    {
        return (boolean)trim($this->stackTrace);
    }

    /**
     * Get stackTrace
     *
     * @return string
     */
    public function getStackTrace()
    {
        return $this->stackTrace;
    }

    /**
     * Get short stackTrace
     *
     * @return string 
     */
    public function getShortStackTrace()
    {
    	$lines = explode("\n", $this->getStackTrace());
    	$res = "";
    	
    	if (!empty($lines)) {
	    	foreach ($lines as $id => $line) {
	    		if (strpos($line, ": ") !== FALSE || strpos($line, $this->getPackageName()) !== FALSE
	    				|| strpos($line, "Error") !== FALSE || strpos($line, "Exception") !== FALSE) {
	    			$res .= $line . "\n";
	    		}
	    	}
	    	
	    	if (empty($res)) {
	    		$res = $lines[0];
	    	}
    	}
    	
    	
    	return $res;
    }
    
    function array_find($needle, $haystack)
    {
    	foreach ($haystack as $item)
    	{
    		if (strpos($item, $needle) !== FALSE)
    		{
    			return $item;
    			break;
    		}
    	}
    	return FALSE;
    }

    /**
     * Set userComment
     *
     * @param string $userComment
     * @return Crash
     */
    public function setUserComment($userComment)
    {
        $this->userComment = $userComment;
    
        return $this;
    }

    /**
     * Get userComment
     *
     * @return string 
     */
    public function getUserComment()
    {
        return $this->userComment;
    }

    /**
     * Set userAppStartDate
     *
     * @param datetime $userAppStartDate
     * @return Crash
     */
    public function setUserAppStartDate($userAppStartDate)
    {
        $this->userAppStartDate = $userAppStartDate;
    
        return $this;
    }

    /**
     * Get userAppStartDate
     *
     * @return datetime 
     */
    public function getUserAppStartDate()
    {
        return $this->userAppStartDate;
    }

    /**
     * Set userCrashDate
     *
     * @param datetime $userCrashDate
     * @return Crash
     */
    public function setUserCrashDate($userCrashDate)
    {
        $this->userCrashDate = $userCrashDate;
    
        return $this;
    }

    /**
     * Get userCrashDate
     *
     * @return datetime 
     */
    public function getUserCrashDate()
    {
        return $this->userCrashDate;
    }

    /**
     * Set dumpsysMeminfo
     *
     * @param string $dumpsysMeminfo
     * @return Crash
     */
    public function setDumpsysMeminfo($dumpsysMeminfo)
    {
        $this->dumpsysMeminfo = $dumpsysMeminfo;
    
        return $this;
    }

    /**
     * Get dumpsysMeminfo
     *
     * @return string 
     */
    public function getDumpsysMeminfo()
    {
        return $this->dumpsysMeminfo;
    }

    /**
     * Set dropbox
     *
     * @param string $dropbox
     * @return Crash
     */
    public function setDropbox($dropbox)
    {
        $this->dropbox = $dropbox;
    
        return $this;
    }

    /**
     * Get dropbox
     *
     * @return string 
     */
    public function getDropbox()
    {
        return $this->dropbox;
    }

    /**
     * Set logcat
     *
     * @param string $logcat
     * @return Crash
     */
    public function setLogcat($logcat)
    {
        $this->logcat = $logcat;
    
        return $this;
    }

    /**
     * Get logcat
     *
     * @return string 
     */
    public function getLogcat()
    {
        return $this->logcat;
    }

    /**
     * Set eventslog
     *
     * @param string $eventslog
     * @return Crash
     */
    public function setEventslog($eventslog)
    {
        $this->eventslog = $eventslog;
    
        return $this;
    }

    /**
     * Get eventslog
     *
     * @return string 
     */
    public function getEventslog()
    {
        return $this->eventslog;
    }

    /**
     * Set radiolog
     *
     * @param string $radiolog
     * @return Crash
     */
    public function setRadiolog($radiolog)
    {
        $this->radiolog = $radiolog;
    
        return $this;
    }

    /**
     * Get radiolog
     *
     * @return string 
     */
    public function getRadiolog()
    {
        return $this->radiolog;
    }

    /**
     * Set isSilent
     *
     * @param string $isSilent
     * @return Crash
     */
    public function setIsSilent($isSilent)
    {
        $this->isSilent = $isSilent;
    
        return $this;
    }

    /**
     * Get isSilent
     *
     * @return string 
     */
    public function getIsSilent()
    {
        return $this->isSilent;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return Crash
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    
        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set installationId
     *
     * @param string $installationId
     * @return Crash
     */
    public function setInstallationId($installationId)
    {
        $this->installationId = $installationId;
    
        return $this;
    }

    /**
     * Get installationId
     *
     * @return string 
     */
    public function getInstallationId()
    {
        return $this->installationId;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     * @return Crash
     */
    public function setUserEmail($userEmail)
    {
		// ACRA puts this is as a default value. We want NULLs, not placeholder strings.
		if ($userEmail != "N/A") {
			$this->userEmail = $userEmail;
		}

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string 
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function computeIssueFingerPrint()
    {    	
    	$issueId = md5($this->getShortStackTrace());

    	global $kernel;
    	if ('AppCache' == get_class($kernel)) $kernel = $kernel->getKernel();
    	$kernel->getContainer()->get('logger')->warn('Computed issue id: ' . $issueId);
    	
    	return $issueId;
    }
}