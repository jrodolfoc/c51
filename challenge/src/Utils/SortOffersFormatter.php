<?php

namespace App\Utils;

/**
 * Class that controls sorting and direction for offers
 *
 * @author Jose Calvo <jrodolfoc@gmail.com>
 */
class SortOffersFormatter
{
    const SORT_COLUMNS = ['name', 'cash_back'];
    const SORT_DIRECTIONS = ['asc', 'desc'];

    /**
     * @var string
     */
    private $sort;

    /**
     * @var string
     */
    private $direction;

    /**
     * SortOffersFormatter constructor.
     * @param string $sort
     * @param string $direction
     */
    public function __construct(string $sort, string $direction)
    {
        $this->sort = in_array(strtolower($sort), self::SORT_COLUMNS) ?
            $sort : self::SORT_COLUMNS[0];

        $this->direction = in_array(strtolower($direction), self::SORT_DIRECTIONS) ?
            $direction : self::SORT_DIRECTIONS[0];
    }

    /**
     * @param $column
     * @return string
     */
    public function calculateNextDirection($column): string
    {
        if ($column != $this->sort) {
            return self::SORT_DIRECTIONS[0];
        }

        return $this->direction == self::SORT_DIRECTIONS[0] ?
            self::SORT_DIRECTIONS[1] : self::SORT_DIRECTIONS[0];
    }

    /**
     * @return string
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}
