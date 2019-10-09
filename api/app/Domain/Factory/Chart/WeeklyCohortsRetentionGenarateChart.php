<?php

namespace Tmpr\Chart\Domain\Factory\Chart;
use Tmpr\Chart\Domain\Repository\CustomerDataRepositoryInterface;

    class WeeklyCohortsRetentionGenarateChart implements GenarateChartInterface
    {
        private $customerdataRepository;
        public function __construct(CustomerDataRepositoryInterface $customerdataRepository)
        {
            $this->customerdataRepository=$customerdataRepository;
        }
        public function createRetentionChart()
        {
            return new WeeklyCohortsRetentionChart($this->customerdataRepository);
        }
    }
