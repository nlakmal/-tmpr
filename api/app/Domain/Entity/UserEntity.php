<?php

namespace Tmpr\Chart\Domain\Entity;

class UserEntity extends AbstractEntity
    {
        private $userId;
        private $created;
        private $onbordingPercentage;

    /**
     * @param int $userId
     * @return $this
     */
        public function setUserId(int $userId)
        {
            $this->userId=$userId;
            return $this;
        }

    /**
     * @return int
     */
        public function getUserId():int
        {
            return $this->userId;
        }

    /**
     * @param string $created
     * @return $this
     */
        public function setCreated(string $created)
        {
            $this->created=$created;
            return $this;
        }

    /**
     * @return string
     */
        public function getCreated(): string
        {
             return $this->created;
        }

    /**
     * @param int $onbordingPercentage
     * @return $this
     */
        public function setOnbordingPerentage(int $onbordingPercentage)
        {
            $this->onbordingPercentage=$onbordingPercentage;
            return $this;
        }

    /**
     * @return int
     */
        public function getOnbordingPerentage():int
        {
            return $this->onbordingPercentage;
        }

    }
