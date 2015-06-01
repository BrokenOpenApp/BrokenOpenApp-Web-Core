<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Test\CrashACRA;


use JMBTechnology\BrokenOpenAppCoreBundle\Entity\IncomingCrashACRA;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Project;
use JMBTechnology\BrokenOpenAppCoreBundle\Test\BaseTestWithDataBase;

include_once(__DIR__."/../BaseTestWithDataBase.php");

class NormalCrashTest extends BaseTestWithDataBase
{



	public function test1()
	{

		// Set up DB
		$project = new Project();
		$project->setTitle("Test");

		$incomingCrashACRA = new IncomingCrashACRA();
		$incomingCrashACRA->setProject($project);
		$incomingCrashACRA->setIncomingCrashKey("test");

		$this->em->persist($project);
		$this->em->persist($incomingCrashACRA);
		$this->em->flush();


		// Run Request!
		$client = static::createClient();

		$crawler = $client->request("POST","/crash/add?project=test",array(
			'ANDROID_VERSION'=>'4.4.4',
			'APP_VERSION_CODE'=>'1',
			'APP_VERSION_NAME'=>'1.0',
			'APPLICATION_LOG'=>'',
			'AVAILABLE_MEM_SIZE'=>'12370644992',
			'BRAND'=>'',
			'DEVICE_ID'=>'',
			'DROPBOX'=>'N/A',
			'DUMPSYS_MEMINFO'=>'Permission Denial: can\'t dump meminfo from from pid=4156, uid=10176 without permission android.permission.DUMP
',
			'EVENTSLOG'=>'06-01 17:22:51.104 I/am_on_resume_called( 3016): [0,org.brokenopenapp.acratest.MainActivity]
06-01 17:40:59.354 I/am_on_resume_called( 3775): [0,org.brokenopenapp.acratest.MainActivity]
',
			'FILE_PATH'=>'/data/data/org.brokenopenapp.acratest/files',
			'INSTALLATION_ID'=>'fad35e91-d6ca-4738-90f2-cf5254e9899f',
			'IS_SILENT'=>'',
			'LOGCAT'=>'06-01 17:45:05.374 E/ACRA    ( 3775):    at dalvik.system.NativeStart.main(Native Method)
06-01 17:45:05.384 D/ACRA    ( 3775): Writing crash report file 1433177105000.stacktrace.
06-01 17:45:05.394 D/ACRA    ( 3775): About to start ReportSenderWorker from #handleException
06-01 17:45:05.394 D/ACRA    ( 3775): Mark all pending reports as approved.
06-01 17:45:05.394 D/ACRA    ( 3775): Looking for error files in /data/data/org.brokenopenapp.acratest/files
06-01 17:45:05.394 D/ACRA    ( 3775): #checkAndSendReports - start
06-01 17:45:05.394 D/ACRA    ( 3775): Looking for error files in /data/data/org.brokenopenapp.acratest/files
06-01 17:45:05.394 I/ACRA    ( 3775): Sending file 1433177105000-approved.stacktrace
',
			'MEDIA_CODEC_LIST'=>'',
			'PACKAGE_NAME'=>'com.test',
			'PHONE_MODEL'=>'Nexus 7',
			'PRODUCT'=>'nakasi',
			'RADIOLOG'=>'',
			'REPORT_ID'=>'6cc6f0a4-9271-4b28-98f9-bd1468ca4de1',
			'STACK_TRACE'=>'java.lang.RuntimeException: CRASH HA HA BUTTON 1
        at org.brokenopenapp.acratest.MainActivity.crashRuntimeException(MainActivity.java:38)
        at org.brokenopenapp.acratest.MainActivity.onClickCrash1(MainActivity.java:21)
        at java.lang.reflect.Method.invokeNative(Native Method)
        at java.lang.reflect.Method.invoke(Method.java:515)
        at android.view.View$1.onClick(View.java:3818)
        at android.view.View.performClick(View.java:4438)
        at android.view.View$PerformClick.run(View.java:18422)
        at android.os.Handler.handleCallback(Handler.java:733)
        at android.os.Handler.dispatchMessage(Handler.java:95)
        at android.os.Looper.loop(Looper.java:136)
        at android.app.ActivityThread.main(ActivityThread.java:5001)
        at java.lang.reflect.Method.invokeNative(Native Method)
        at java.lang.reflect.Method.invoke(Method.java:515)
        at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:785)
        at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:601)
        at dalvik.system.NativeStart.main(Native Method)',
			'THREAD_DETAILS'=>'',
			'TOTAL_MEM_SIZE'=>'14215020544',
			'USER_COMMENT'=>'',
			'USER_EMAIL'=>'N/A',
			'USER_APP_START_DATE'=>'2015-06-01T17:40:59.000+01:00',
			'USER_CRASH_DATE'=>'2015-06-01T17:45:05.000+01:00',
			'BUILD'=>'BOARD=grouper
BOOTLOADER=4.23
BRAND=google',
			'DISPLAY'=>'0.currentSizeRange.smallest=[800,703]
0.currentSizeRange.largest=[1280,1172]
0.flags=FLAG_SUPPORTS_PROTECTED_BUFFERS+FLAG_SECURE',
			'CRASH_CONFIGURATION'=>'compatScreenHeightDp=468
compatScreenWidthDp=319
compatSmallestScreenWidthDp=320
densityDpi=213
',
			'INITIAL_CONFIGURATION'=>'compatScreenHeightDp=468
compatScreenWidthDp=319
compatSmallestScreenWidthDp=320',
			'ENVIRONMENT'=>'getDataDirectory=/data
getDownloadCacheDirectory=/cache
getEmulatedStorageObbSource=/mnt/shell/emulated/obb
getExternalStorageDirectory=/storage/emulated/0
',
			'DEVICE_FEATURES'=>'android.hardware.wifi
android.hardware.location.network
android.hardware.nfc
',
			'SETTINGS_SECURE'=>'ACCESSIBILITY_DISPLAY_MAGNIFICATION_AUTO_UPDATE=1
ACCESSIBILITY_DISPLAY_MAGNIFICATION_ENABLED=0
ACCESSIBILITY_DISPLAY_MAGNIFICATION_SCALE=2.0
',
			'SETTINGS_GLOBAL'=>'ADB_ENABLED=1
AIRPLANE_MODE_ON=0
AIRPLANE_MODE_RADIOS=cell,bluetooth,wifi,nfc,wimax
AIRPLANE_MODE_TOGGLEABLE_RADIOS=bluetooth,wifi,nfc
',
			'SETTINGS_SYSTEM'=>'ACCELEROMETER_ROTATION=1
ALARM_ALERT=content://media/internal/audio/media/5
DTMF_TONE_TYPE_WHEN_DIALING=0
',
			'SHARED_PREFERENCES'=>'default.acra.lastVersionNr=1

',
			'CUSTOM_DATA'=>'test1 = a b c
testNewlines = a\\nb\\nc
',
			'BUILD_CONFIG'=>'APPLICATION_ID=org.brokenopenapp.acratest
BUILD_TYPE=debug
DEBUG=true
FLAVOR=
VERSION_CODE=1
VERSION_NAME=1.0
'
		));

		$this->assertTrue($client->getResponse()->isSuccessful());

		// Load Crash from DB and check!

		$crash = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash')->findOneBy(array('project'=>$project));

		$this->assertNotNull($crash);
		$this->assertEquals("4.4.4",$crash->getAndroidVersion());
		$this->assertEquals("1", $crash->getAppVersionCode());
		$this->assertEquals("1.0", $crash->getAppVersionName());
		$this->assertEquals("12370644992",$crash->getAvailableMemSize());
		$this->assertEquals("06-01 17:22:51.104 I/am_on_resume_called( 3016): [0,org.brokenopenapp.acratest.MainActivity]
06-01 17:40:59.354 I/am_on_resume_called( 3775): [0,org.brokenopenapp.acratest.MainActivity]
",$crash->getEventsLog());
		$this->assertEquals("/data/data/org.brokenopenapp.acratest/files",$crash->getFilePath());
		$this->assertEquals("fad35e91-d6ca-4738-90f2-cf5254e9899f",$crash->getInstallationId());
		$this->assertEquals("06-01 17:45:05.374 E/ACRA    ( 3775):    at dalvik.system.NativeStart.main(Native Method)
06-01 17:45:05.384 D/ACRA    ( 3775): Writing crash report file 1433177105000.stacktrace.
06-01 17:45:05.394 D/ACRA    ( 3775): About to start ReportSenderWorker from #handleException
06-01 17:45:05.394 D/ACRA    ( 3775): Mark all pending reports as approved.
06-01 17:45:05.394 D/ACRA    ( 3775): Looking for error files in /data/data/org.brokenopenapp.acratest/files
06-01 17:45:05.394 D/ACRA    ( 3775): #checkAndSendReports - start
06-01 17:45:05.394 D/ACRA    ( 3775): Looking for error files in /data/data/org.brokenopenapp.acratest/files
06-01 17:45:05.394 I/ACRA    ( 3775): Sending file 1433177105000-approved.stacktrace
",$crash->getLogCat());
		$this->assertEquals("com.test", $crash->getPackageName());
		$this->assertEquals("Nexus 7",$crash->getPhoneModel());
		$this->assertEquals("nakasi",$crash->getProduct());
		$this->assertEquals("6cc6f0a4-9271-4b28-98f9-bd1468ca4de1",$crash->getReportId());
		$this->assertEquals('java.lang.RuntimeException: CRASH HA HA BUTTON 1
        at org.brokenopenapp.acratest.MainActivity.crashRuntimeException(MainActivity.java:38)
        at org.brokenopenapp.acratest.MainActivity.onClickCrash1(MainActivity.java:21)
        at java.lang.reflect.Method.invokeNative(Native Method)
        at java.lang.reflect.Method.invoke(Method.java:515)
        at android.view.View$1.onClick(View.java:3818)
        at android.view.View.performClick(View.java:4438)
        at android.view.View$PerformClick.run(View.java:18422)
        at android.os.Handler.handleCallback(Handler.java:733)
        at android.os.Handler.dispatchMessage(Handler.java:95)
        at android.os.Looper.loop(Looper.java:136)
        at android.app.ActivityThread.main(ActivityThread.java:5001)
        at java.lang.reflect.Method.invokeNative(Native Method)
        at java.lang.reflect.Method.invoke(Method.java:515)
        at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:785)
        at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:601)
        at dalvik.system.NativeStart.main(Native Method)',$crash->getStackTrace());
		$this->assertEquals("14215020544",$crash->getTotalMemSize());
		$this->assertEquals("2015-06-01T16:40:59+00:00",$crash->getUserAppStartDateInUTC()->format("c"));
		$this->assertEquals("2015-06-01T16:45:05+00:00",$crash->getUserCrashDateInUTC()->format("c"));
		$this->assertEquals(60,$crash->getUserAppStartDateOffset());
		$this->assertEquals(60,$crash->getUserCrashDateOffset());


		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashBuild')->findOneBy(array('crash'=>$crash,'key'=>'BOOTLOADER'));
		$this->assertNotNull($value);
		$this->assertEquals('4.23',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashDisplay')->findOneBy(array('crash'=>$crash,'key'=>'0.currentSizeRange.largest'));
		$this->assertNotNull($value);
		$this->assertEquals('[1280,1172]',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashCrashConfiguration')->findOneBy(array('crash'=>$crash,'key'=>'compatScreenWidthDp'));
		$this->assertNotNull($value);
		$this->assertEquals('319',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashInitialConfiguration')->findOneBy(array('crash'=>$crash,'key'=>'compatScreenHeightDp'));
		$this->assertNotNull($value);
		$this->assertEquals('468',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashEnvironment')->findOneBy(array('crash'=>$crash,'key'=>'getDataDirectory'));
		$this->assertNotNull($value);
		$this->assertEquals('/data',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashFeatures')->findOneBy(array('crash'=>$crash,'feature'=>'android.hardware.wifi'));
		$this->assertNotNull($value);

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsSystem')->findOneBy(array('crash'=>$crash,'key'=>'ACCELEROMETER_ROTATION'));
		$this->assertNotNull($value);
		$this->assertEquals('1',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsSecure')->findOneBy(array('crash'=>$crash,'key'=>'ACCESSIBILITY_DISPLAY_MAGNIFICATION_SCALE'));
		$this->assertNotNull($value);
		$this->assertEquals('2.0',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSettingsGlobal')->findOneBy(array('crash'=>$crash,'key'=>'ADB_ENABLED'));
		$this->assertNotNull($value);
		$this->assertEquals('1',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashCustomData')->findOneBy(array('crash'=>$crash,'key'=>'test1'));
		$this->assertNotNull($value);
		$this->assertEquals('a b c',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashSharedPreferences')->findOneBy(array('crash'=>$crash,'key'=>'default.acra.lastVersionNr'));
		$this->assertNotNull($value);
		$this->assertEquals('1',$value->getValue());

		$value = $this->em->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:CrashBuildConfiguration')->findOneBy(array('crash'=>$crash,'key'=>'DEBUG'));
		$this->assertNotNull($value);
		$this->assertEquals('true',$value->getValue());

	}



}
