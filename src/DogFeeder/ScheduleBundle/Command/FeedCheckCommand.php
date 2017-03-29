<?php
/**
 * Created by PhpStorm.
 * User: miskolczicsego
 * Date: 2017.03.26.
 * Time: 19:06
 */

namespace DogFeeder\ScheduleBundle\Command;


use DogFeeder\FeederBundle\Controller\FeedController;
use DogFeeder\FeederBundle\Controller\FeederController;
use DogFeeder\FeederBundle\Entity\FeedHistory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\Date;

class FeedCheckCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('feed:check')
            ->setDescription('Check which scheduled feeds are ready to execute');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $schedule = $em->getRepository('ScheduleBundle:Schedule')->getFirstScheduleByDate();
        $config = $this->getContainer()->get('config');

        $isScheduledFeedOn = $config->getValue('schedule_feed', $schedule->getUserId());

        if (!$isScheduledFeedOn) {
            $output->writeln("Automatikus etetés kikapcsolva");
            return;
        }

        if($schedule->getNumberOfFeedPerDay() == $schedule->getFeedCounter()){
            $output->writeln("Elérted a beállított etetések számát mára.");
            $schedule->setFeedCounter(0);
            return;
        }


        $feeder = $em->getRepository('FeederBundle:Feeder')->getFeederToSchedule($schedule->getId());
        $hour = date("G");

        if( $schedule->getFeedHour1()== $hour ||
            $schedule->getFeedHour2() == $hour ||
            $schedule->getFeedHour3() == $hour ||
            $schedule->getFeedHour4() == $hour ||
            $schedule->getFeedHour5() == $hour )  {

            // itt lesz majd a feed metódus hívva de amíg tesztelem addig nem kell ide rakni mert sosem fog lefutni az etetés
        }
        $this->feed($feeder, $schedule);
    }

    public function feed($feeder, $schedule)
    {
        $output = array();
      $output = shell_exec("python /var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/feed.py");
//        $output = shell_exec("python /var/www/html/DFProject/src/DogFeeder/FeederBundle/Resources/files/test.py");
        $stat = new FeedHistory();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $schedule->setFeedCounter($schedule->getFeedCounter() + 1);
        $stat->setQuantity($output == FeedController::SUCCESSFULL_FEED_RESPONESE ? $schedule->getQuantity() : 0);
        $stat->setDescription($output);
        $stat->setFeeder($feeder);

        $em->persist($stat);
        $em->flush();
    }
}