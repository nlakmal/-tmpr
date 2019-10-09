<?php

namespace Tmpr\Chart\Domain\Factory\Chart;

class Chart
{
    private $chart;

    /**
     * Chart constructor.
     * @param GenarateChartInterface $chart
     */
    public function __construct(GenarateChartInterface $chart) {
        $this->chart = $chart;
    }

    /**
     * @return mixed
     */
    public function createRetentionCharts()
    {
        return $this->chart->createRetentionChart();
    }
}



