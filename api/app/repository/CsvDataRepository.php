<?php

require_once 'DataRepositoryInterface.php';
require_once 'D:/xampp/htdocs/tmpr/api/app/model/UserModel.php';

    class CsvDataRepository implements DataRepositoryInterface
    {
        private $file;

        public function __construct($file)
        {
            $this->file=$file;
        }
        public function getOnboardingData()
        {
            $fp = @fopen( $this->file, 'r');
            if(!$fp){
                var_dump(8);
                throw new Exception("invalid file path");
            }
            $users = array();
            $rowCount=0;
            while(!feof($fp) && ($line = fgetcsv($fp)) !== false) {
                if($rowCount!=0 && isset($line[0])){
                    $userModel=new UserModel();
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
