<?php

namespace APP\Helpers;

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;

/**
 * Helper for building an array of Monolog handlers based on a configuration
 * object
 */
class LogHandlerFactory
{
    /**
     * @var array
     */
    protected $loggingConfig;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->loggingConfig = $config;
    }

    /**
     * Get an array of Monolog handlers based on the configuration passed to the
     * factory
     *
     * @return Monolog\Handler\HandlerInterface[]
     */
    public function getHandlers()
    {
        $handlers = array();
        foreach ($this->loggingConfig as $handlerConfig) {
            $handlers[] = $this->{'get'.$handlerConfig['type'].'Handler'}($handlerConfig);
        }
        return $handlers;
    }

    /**
     * Get a StreamHandler based on a configuration array
     * @param  array $config
     * @return StreamHandler
     */
    protected function getStreamHandler(array $config)
    {
        return new StreamHandler($config['path'], $config['level']);
    }

    /**
     * Get a NullHandler based on a configuration array
     * @param  array $config
     * @return NullHandler
     */
    protected function getNullHandler(array $config)
    {
        return new NullHandler();
    }
}
