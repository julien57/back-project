<?php
// For JSON : it's ok for URL's in "/users", limit "/users?limit={{limit}}", filter "/users?name={{filter}}"

// For CSV : it's ok for "/users", limit "/users?limit={{limit}}"

//header("Content-Type:application/json");

use Project\RestCsv;
use Project\RestJson;

require __DIR__ . '/vendor/autoload.php';

/*
$takers = new RestJson();
$jsonCredentials = file_get_contents(RestJson::JSON_FILE);
$arrowTakers = json_decode($jsonCredentials, true);
*/

$takers = new RestCsv();
$row = 1;
if (($handle = fopen(RestCsv::CSV_FILE, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {

        $listTakers[] = explode( ',', $data[0]);
        $row++;
    }
}
$arrowTakers = $listTakers;


if (isset($_GET['limit']) || isset($_GET['offset']) || isset($_GET['name'])) {

    $listTakers = [];
    if (isset($_GET['limit'])) {

        if (isset($_GET['offset'])) {
            $listTakers = $takers->getLimitTakers($arrowTakers, $_GET['limit'], $_GET['offset']);

        } else {
            $listTakers = $takers->getLimitTakers($arrowTakers, $_GET['limit']);
        }
    }

    if (isset($_GET['name'])) {
        $users = $takers->getByName($arrowTakers, $_GET['name']);
        $listTakers = $users;
    }

    if (isset($_GET['offset']) && !isset($_GET['limit'])) {
        $users = $takers->getByOffset($arrowTakers, $_GET['offset']);
        if (!$users) {
            header("HTTP/1.1 400");
            return;
        }
        $listTakers = $users;
    }

    $takersJson = json_encode($listTakers);
    $encodedTakers = stripslashes($takersJson);

    header("HTTP/1.1 200");
    echo $encodedTakers;

} elseif ($_SERVER['REQUEST_URI'] === '/users') {
    $allUsers = json_encode($arrowTakers);
    echo $allUsers;
}
