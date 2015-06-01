<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashBuild;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashBuildConfiguration;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashCrashConfiguration;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashCustomData;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashDisplay;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashEnvironment;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashFeatures;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashInitialConfiguration;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashSettingsGlobal;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashSettingsSecure;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashSettingsSystem;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\CrashSharedPreferences;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Issue;
use JMBTechnology\BrokenOpenAppCoreBundle\ProcessCrash;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;
use JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures\LoadFixtureData;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class IncomingCrashACRAController extends Controller
{


	
	/**
	 * Add a crash to the DB and send a notification to the crash admin
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addAction()
	{


		// $file = fopen("/tmp/dump.txt","w"); fwrite($file, var_export($_POST, true)); fclose($file);

		// read only?
		if ($this->container->hasParameter('jmb_technology_brokenopenapp_core.read_only') && $this->container->getParameter('jmb_technology_brokenopenapp_core.read_only')) {
			$response = new Response("Read Only Mode. Try Again Soon.");
			$response->setStatusCode(500);
			return $response;
		}

		// vars
		$doctrine = $this->getDoctrine()->getManager();

		// Project?
		$incomingCrashACRARepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:IncomingCrashACRA');
		$incomingCrashACRA = $incomingCrashACRARepo->findOneBy(array('incoming_crash_key'=>$this->getRequest()->query->get('project')));
		if (!$incomingCrashACRA) {
			$response = new Response();
			$response->setStatusCode(404);
			return $response;
		}

		$project = $incomingCrashACRA->getProject();
		if (!$project) {
			$response = new Response();
			$response->setStatusCode(404);
			return $response;
		}

		// Crash
		$crash = $this->newCrashFromRequest($this->getRequest());
		$crash->setProject($project);
		$crash->setIncomingCrashACRA($incomingCrashACRA);
		$crash->setReporterIp($this->getRequest()->getClientIp());
		$doctrine->persist($crash);
		// flush here so always got basic data of crash at least!
		$doctrine->flush();

		foreach($this->getKeyValuePairsFor('BUILD') as $k=>$v) {
			$crashBuild = new CrashBuild();
			$crashBuild->setCrash($crash);
			$crashBuild->setKey($k);
			$crashBuild->setValue($v);
			$doctrine->persist($crashBuild);
		}
		foreach($this->getKeyValuePairsFor('DISPLAY') as $k=>$v) {
			$crashDisplay = new CrashDisplay();
			$crashDisplay->setCrash($crash);
			$crashDisplay->setKey($k);
			$crashDisplay->setValue($v);
			$doctrine->persist($crashDisplay);
		}
		foreach($this->getKeyValuePairsFor('CRASH_CONFIGURATION') as $k=>$v) {
			$crashConfig = new CrashCrashConfiguration();
			$crashConfig->setCrash($crash);
			$crashConfig->setKey($k);
			$crashConfig->setValue($v);
			$doctrine->persist($crashConfig);
		}
		foreach($this->getKeyValuePairsFor('INITIAL_CONFIGURATION') as $k=>$v) {
			$initConfig = new CrashInitialConfiguration();
			$initConfig->setCrash($crash);
			$initConfig->setKey($k);
			$initConfig->setValue($v);
			$doctrine->persist($initConfig);
		}

		foreach($this->getKeyValuePairsFor('ENVIRONMENT') as $k=>$v) {
			$crashEnv = new CrashEnvironment();
			$crashEnv->setCrash($crash);
			$crashEnv->setKey($k);
			$crashEnv->setValue($v);
			$doctrine->persist($crashEnv);
		}

		foreach($this->getValueFor('DEVICE_FEATURES') as $f) {
			$crashFeatures = new CrashFeatures();
			$crashFeatures->setCrash($crash);
			$crashFeatures->setFeature($f);
			$doctrine->persist($crashFeatures);
		}

		foreach($this->getKeyValuePairsFor('SETTINGS_SECURE') as $k=>$v) {
			$crashSettingsSecure = new CrashSettingsSecure();
			$crashSettingsSecure->setCrash($crash);
			$crashSettingsSecure->setKey($k);
			$crashSettingsSecure->setValue($v);
			$doctrine->persist($crashSettingsSecure);
		}

		foreach($this->getKeyValuePairsFor('SETTINGS_GLOBAL') as $k=>$v) {
			$crashSettingsGlobal = new CrashSettingsGlobal();
			$crashSettingsGlobal->setCrash($crash);
			$crashSettingsGlobal->setKey($k);
			$crashSettingsGlobal->setValue($v);
			$doctrine->persist($crashSettingsGlobal);
		}

		foreach($this->getKeyValuePairsFor('SETTINGS_SYSTEM') as $k=>$v) {
			$crashSettingsSystem = new CrashSettingsSystem();
			$crashSettingsSystem->setCrash($crash);
			$crashSettingsSystem->setKey($k);
			$crashSettingsSystem->setValue($v);
			$doctrine->persist($crashSettingsSystem);
		}

		foreach($this->getKeyValuePairsFor('SHARED_PREFERENCES') as $k=>$v) {
			$crashSharedPrefs = new CrashSharedPreferences();
			$crashSharedPrefs->setCrash($crash);
			$crashSharedPrefs->setKey($k);
			$crashSharedPrefs->setValue($v);
			$doctrine->persist($crashSharedPrefs);
		}


		foreach($this->getKeyValuePairsFor('CUSTOM_DATA') as $k=>$v) {
			$crashCustomData = new CrashCustomData();
			$crashCustomData->setCrash($crash);
			$crashCustomData->setKey($k);
			$crashCustomData->setValue($v);
			$doctrine->persist($crashCustomData);
		}

		foreach($this->getKeyValuePairsFor('BUILD_CONFIG') as $k=>$v) {
			$crashBuildConfig = new CrashBuildConfiguration();
			$crashBuildConfig->setCrash($crash);
			$crashBuildConfig->setKey($k);
			$crashBuildConfig->setValue($v);
			$doctrine->persist($crashBuildConfig);
		}

		$doctrine->flush();

		return new Response( '' );
	}

    /**
     * Build a crash from the parameters passed to the request
     * 
     * @return \JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash
     */
    private function newCrashFromRequest($request)
    {
    	$requestData = $request->request;
    	
    	$crash = new Crash();
    	$crash->setAndroidVersion($requestData->get('ANDROID_VERSION', null));
    	$crash->setAppVersionCode($requestData->get('APP_VERSION_CODE', null));
    	$crash->setAppVersionName($requestData->get('APP_VERSION_NAME', null));
    	$crash->setApplicationLog($requestData->get('APPLICATION_LOG', null));
    	$crash->setAvailableMemSize($requestData->get('AVAILABLE_MEM_SIZE', null));
    	$crash->setBrand($requestData->get('BRAND', null));
    	$crash->setDeviceId($requestData->get('DEVICE_ID', null));
    	$crash->setDropbox($requestData->get('DROPBOX', null));
    	$crash->setDumpsysMeminfo($requestData->get('DUMPSYS_MEMINFO', null));
    	$crash->setEventsLog($requestData->get('EVENTSLOG', null));
    	$crash->setFilePath($requestData->get('FILE_PATH', null));
    	$crash->setInstallationId($requestData->get('INSTALLATION_ID', null));
    	$crash->setIsSilent($requestData->get('IS_SILENT', null));
    	$crash->setLogcat($requestData->get('LOGCAT', null));
    	$crash->setMediaCodecList($requestData->get('MEDIA_CODEC_LIST', null));
    	$crash->setPackageName($requestData->get('PACKAGE_NAME', null));
    	$crash->setPhoneModel($requestData->get('PHONE_MODEL', null));
    	$crash->setProduct($requestData->get('PRODUCT', null));
    	$crash->setRadioLog($requestData->get('RADIOLOG', null));
    	$crash->setReportId($requestData->get('REPORT_ID', null));
    	$crash->setStackTrace($requestData->get('STACK_TRACE', null));
    	$crash->setThreadDetails($requestData->get('THREAD_DETAILS', null));
    	$crash->setTotalMemSize($requestData->get('TOTAL_MEM_SIZE', null));
    	$crash->setUserComment($requestData->get('USER_COMMENT', null));
    	$crash->setUserEmail($requestData->get('USER_EMAIL', null));

		$crash->setUserAppStartDateFromString($requestData->get('USER_APP_START_DATE', null));
		$crash->setUserCrashDateFromString($requestData->get('USER_CRASH_DATE', null));

    	return $crash;
    }

	private function getKeyValuePairsFor($key) {
		$out = array();
		foreach(explode("\n", $this->getRequest()->request->get($key)) as $line) {
			if (trim($line)) {
				$bits =  explode("=", trim($line),2);
				if (count($bits) == 2 && trim($bits[0])) {
					$out[trim($bits[0])] = trim($bits[1]);
				}
			}
		}
		return $out;
	}

	private function getValueFor($key) {
		$out = array();
		foreach(explode("\n", $this->getRequest()->request->get($key)) as $line) {
			if (trim($line)) {
				$out[] = trim($line);
			}
		}
		return $out;
	}
}
