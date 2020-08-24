<?php

namespace curlParser\curlOption;

use Curl\Curl;

class CurlOptionCompressed extends BaseCurlOption
{
    public function needValue()
    {
        return false;
    }

    public function apply(Curl $curl)
    {
        $curl->setOpt(CURLOPT_ENCODING, '');
    }
}