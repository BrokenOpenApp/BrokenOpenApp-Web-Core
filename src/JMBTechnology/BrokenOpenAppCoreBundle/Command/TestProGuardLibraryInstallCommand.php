<?php

namespace JMBTechnology\BrokenOpenAppCoreBundle\Command;


use JMBTechnology\BrokenOpenAppCoreBundle\ProcessCrash;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @license Apache Open Source License 2.0 http://www.apache.org/licenses/LICENSE-2.0
 * @link http://www.brokenopenapp.org/ BrokenOpenApp Home Page for docs and support
 */
class TestProGuardLibraryInstallCommand extends ContainerAwareCommand
{

	protected $proguardRetraceJarFileLocation;

	protected $javaLocation;


	protected function configure()
	{
		$this
			->setName('brokenopenappcore:test-proguard-library-install')
			->setDescription('Test ProGuard library install');

	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{


		$this->javaLocation = $this->getContainer()->hasParameter('jmb_technology_brokenopenapp_core.java_location') ?
			$this->getContainer()->getParameter('jmb_technology_brokenopenapp_core.java_location') : '';
		$this->proguardRetraceJarFileLocation = $this->getContainer()->hasParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') ?
			$this->getContainer()->getParameter('jmb_technology_brokenopenapp_core.proguard_retrace_jar_file_location') : '';

		if (!$this->javaLocation) {
			$output->writeln("Fails because Java Location not set");
			return;
		}
		if (!file_exists($this->javaLocation)) {
			$output->writeln("Fails because Java Location doesn't exist");
			return;
		}

		if (!$this->proguardRetraceJarFileLocation) {
			$output->writeln("Fails because ProGuard Location not set");
			return;
		}
		if (!file_exists($this->proguardRetraceJarFileLocation)) {
			$output->writeln("Fails because ProGuard Location doesn't exist");
			return;
		}


		$mappingFile = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'testProguardInstall'.DIRECTORY_SEPARATOR.'mapping.txt');
		$stacktraceIn = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'testProguardInstall'.DIRECTORY_SEPARATOR.'obscuredTrace.txt');
		$stacktraceOut = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'testProguardInstall'.DIRECTORY_SEPARATOR.'trace.txt');

		$command = $this->javaLocation . " -jar " .
			$this->proguardRetraceJarFileLocation . " " .
			$mappingFile . " " .
			$stacktraceIn;

		$output->writeln("Running command: ".$command);

		$outputLines = array();
		$return_var = null;

		exec($command, $outputLines, $return_var);

		if ($return_var != 0) {
			$output->writeln("Fails because return value is not 0");
		}

		$actualOut = trim(implode("\n", $outputLines));
		$expectedOut = trim(file_get_contents($stacktraceOut));

		if ($actualOut != $expectedOut) {
			$output->writeln("Fails as output different. Got: \n\n".$actualOut);
		} else {
			$output->writeln("PASS");
		}

	}

}

