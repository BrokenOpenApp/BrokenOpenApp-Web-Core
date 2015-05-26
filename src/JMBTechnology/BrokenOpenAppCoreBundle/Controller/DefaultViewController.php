<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Controller;

use Doctrine\ORM\Mapping\Entity;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use JMBTechnology\BrokenOpenAppCoreBundle\Entity\Crash;


/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class DefaultViewController extends Controller
{

    /**
     * Get the common paramaters to pass to the views
     */
    public function getViewParameters($additionalParameters=array()) {
    	return array_merge( array(

    		), $additionalParameters);
    }

	protected function isProGuardIntegrationSupported() {
		$javaLocation = $this->container->hasParameter('jmb_technology_brokenopenapp_core.java_location') ?
			$this->container->getParameter('jmb_technology_brokenopenapp_core.java_location') : '';
		$proguardRetraceJarFileLocation = $this->container->hasParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') ?
			$this->container->getParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') : '';
		return $javaLocation && $proguardRetraceJarFileLocation && file_exists($javaLocation) && file_exists($proguardRetraceJarFileLocation);
	}

	protected function isCurrentUserCreateProject() {
		$user = $this->getUser();
		return $user && ($user->getIsCreateProject() || $user->getIsSuperAdmin());
	}

}
