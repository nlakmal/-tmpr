<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require_once '../../app/repository/CsvDataRepository.php';
require_once '../../app/service/DataService.php';
require_once '../../app/processor/WeeklyDataProcessor.php';



final class WeeklyDataProcessorTest extends TestCase
{

    public function testPassInvalidOnbordingPercentage()
    {
        $dataService = new DataService(new CsvDataRepository('../../resource/csv/test/export_1.csv'));
        $dataProcessor = new WeeklyDataProcessor($dataService);
        $message='';
        try {
            $data = $dataProcessor->process();
        } catch (Exception $e) {
            $message=$e->getMessage();
        }
        $this->assertEquals($message,'failed to process');
    }
    public function testWithDataNotOderByCreateDate()
    {
        $dataService = new DataService(new CsvDataRepository('../../resource/csv/test/export_2.csv'));
        $dataProcessor=new WeeklyDataProcessor($dataService);
        $message='';
        try {
            $data=$dataProcessor->process();
        }catch(Exception $e) {
            $message=$e->getMessage();
        }
        $this->assertEquals($message,'failed to process');
    }

    public function testWithCorrectData()
    {
        $dataService = new DataService(new CsvDataRepository('../../resource/csv/test/export_3.csv'));
        $dataProcessor=new WeeklyDataProcessor($dataService);
        $response=$dataProcessor->process();
        $this->assertEquals('[{"name":"2016-07-19","data":[100,0,69,3,0,0,7,21]}]',json_encode($response));
    }
}

