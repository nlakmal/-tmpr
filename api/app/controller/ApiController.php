<?php

class ApiController
{
    private $dataProcessor;
    private $response;

    public function __construct(DataProcessorInterface $dataProcessor,ResponseInterface $response)
    {
        $this->dataProcessor=$dataProcessor;
        $this->response=$response;
    }
    public function index()
    {
        try {
            $data=$this->dataProcessor->process();
            if(empty($data)){
                $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
            }
            $this->response->send(200, $data);
        } catch(Exception $e) {
            $this->response->send(400, ['error'=>'Failed to generate weekly data set']);
        }
    }
}
