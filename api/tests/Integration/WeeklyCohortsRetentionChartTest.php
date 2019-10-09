<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Tmpr\Chart\Domain\Factory\Chart\WeeklyCohortsRetentionChart;
use Tmpr\Chart\Domain\Repository\CsvCustomerDataRepository;



final class WeeklyCohortsRetentionChartTest extends TestCase
{

    public function testPassInvalidOnbordingPercentage()
    {
        $weeklyCohortsRetentionChart = new WeeklyCohortsRetentionChart(new CsvCustomerDataRepository('../../resource/csv/test/export_1.csv'));
        $message='';
        try {
            $data = $weeklyCohortsRetentionChart->chart();
        } catch (Exception $e) {
            $message=$e->getMessage();
        }
        $this->assertEquals($message,'failed to process');
    }
    public function testWithDataNotOderByCreateDate()
    {
        $weeklyCohortsRetentionChart=new WeeklyCohortsRetentionChart(new CsvCustomerDataRepository('../../resource/csv/test/export_1.csv'));
        $message='';
        try {
            $data=$weeklyCohortsRetentionChart->chart();
        }catch(Exception $e) {
            $message=$e->getMessage();
        }
        $this->assertEquals($message,'failed to process');
    }

    public function testWithCorrectData()
    {
        $weeklyCohortsRetentionChart=new WeeklyCohortsRetentionChart(new CsvCustomerDataRepository('../../resource/csv/test/export_3.csv'));
        $response=$weeklyCohortsRetentionChart->chart();
        $this->assertEquals('[{"name":"2016-07-19","data":[100,0,69,3,0,0,7,21]}]',json_encode($response));
    }
}

