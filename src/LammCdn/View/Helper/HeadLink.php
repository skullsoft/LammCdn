<?php

namespace LammCdn\View\Helper;

use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\Uri\Http as HttpUri;
use Zend\View\Helper\HeadLink as BaseHeadLink;

class HeadLink extends BaseHeadLink
{

    /**
     * Cdn config, array of server config
     * @var array
     */
    protected $cdnConfig;

    /**
     * Current server id used
     * @var integer
     */
    protected static $serverId;

    /**
     *
     * @var string
     */
    protected static $lastCommit;

    /**
     * Construct the cdn helper
     *
     * @param array $cdnConfig
     */
    public function __construct(array $cdnConfig)
    {
        $this->setCdnConfig($cdnConfig);
        parent::__construct();
    }

    /**
     * Set the Cdn servers config
     *
     * @param  array      $cdnConfig
     * @return HeadScript
     */
    public function setCdnConfig(array $cdnConfig)
    {
        if (empty($cdnConfig)) {
            throw new InvalidArgumentException('Cdn config must be not empty');
        }
        $configs = array();
        foreach ($cdnConfig as $cdn) {
            if (!is_array($cdn)) {
                throw new InvalidArgumentException('Cdn config must be an array of cdn arrays');
            }
            $configs[] = $cdn;
        }
        $this->cdnConfig = $configs;
        static::$serverId = 0;

        return $this;
    }

    /**
     * append()
     *
     * @param  array                              $value
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function append($value)
    {
        $this->cdn($value);
        parent::append($value);
    }

    /**
     * prepend()
     *
     * @param  array                              $value
     * @return HeadLink
     * @throws Exception\InvalidArgumentException
     */
    public function prepend($value)
    {
        $this->cdn($value);
        parent::prepend($value);
    }

    /**
     * set()
     *
     * @param  array                              $value
     * @return HeadLink
     * @throws Exception\InvalidArgumentException
     */
    public function set($value)
    {
        $this->cdn($value);
        parent::set($value);
    }

    /**
     * offsetSet()
     *
     * @param  string|int                         $index
     * @param  array                              $value
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function offsetSet($index, $value)
    {
        $this->cdn($value);
        parent::offsetSet($index, $value);
    }

    /**
     * Construct the cdn url
     * @param  \StdClass  $value
     * @return HeadScript
     */
    protected function cdn(\StdClass $value)
    {
        if (!isset($this->cdnConfig[static::$serverId])) {
            static::$serverId = 0;
        }
        $config = $this->cdnConfig[static::$serverId];
        $uri = new HttpUri($value->href);
        if ($uri->getHost()) {
            return false;
        }
        $uri->setScheme($config['scheme']);
        $uri->setPort($config['port']);
        $uri->setHost($config['host']);
        $uri->setQuery($this->getLastCommit());
        $value->href = $uri->toString();
        static::$serverId++;

        return $this;
    }

    public function getLastCommit()
    {
        $lc_file = ROOT_PATH . '/last_commit';

        if (is_readable($lc_file)) {
            if (!isset(self::$lastCommit)) {
                self::$lastCommit = trim(file_get_contents($lc_file));
            }
        }

        return self::$lastCommit;
    }

}
