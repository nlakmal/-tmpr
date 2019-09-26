<?php

require_once '../config/Request.php';
require_once '../app/response/JsonResponse.php';
require_once '../app/repository/CsvDataRepository.php';
require_once '../app/service/DataService.php';
require_once '../app/processor/WeeklyDataProcessor.php';
require_once '../app/controller/ApiController.php';

$request = new Request($_SERVER);
$response=new JsonResponse();

if ($request->isMethod('get')) {
    if ($request->isAction('/api/weekly')) {
        $dataService = new DataService(new CsvDataRepository('../resource/csv/export.csv'));
        $dataProcessor=new WeeklyDataProcessor($dataService);
        $controller=new ApiController($dataProcessor,$response);
        $controller->index();
    }
    $response->send(501, ['error'=>'unknown action: ' . $request->getUri()]);
}
$response->send(500, ['error'=>'Unknown error']);