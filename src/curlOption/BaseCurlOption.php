<?php

namespace curlParser\curlOption;

use Curl\Curl;

abstract class BaseCurlOption
{
    /** @var string */
    protected $argument;

    /**
     * @return boolean
     */
    abstract public function needValue();

    /**
     * @param Curl $curl
     */
    abstract public function apply(Curl $curl);

    /**
     * @param string $argument
     * @return $this
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;
        return $this;
    }
}