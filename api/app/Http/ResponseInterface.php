<?php

namespace Tmpr\Chart\Http;

interface ResponseInterface
{
    public function send(int $code, array $data);
}



