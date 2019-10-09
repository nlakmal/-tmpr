<?php
namespace Tmpr\Chart\Domain\Repository;

use Tmpr\Chart\Domain\Entity\UserEntity;

    class CsvCustomerDataRepository implements CustomerDataRepositoryInterface
    {
        private $file;

        public function __construct($file)
        {
            $this->file=$file;
        }

        /**
         * @return array
         * @throws \Exception
         */
        public function getAll():array
        {
            $fp = @fopen( $this->file, 'r');
            if(!$fp){
                throw new \Exception("invalid file path");
            }
            $users = array();
            $rowCount=0;
            while(!feof($fp) && ($line = fgetcsv($fp)) !== false) {
                if($rowCount!=0 && isset($line[0])){
                    $userModel=new UserEntity();
                    $row=explode(';',($line[0]));
                    $userModel->setUserId(isset($row[0])?$row[0]:null);
                    $userModel->setCreated(isset($row[1])?$row[1]:null);
                    $userModel->setOnbordingPerentage(isset($row[2])?(int) $row[2]:0);
                    $users[]=$userModel;
                }
                $rowCount++;
            }
            return $users;
        }
    }
