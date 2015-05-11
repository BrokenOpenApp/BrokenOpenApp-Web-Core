<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Nelmio\Alice\Fixtures;
use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class LoadFixtureData implements FixtureInterface
{
   	public function load(ObjectManager $om)
   	{
       	// pass $this as an additional faker provider to make the methods available as a data provider
       	$objects = Fixtures::load(__DIR__.'/fixtures.yml', $om, array('providers' => array($this)));
       
//      $persister = new \Nelmio\Alice\ORM\Doctrine($objectManager);
//      $persister->persist($objects);
//      $persister->flush();
   	}

   	public function crashStatus()
   	{
		$arr = array(
	  			Crash::$STATUS_NEW,
	  			Crash::$STATUS_NEW,
	  			Crash::$STATUS_NEW, // 3 times more new bugs than fixed ones
    			Crash::$STATUS_FIXED
			);

       	return $arr[array_rand($arr)];
   	}

   	public function brand()
   	{
       	$arr = array(
	   			'Samsung',
	           	'Sony',
	           	'HTC',
	       	);

       	return $arr[array_rand($arr)];
   	}

   	public function model()
   	{
       	$arr = array(
	   			'GT-i7100',
	   			'GT-i5300',
	   			'XPeria',
	   			'OneX',
	       	);

       	return $arr[array_rand($arr)];
   	}

   	public function product()
   	{
       	$arr = array(
	   			'BUZZ',
	   			'BANG',
	   			'BONG',
	   			'BIZZ',
	       	);

       	return $arr[array_rand($arr)];
   	}

   	public function packageName()
   	{
       	$arr = array(
	   			'fr.marvinlabs.coverartwallpaper',
	           	'com.example.sampleapp',
	           	'fr.marvinlabs.bigpicture',
	       	);

       	return $arr[array_rand($arr)];
   	}

   	public function androidVersion()
   	{
       	$v = array(
	           '2.2',
	           '2.3',
	           '3.0',
	           '3.1',
	           '3.2',
	           '4.0',
	           '4.1',
	           '4.2',
	  		);

       	return $v[array_rand($v)];
   	}

   	public function appVersion($appVersionCode)
   	{
   		$major 	= (int)($appVersionCode / 10);
   		$minor 	= (int)($appVersionCode % 10);
   
   		return sprintf("%d.%d", $major, $minor);
   	}   

   	public function stackTrace($packageName)
   	{
       	$arr = array(
	   			'java.lang.RuntimeException: Some message for the exception
	at %%PKG%%.MainActivity.onClick(MainActivity.java:34)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	           	'java.lang.NullPointerException
	at %%PKG%%.MainActivity.onClick(MainActivity.java:37)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	           	'java.lang.InvalidArgumentException
	at %%PKG%%.MainActivity.onClick(MainActivity.java:37)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	           	'java.lang.ReflectionInvocationException
	at %%PKG%%.MainActivity.onClick(MainActivity.java:37)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	           	'java.lang.FunkyInvocationException
	at %%PKG%%.MainActivity.onClick(MainActivity.java:37)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	           	'java.lang.GimmeAManAfterMidnightException
	at %%PKG%%.MainActivity.onClick(MainActivity.java:37)
	at android.view.View.performClick(View.java:4204)
	at android.view.View$PerformClick.run(View.java:17359)
	at android.os.Handler.handleCallback(Handler.java:725)
	at android.os.Handler.dispatchMessage(Handler.java:92)
	at android.os.Looper.loop(Looper.java:137)
	at android.app.ActivityThread.main(ActivityThread.java:5259)
	at java.lang.reflect.Method.invokeNative(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:511)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:795)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:562)
	at dalvik.system.NativeStart.main(Native Method)
       			',
	       	);

       	return str_replace('%%PKG%%', $packageName, $arr[array_rand($arr)]);
   	}
}//*