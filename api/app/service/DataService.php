<?php

    class DataService
    {
        private $repository;

        public function __construct(DataRepositoryInterface $repository)
        {
            $this->repository=$repository;
        }
        public function getAllOnbordingUsers()
        {
            return $this->repository->getOnboardingData();
        }

    }
