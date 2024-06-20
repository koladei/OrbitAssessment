<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:highest-reviews-day',
    description: 'Add a short description for your command',
)]
class HighestReviewDayCommand extends Command
{
    protected static $defaultName = 'app:highest-reviews-day';

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Displays the day with the highest number of published reviews');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $qb =$this->entityManager->createQueryBuilder();
        $qb->select('DATE_FORMAT(r.publishedAt, \'YYYY-MM-DD\') as date, COUNT(r.id) as review_count')
            ->from('App\Entity\Review', 'r')
            ->groupBy('date')
            ->orderBy('review_count', 'desc')
            ->addOrderBy('date', 'desc');

        $query = $qb->getQuery();
        $query->setMaxResults(1);

        $result = $query->getSingleResult();

        if ($result) {
            $io->success('The day with the highest number of published reviews is: ' . $result['date'] . ' with count of: ' . $result['review_count']);
        } else
        {
            $io->warning('No reviews found.');
        }

        return Command::SUCCESS;
    }
}
