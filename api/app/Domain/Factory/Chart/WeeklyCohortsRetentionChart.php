<?php

namespace Tmpr\Chart\Domain\Factory\Chart;

use Tmpr\Chart\Domain\Repository\CustomerDataRepositoryInterface;

    class WeeklyCohortsRetentionChart implements RetentionChartInterface
    {
        private $customerRepository;
        private $onboardingStepsPerentage=[0,20,40,50,70,90,99,100];
        private $userCountForOnboardingStepsPerWeek=[];
        private $onbordingSummary=[];

        public function __construct(CustomerDataRepositoryInterface $customerRepository)
        {
            $this->customerRepository=$customerRepository;
            $this->refershUserCountForOnboardingStepsArray();
        }

        /**
         * @return array
         * @throws \Exception
         */
        public function makeChart(): array
        {
            try {
                $customerEntitySet = $this->customerRepository->getAll();
                $weekStartDate = '';
                $isStartWeek = true;
                foreach ($customerEntitySet as $customerEntity) {
                    if ($isStartWeek) {
                        $weekStartDate = $customerEntity->getCreated();
                        $isStartWeek = false;
                    }
                    $diff = date_diff(date_create($weekStartDate), date_create($customerEntity->getCreated()));
                    if ($diff->format("%R") == '-') {
                        throw new \Exception("Invalid date_diff");
                    }
                    if ((int)$diff->format("%a") == 7) {
                        $this->prepareDataSet($weekStartDate);
                        $isStartWeek = true;
                    }
                    if(!$isStartWeek){
                        $this->countUsersForOnbordingPerentage($customerEntity->getOnbordingPerentage());
                    }

                }
                if(!$isStartWeek) {
                    $this->prepareDataSet($weekStartDate);
                }
                return $this->onbordingSummary;
            } catch(\Exception $e) {
                throw new \Exception("failed to process");
            }
        }

        /**
         * @param string $weekStartDate
         * @return bool
         */
        private function prepareDataSet(string $weekStartDate):bool
        {
            $onbordingWeek = [];
            $onbordingWeek['name'] = $weekStartDate;
            $this->calculateUserPerentageAgainstOnbordingSteps();
            $onbordingWeek['data'] = $this->userCountForOnboardingStepsPerWeek;
            $this->refershUserCountForOnboardingStepsArray();
            array_push($this->onbordingSummary, $onbordingWeek);
            return true;
        }

        /**
         * @param int $customerCurrentOnbordingPerentage
         * @return bool
         * @throws \Exception
         */
        private function countUsersForOnbordingPerentage(int $customerCurrentOnbordingPerentage):bool
        {
            if (!(min($this->onboardingStepsPerentage)<=$customerCurrentOnbordingPerentage) || !(max($this->onboardingStepsPerentage)>=$customerCurrentOnbordingPerentage)) {
                throw new \Exception("Invalid onbording precentage value");
            }
            for ($index = 0; $index < count($this->onboardingStepsPerentage)-1; $index++) {
                if(!isset($this->onboardingStepsPerentage[$index]) || !isset($this->onboardingStepsPerentage[$index + 1])){
                    throw new \Exception("invalid array");
                }
                if ($this->onboardingStepsPerentage[$index] == $customerCurrentOnbordingPerentage || $customerCurrentOnbordingPerentage < $this->onboardingStepsPerentage[$index + 1] ) {
                    $this->userCountForOnboardingStepsPerWeek[$index] +=1;
                    return true;
                } else if($customerCurrentOnbordingPerentage == $this->onboardingStepsPerentage[$index + 1]){
                    $this->userCountForOnboardingStepsPerWeek[$index+1] +=1;
                    return true;
                }
            }
            return true;
        }

        /**
         * @return bool
         */
        private function calculateUserPerentageAgainstOnbordingSteps():bool
        {
            $totalUserCountPerWeek=array_sum($this->userCountForOnboardingStepsPerWeek);
            array_walk($this->userCountForOnboardingStepsPerWeek, function(&$userCountPerStep) use($totalUserCountPerWeek)
            {
                $userCountPerStep = round(((int)$userCountPerStep/$totalUserCountPerWeek)*100);
            }
            );
            $this->userCountForOnboardingStepsPerWeek[0]=100;
            return true;
        }

        private function refershUserCountForOnboardingStepsArray()
        {
            $this->userCountForOnboardingStepsPerWeek=array_fill(0, 8, 0);
        }
    }
