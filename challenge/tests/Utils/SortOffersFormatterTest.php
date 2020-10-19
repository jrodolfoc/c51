<?php

namespace App\Tests\Utils;

use App\Utils\SortOffersFormatter;
use PHPUnit\Framework\TestCase;

/**
 * Test for sorting and direction given by SortOffersFormatter
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class SortOffersFormatterTest extends TestCase
{
    /**
     * Test asserts that an invalid column defaults to sort by name
     * @test
     */
    public function testInvalidSortColumn(): void
    {
        $sorter = new SortOffersFormatter('non-existing-column', '');
        $this->assertEquals('name', $sorter->getSort());
    }

    /**
     * @dataProvider validColumnProvider
     * @param string $column
     * @test
     */
    public function testValidSortColumn(string $column): void
    {
        $sorter = new SortOffersFormatter($column, '');
        $this->assertEquals($column, $sorter->getSort());
    }

    /**
     * Test asserts that an invalid direction defaults to "asc"
     * @test
     */
    public function testInvalidSortDirection(): void
    {
        $sorter = new SortOffersFormatter('', 'non-direction');
        $this->assertEquals('asc', $sorter->getDirection());
    }

    /**
     * @dataProvider validDirectionsProvider
     * @param string $direction
     * @test
     */
    public function testValidSortDirection(string $direction): void
    {
        $sorter = new SortOffersFormatter('', $direction);
        $this->assertEquals($direction, $sorter->getDirection());
    }

    /**
     * @dataProvider nextDirectionsProvider
     * @param string $column
     * @param string $direction
     * @param string $next_direction
     * @test
     */
    public function testValidSortNextDirection(string $column, string $direction, string $next_direction): void
    {
        $sorter = new SortOffersFormatter($column, $direction);
        $this->assertEquals($next_direction, $sorter->calculateNextDirection($column));
    }

    /**
     * Provider of valid sortable columns
     * @return array
     */
    public function validColumnProvider(): array
    {
        return [
            ['name'],
            ['cash_back']
        ];
    }

    /**
     * Provider of valid sortable directions
     * @return array
     */
    public function validDirectionsProvider(): array
    {
        return [
            ['asc'],
            ['desc']
        ];
    }

    /**
     * Provider of valid sortable columns, directions and next directions
     * @return array
     */
    public function nextDirectionsProvider(): array
    {
        return [
            ['name', 'asc', 'desc'],
            ['name', 'desc', 'asc'],
            ['cash_back', 'asc', 'desc'],
            ['cash_back', 'desc', 'asc'],
        ];
    }
}