<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.29.
 * Time: 17:40
 */

namespace DogFeeder\ScheduleBundle\Command;


use DogFeeder\FeederBundle\Controller\FeedController;
use DogFeeder\FeederBundle\Controller\FeederController;
use DogFeeder\FeederBundle\Entity\FeedHistory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\Date;

class CounterResetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('counter:reset')
            ->setDescription('Reset schedule counter');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $schedule = $em->getRepository('ScheduleBundle:Schedule')->getFirstScheduleByDate();
        $schedule->setFeedCounter(0);
        $em->flush();

        $output->writeln("Done");
    }
}