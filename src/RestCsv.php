<?php

namespace Project;

class RestCsv implements FormatInterface
{
    const CSV_FILE = 'api/testtakers.csv';

    /**
     * @param array $takers
     * @param int $limit
     * @param int|null $offset
     * @return array
     */
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


        foreach ($results as $result) {

            $jsonTakers[] = json_encode([
                'login' => $result[0],
                'password' => $result[1],
                'title' => $result[2],
                'lastname' => $result[3],
                'firstname' => $result[4],
                'gender' => $result[5],
                'email' => $result[6],
                'picture' => $result[7],
                'address' => $result[8],
            ]);
        }

        return $jsonTakers;
    }

    /**
     * @param array $takers
     * @param string $name
     * @return array
     */
    public function getByName(array $takers, string $name): array
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

    /**
     * @param array $takers
     * @param int $offset
     * @return array
     */
    public function getByOffset(array $takers, int $offset): array
    {
        return array_slice($takers, $offset);
    }
}