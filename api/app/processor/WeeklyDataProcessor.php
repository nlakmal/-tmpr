<?php

require_once 'DataProcessorInterface.php';

    class WeeklyDataProcessor implements DataProcessorInterface
    {
        private $dataService;
        private $onboardingStepsPerentage=[0,20,40,50,70,90,99,100];
        private $userCountForOnboardingStepsPerWeek=[];
        private $onbordingSummary=[];

        public function __construct(DataService $dataService)
        {
            $this->dataService=$dataService;
            $this->refershUserCountForOnboardingStepsArray();
        }
        public function process()
        {
            try {
                $data = $this->dataService->getAllOnbordingUsers();
                $weekStartDate = '';
                $isStartWeek = true;
                foreach ($data as $user) {
                    if (!$user instanceof UserModel) {
                        throw new Exception("Invalid data model");
                    }
                        if ($isStartWeek) {
                            $weekStartDate = $user->getCreated();
                            $isStartWeek = false;
                        }
                        $diff = date_diff(date_create($weekStartDate), date_create($user->getCreated()));
                        if ($diff->format("%R") == '-') {
                            throw new Exception("Invalid date_diff");
                        }
                        if ((int)$diff->format("%a") == 7) {
                            $this->prepareDataSet($weekStartDate);
                            $isStartWeek = true;
                        }
                        if(!$isStartWeek){
                            $this->countUsersForOnbordingPerentage($user->getOnbordingPerentage());
                        }

                }
                if(!$isStartWeek) {
                    $this->prepareDataSet($weekStartDate);
                }
                return $this->onbordingSummary;
            } catch(Exception $e) {
             throw new Exception("failed to process");
            }
        }
        private function prepareDataSet($weekStartDate)
        {
            $onbordingWeek = [];
            $onbordingWeek['name'] = $weekStartDate;
            $this->calculateUserPerentageAgainstOnbordingSteps();
            $onbordingWeek['data'] = $this->userCountForOnboardingStepsPerWeek;
            $this->refershUserCountForOnboardingStepsArray();
            array_push($this->onbordingSummary, $onbordingWeek);
            return true;
        }
        private function countUsersForOnbordingPerentage($customerCurrentOnbordingPerentage)
        {
            if (!(min($this->onboardingStepsPerentage)<=$customerCurrentOnbordingPerentage) || !(max($this->onboardingStepsPerentage)>=$customerCurrentOnbordingPerentage)) {
                throw new Exception("Invalid onbording precentage value");
            }
            for ($index = 0; $index < count($this->onboardingStepsPerentage)-1; $index++) {
                if(!isset($this->onboardingStepsPerentage[$index]) || !isset($this->onboardingStepsPerentage[$index + 1])){
                    throw new Exception("invalid array");
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
        private function calculateUserPerentageAgainstOnbordingSteps()
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
