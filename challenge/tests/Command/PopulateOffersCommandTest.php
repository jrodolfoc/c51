<?php

namespace App\Tests\Command;

use App\Entity\Offer;
use App\Command\PopulateOffersCommand;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class PopulateOffersCommandTest extends KernelTestCase
{
    /**
     * This test ingests data/c51.json twice and asserts that the total number of offers is not affected
     * @test
     */
    public function testRerunC51JsonDoesntIncreaseTotalOffers(): void
    {
        $path = __DIR__ . '/../../../data/c51.json';
        $statusCodeBefore = $this->executeCommand(['path' => $path]);
        $this->assertEquals(0, $statusCodeBefore);

        $offersBefore = self::$container->get(OfferRepository::class)->findAll();
        $statusCodeAfter = $this->executeCommand(['path' => $path]);
        $this->assertEquals(0, $statusCodeAfter);

        $offersAfter = self::$container->get(OfferRepository::class)->findAll();
        $this->assertEquals(count($offersBefore), count($offersAfter));
    }

    /**
     * This test ingests data/test.json and asserts that the entities exist on DB
     * @test
     */
    public function testRunTestJsonAndAssertEntitiesExist(): void
    {
        $path = __DIR__ . '/../../../data/test.json';
        $statusCode = $this->executeCommand(['path' => $path]);
        $this->assertEquals(0, $statusCode);

        $offers_json = file_get_contents($path);
        $offers = json_decode($offers_json);
        /** @var OfferRepository $repository */
        $repository = self::$container->get(OfferRepository::class);

        foreach ($offers->offers as $offer) {
            /** @var Offer $offerEntity */
            $offerEntity = $repository->find($offer->offer_id);
            $this->assertNotNull($offerEntity);

            $this->assertEquals($offer->name, $offerEntity->getName());
            $this->assertEquals($offer->image_url, $offerEntity->getImageUrl());
            $this->assertEqualsWithDelta($offer->cash_back, $offerEntity->getCashBack(), 0.009);
        }
    }

    /**
     * This helper method abstracts the boilerplate code needed to test the execution of a command.
     *
     * @param array $arguments All the arguments passed when executing the command
     * @param array $inputs    The (optional) answers given to the command when it asks for the value of the missing arguments
     * @return int
     */
    private function executeCommand(array $arguments, array $inputs = []): int
    {
        self::bootKernel();

        /** @var Command $command */
        $command = self::$container->get(PopulateOffersCommand::class);
        $command->setApplication(new Application(self::$kernel));

        $commandTester = new CommandTester($command);
        $commandTester->setInputs($inputs);
        $commandTester->execute($arguments);
        return $commandTester->getStatusCode();
    }
}
