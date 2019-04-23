<?php

namespace App\DataFixtures\Faker;

use Unirest\Request;

class UserProvider extends \Faker\Provider\Base
{
    protected static $users = [];

    public function __construct($generator)
    {
        parent::__construct($generator);
        $headers = array('Accept' => 'application/json', 'Content-Type' => 'application/x-php-serialized');
        for ($i = 1; $i < 5; $i++) {
            $characters = Request::get('https://swapi.co/api/people/?page=' . $i, $headers)->body->results;
            foreach ($characters as $character) {
                static::$users[] = $character->{'name'};
            }
        }
    }

    public static function randomSWUsername()
    {
        return static::randomElement(static::$users);
    }
}