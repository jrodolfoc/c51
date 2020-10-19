<?php

namespace App\Command;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A console command that reads a json file and populates offers from it
 *
 * To use this command, open a terminal window, enter into your project
 * directory and execute the following:
 *
 *     $ php bin/console app:populate-offers
 *
 * To output detailed information, increase the command verbosity:
 *
 *     $ php bin/console app:populate-offers -vv
 *
 * See https://symfony.com/doc/current/console.html
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class PopulateOffersCommand extends Command
{
    protected static $defaultName = 'app:populate-offers';

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var OfferRepository
     */
    private $offers;

    /**
     * PopulateOffersCommand constructor.
     * @param EntityManagerInterface $em
     * @param OfferRepository $offers
     */
    public function __construct(EntityManagerInterface $em, OfferRepository $offers)
    {
        parent::__construct();
        $this->entityManager = $em;
        $this->offers = $offers;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Creates offers and stores them in the database')
            ->setHelp($this->getCommandHelp())
            ->addArgument('path', InputArgument::REQUIRED, 'The path to locate the json file')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        $offers_json = '';

        try {
            $offers_json = file_get_contents($path);
        } catch (\Exception $ex) {
            $this->io->error($ex->getMessage());
            return 1;
        }

        $offers = json_decode($offers_json);

        foreach ($offers->offers as $offer) {
            if ($this->offerIdExists($offer->offer_id)) {
                $this->io->success(sprintf('Offer: [%s] already exists and will not be inserted again', $offer->name));
                continue;
            }

            $offerEntity = new Offer($offer->offer_id);
            $offerEntity->setCashBack($offer->cash_back);
            $offerEntity->setImageUrl($offer->image_url);
            $offerEntity->setName($offer->name);

            $this->entityManager->persist($offerEntity);
            $this->io->success(sprintf('Offer: [%s] was successfully created', $offerEntity->getName()));
        }

        $this->entityManager->flush();
        return 0;
    }

    /**
     * Check if an offer with the same id already exists
     * @param int $offer_id
     * @return bool
     */
    private function offerIdExists(int $offer_id): bool
    {
        $existingId = $this->offers->findOneBy(['offer_id' => $offer_id]);
        return null !== $existingId;
    }

    /**
     * @return string
     */
    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command creates new offers and saves them in the database:

  <info>php %command.full_name%</info> <comment>path</comment>
HELP;
    }
}