<?php

namespace Tmpr\Chart\Domain\Factory\Chart;
use Tmpr\Chart\Domain\Repository\CustomerDataRepositoryInterface;

    class GenarateWeeklyCohortsRetentionChart implements GenarateChartInterface
    {
        private $customerdataRepository;

        /**
         * WeeklyCohortsRetentionGenarateChart constructor.
         * @param CustomerDataRepositoryInterface $customerdataRepository
         */
        public function __construct(CustomerDataRepositoryInterface $customerdataRepository)
        {
            $this->customerdataRepository=$customerdataRepository;
        }

        /**
         * @return mixed|WeeklyCohortsRetentionChart
         */
        public function createRetentionChart()
        {
            return new WeeklyCohortsRetentionChart($this->customerdataRepository);
        }
    }
