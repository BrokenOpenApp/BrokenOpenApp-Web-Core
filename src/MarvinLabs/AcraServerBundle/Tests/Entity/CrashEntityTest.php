<?php

namespace MarvinLabs\AcraServerBundle\Test\Entity;


use MarvinLabs\AcraServerBundle\Entity\Crash;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{

    public function testGetShortStackTrace()
    {

        $crash = new Crash();
        $crash->setPackageName('com.niceagain.beecount');
        $crash->setStackTrace('java.lang.RuntimeException: getImageThumbnailCallbacks onLoadFinished() called & was success
	at com.niceagain.beecount.ui.BasePictureActivity$1.onLoadFinished(BasePictureActivity.java:167)
	at com.niceagain.beecount.ui.BasePictureActivity$1.onLoadFinished(BasePictureActivity.java:156)
	at android.support.v4.app.LoaderManagerImpl$LoaderInfo.callOnLoadFinished(LoaderManager.java:427)
	at android.support.v4.app.LoaderManagerImpl$LoaderInfo.onLoadComplete(LoaderManager.java:395)
	at android.support.v4.content.Loader.deliverResult(Loader.java:104)
	at android.support.v4.content.AsyncTaskLoader.dispatchOnLoadComplete(AsyncTaskLoader.java:223)
	at android.support.v4.content.AsyncTaskLoader$LoadTask.onPostExecute(AsyncTaskLoader.java:61)
	at android.support.v4.content.ModernAsyncTask.finish(ModernAsyncTask.java:461)
	at android.support.v4.content.ModernAsyncTask.access$500(ModernAsyncTask.java:47)
	at android.support.v4.content.ModernAsyncTask$InternalHandler.handleMessage(ModernAsyncTask.java:474)
	at android.os.Handler.dispatchMessage(Handler.java:102)
	at android.os.Looper.loop(Looper.java:145)
	at android.app.ActivityThread.main(ActivityThread.java:5944)
	at java.lang.reflect.Method.invoke(Native Method)
	at java.lang.reflect.Method.invoke(Method.java:372)
	at com.android.internal.os.ZygoteInit$MethodAndArgsCaller.run(ZygoteInit.java:1389)
	at com.android.internal.os.ZygoteInit.main(ZygoteInit.java:1184)');


        $this->assertEquals('java.lang.RuntimeException: getImageThumbnailCallbacks onLoadFinished() called & was success
	at com.niceagain.beecount.ui.BasePictureActivity$1.onLoadFinished(BasePictureActivity.java:167)
	at com.niceagain.beecount.ui.BasePictureActivity$1.onLoadFinished(BasePictureActivity.java:156)
', $crash->getShortStackTrace());

    }

}