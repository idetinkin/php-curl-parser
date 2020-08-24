<?php

namespace curlParser;

use Curl\Curl;

class Parser
{
    /** @var string */
    protected $curlLink;

    /** @var Curl */
    protected $curl;

    /**
     * Parser constructor.
     * @param string $curlLink
     */
    public function __construct($curlLink)
    {
        $this->curlLink = $curlLink;
    }

    /**
     * @return string[]
     */
    protected static function getAvailableOptionClassNames()
    {
        return [
            '-H' => 'CurlOptionHeader',
            '--header' => 'CurlOptionHeader',
            '--compressed' => 'CurlOptionCompressed',
        ];
    }

    /**
     * @return Curl
     * @throws \ErrorException
     */
    public function getCurlObject()
    {
        if (empty($this->curl)) {
            $this->parse();
        }

        return $this->curl;
    }

    /**
     * @return false|resource
     * @throws \ErrorException
     */
    public function getCurlResource()
    {
        return $this->getCurlObject()->curl;
    }

    /**
     * @throws \ErrorException
     */
    protected function parse()
    {
        $this->curl = new Curl();

        $args = \Clue\Arguments\split($this->curlLink);
        for ($i = 0; $i < count($args); $i++) {
            $currentArg = trim($args[$i]);

            if (empty($currentArg)) {
                continue;
            }

            if ($currentArg == 'curl' && $i == 0) {
                continue;
            }

            if ($currentArg[0] == '-') {
                $curlOption = $this->getOption($currentArg);

                if ($curlOption->needValue()) {
                    $i++;
                    if ($i >= count($args)) {
                        throw new \InvalidArgumentException("Option $curlOption requires an argument");
                    }

                    $curlOption->setArgument($args[$i]);
                }

                $curlOption->apply($this->curl);
            } else if ($this->curl->getUrl() == null) {
                $this->curl->setUrl($currentArg);
            } else {
                throw new \InvalidArgumentException("Unrecognized argument or option: $currentArg");
            }
        }
    }

    /**
     * @param string $optionName
     * @return curlOption\BaseCurlOption
     */
    protected function getOption($optionName)
    {
        $availableOptionClassNames = self::getAvailableOptionClassNames();
        if (!array_key_exists($optionName, $availableOptionClassNames)) {
            throw new \InvalidArgumentException("Option $optionName is not supported");
        }

        $optionClassName = "\\curlParser\\curlOption\\" . $availableOptionClassNames[$optionName];
        return new $optionClassName;
    }
}