<?php
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
include('../vendor/autoload.php');
use Tmpr\Chart\Http\Request;
use Tmpr\Chart\Controller\Chart\WeeklyRetentionChartController;
use Tmpr\Chart\Http\JsonResponse;

$request = new Request($_SERVER);

if ($request->isMethod('get')) {
    if ($request->isAction('/api/weekly')) {
        $WeeklyRetentionChartController=new WeeklyRetentionChartController(new JsonResponse());
        $WeeklyRetentionChartController->render();
    }
}
