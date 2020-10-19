<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 *
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class OfferControllerTest extends WebTestCase
{
    /**
     * This test assumes that at least the original 23 offers exist
     * @test
     */
    public function testIndexDefaults(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/offer');
        $this->assertResponseIsSuccessful();

        $filter = $crawler->filter('tbody tr');
        $this->assertGreaterThan(20, count($filter));

        //assert that each row has 3 columns
        for($i = 0; $i < count($filter); $i++) {
            $this->assertCount(3, $filter->eq($i)->filter('td'));
        }
    }

    /**
     * Test that providing sorting parameters doesn't break the page
     * @dataProvider offerSortingProvider
     * @test
     * @param string $uri
     */
    public function testSortingDoesntBreak($uri): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $uri);
        $this->assertResponseIsSuccessful();
        $this->assertGreaterThan(20, count($crawler->filter('tbody tr')));
    }

    /**
     * @return array
     */
    public function offerSortingProvider(): array
    {
        return [
            ['/offer/name/asc'],
            ['/offer/name/desc'],
            ['/offer/cash_back/asc'],
            ['/offer/cash_back/desc'],
            ['/offer/inv/inv'],
            ['/offer/inv/asc'],
            ['/offer/name/inv'],
        ];
    }
}