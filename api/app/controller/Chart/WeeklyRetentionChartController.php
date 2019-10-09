<?php

namespace Tmpr\Chart\Controller\Chart;

use Tmpr\Chart\Domain\Factory\Chart\Chart;
use Tmpr\Chart\Domain\Factory\Chart\WeeklyCohortsRetentionGenarateChart;
use Tmpr\Chart\Domain\Repository\CsvCustomerDataRepository;
use Tmpr\Chart\Http\ResponseInterface;

class WeeklyRetentionChartController
{
    private $response;
    public function __construct(ResponseInterface $response)
    {
        $this->response=$response;
    }

    public function render()
    {
        try {
            $chart=new Chart(new WeeklyCohortsRetentionGenarateChart(new CsvCustomerDataRepository(ROOTPATH.'/api/resource/csv/export.csv')));
            $weeklyRetention=$chart->createRetentionCharts();
            $chartData=$weeklyRetention->makeChart();
            if(empty($chartData)){
                $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
            }
            $this->response->send(200, $chartData);
        } catch(Exception $e) {
            $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
        }
    }
}
