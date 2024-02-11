<?php

namespace App\Choice;

class Planet
{
    const MERCURY = 'mercury';
    const VENUS = 'venus';
    const EARTH = 'earth';
    const MARS = 'mars';
    const JUPITER = 'jupiter';
    const SATURN = 'saturn';
    const URANUS = 'uranus';
    const NEPTUNE = 'neptune';

    public const ALL = [
        self::MERCURY,
        self::VENUS,
        self::EARTH,
        self::MARS,
        self::JUPITER,
        self::SATURN,
        self::URANUS,
        self::NEPTUNE,
    ];

    /**
     * @return array
     */
    public static function getAllWithLabels(): array
    {
        return [
            self::MERCURY => 'Mercury',
            self::VENUS => 'Venus',
            self::EARTH => 'Earth',
            self::MARS => 'Mars',
            self::JUPITER => 'Jupiter',
            self::SATURN => 'Saturn',
            self::URANUS => 'Uranus',
            self::NEPTUNE => 'Neptune',
        ];
    }
}
