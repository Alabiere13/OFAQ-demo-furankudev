<?php

namespace App\DataFixtures\Faker;

class TagProvider extends \Faker\Provider\Base
{
    protected static $tags = [
        'Informatique',
        'Sciences',
        'Cinéma',
        'Littérature',
        'Sport',
        'Alimentation',
        'Photographie',
        'Education',
        'Santé',
        'Affaires',
        'Psychologie',
        'Voyages',
    ];

    public static function randomTag(){
        return static::randomElement(static::$tags);
    }
}