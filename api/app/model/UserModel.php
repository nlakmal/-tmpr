<?php

class UserModel
    {
        private $userId;
        private $created;
        private $onbordingPerentage;

        public function setUserId(int $userId)
        {
            $this->userId=$userId;
            return $this;
        }

        public function getUserId():int
        {
            return $this->userId;
        }

        public function setCreated(string $created)
        {
            $this->created=$created;
            return $this;
        }

        public function getCreated(): string
        {
             return $this->created;
        }

        public function setOnbordingPerentage(int $onbordingPerentage)
        {
            $this->onbordingPerentage=$onbordingPerentage;
            return $this;
        }

        public function getOnbordingPerentage():int
        {
            return $this->onbordingPerentage;
        }

    }
