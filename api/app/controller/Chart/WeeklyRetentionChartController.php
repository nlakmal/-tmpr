<?php

namespace Tmpr\Chart\Controller\Chart;

use Tmpr\Chart\Domain\Factory\Chart\Chart;
use Tmpr\Chart\Domain\Factory\Chart\GenarateWeeklyCohortsRetentionChart;
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
            $chartBuilder=new Chart(new GenarateWeeklyCohortsRetentionChart(new CsvCustomerDataRepository(ROOTPATH.'/api/resource/csv/export.csv')));
            $weeklyRetentionChart=$chartBuilder->createRetentionCharts();
            $chartData=$weeklyRetentionChart->makeChart();
            if(empty($chartData)){
                $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
            }
            $this->response->send(200, $chartData);
        } catch(Exception $e) {
            $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
        }
    }
}
