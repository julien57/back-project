<?php

namespace Project;

use Project\Entities\Taker;

class RestJson implements FormatInterface
{
    const JSON_FILE = 'api/testtakers.json';

    public function getLimitTakers(array $takers, int $limit, ?int $offset = 0): array
    {
        if (is_null($limit)) {
            $limit = count($takers);
        }

        if (!$offset) {
            $results = array_slice($takers, 0, $limit);
        } else {
            $results = array_slice($takers, $offset, $limit);
        }


        /** @var Taker $result */
        foreach ($results as $result) {
            $jsonTakers[] = json_encode([
                'login' => $result['login'],
                'password' => $result['password'],
                'title' => $result['title'],
                'lastname' => $result['lastname'],
                'firstname' => $result['firstname'],
                'gender' => $result['gender'],
                'email' => $result['email'],
                'picture' => $result['picture'],
                'address' => $result['address'],
            ]);
        }

        return $jsonTakers;
    }

    public function getByName(array $takers, string $name)
    {
       foreach ($takers as $taker) {
           if (!is_array($taker)) {
               $jsonTakers = json_decode($taker, true);
               if (array_search($name, $jsonTakers)) {
                   $user[] = $taker;
               }
           } else {
               if (array_search($name, $taker)) {
                   $user[] = json_encode($taker);
               }
           }
       }

       return $user;
    }

    public function getByOffset(array $takers, int $offset)
    {
        return array_slice($takers, $offset);
    }
}