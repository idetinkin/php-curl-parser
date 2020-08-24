<?php

namespace curlParser\curlOption;

use Curl\Curl;

class CurlOptionHeader extends BaseCurlOption
{
    public function needValue()
    {
        return true;
    }

    public function apply(Curl $curl)
    {
        list($key, $value) = explode(':', $this->argument, 2);
        $curl->setHeader(trim($key), trim($value));
    }
}