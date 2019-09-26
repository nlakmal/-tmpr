<?php

interface ResponseInterface
{
    public function send(int $code, array $data);
}



