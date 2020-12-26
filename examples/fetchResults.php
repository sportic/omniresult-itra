<?php

require '../vendor/autoload.php';

$parameters = [
    'raceid' => '15581',
    'year' => '2018',
    'page' => '1',
];

$client = new \Sportic\Omniresult\Itra\ItraClient();
$resultsParser = $client->results($parameters);

/** @var \Sportic\Omniresult\Common\Content\ListContent $data */
$data = $resultsParser->getContent();

var_dump($data->getRecords());
