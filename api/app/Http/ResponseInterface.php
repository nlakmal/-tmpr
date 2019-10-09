<?php

namespace Tmpr\Chart\Http;

interface ResponseInterface
{
    /**
     * @param int $code
     * @param array $data
     * @return mixed
     */
    public function send(int $code, array $data);
}



