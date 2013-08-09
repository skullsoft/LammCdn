<?php

namespace LammCdn\View\Helper;

use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Uri\Http as HttpUri;


class Elements extends Link
{

    public function cdn($src)
    {
        if (!$this->getEnabled()) {
            return $src;
        }
        if (!is_string($src)) {
            throw new InvalidArgumentException('Source image must be a string');
        }
        if (!isset($this->cdnConfig[static::$serverId])) {
            static::$serverId = 0;
        }
        $config = $this->cdnConfig[static::$serverId];
        $uri = new HttpUri($src);
        if ($uri->getHost()) {
            return $uri->toString();
        }
        $uri->setScheme($config['scheme']);
        $uri->setPort($config['port']);
        $uri->setHost($config['host']);
        $uri->setQuery($this->getLastCommit());

        return $uri->toString();
    }

    /**
     *
     * @todo upgrade codigo
     * @return string
     */
    public function getUrl()
    {
        $uri = new HttpUri();
        $config = $this->cdnConfig[0];
        $uri->setScheme($config['scheme']);
        $uri->setPort($config['port']);
        $uri->setHost($config['host']);

        return $uri->toString();
    }

}


