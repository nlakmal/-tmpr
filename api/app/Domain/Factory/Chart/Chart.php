<?php

namespace Tmpr\Chart\Domain\Factory\Chart;

class Chart
{
    private $chart;
    public function __construct(GenarateChartInterface $chart) {
        $this->chart = $chart;
    }
    public function createRetentionCharts()
    {
        return $this->chart->createRetentionChart();
    }
}



