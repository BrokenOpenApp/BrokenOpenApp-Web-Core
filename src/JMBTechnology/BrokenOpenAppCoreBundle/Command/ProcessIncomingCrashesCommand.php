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
class ProcessIncomingCrashesCommand extends ContainerAwareCommand
{

	protected function configure()
	{
		$this
			->setName('brokenopenappcore:process-incoming-crashes')
			->setDescription('Process Incoming Crashes');

	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$doctrine = $this->getContainer()->get('doctrine')->getManager();

		$processCrash = new ProcessCrash(
			$doctrine,
			$this->getContainer()->get('mailer'),
			$this->getContainer()->get('twig'),
			$this->getContainer()->getParameter('notifications_from'));

		$crashRepo = $doctrine->getRepository('JMBTechnologyBrokenOpenAppCoreBundle:Crash');
		$crashIDs = $crashRepo->newCrashesToProcessQuery()->setMaxResults(100)->getResult();
		foreach($crashIDs as $crashID) {

			$output->writeln('Crash ID '. $crashID['id']);
			$crash = $crashRepo->find($crashID);
			$processCrash->process($crash);

		}

		$output->writeln('Done');
	}

}

