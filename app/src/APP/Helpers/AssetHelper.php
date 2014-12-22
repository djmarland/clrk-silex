<?php

namespace APP\Helpers;

use InvalidArgumentException;
use Twig_Extension;
use Twig_SimpleFunction;

class AssetHelper extends Twig_Extension
{
    const HTTP_STATIC_PREFIX = '/';
    const HTTPS_STATIC_PREFIX = '/';

    protected $assetVersion;
    protected $componentName;
    protected $staticPrefix;
    protected $useRemoteAssets = false;

    public function __construct($componentName, $assetVersion)
    {
        if (!is_string($componentName)) {
            throw new InvalidArgumentException('$componentName must be a string');
        }

        if (!is_string($assetVersion)) {
            throw new InvalidArgumentException('$assetVersion must be a string');
        }

        $this->componentName = $componentName;
        $this->assetVersion = $assetVersion;

        $isHttps = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
        $this->staticPrefix = $isHttps ? self::HTTPS_STATIC_PREFIX : self::HTTP_STATIC_PREFIX;

        // If we have enough information to use remote assets then enable them
        if ($this->componentName && $this->assetVersion) {
            $this->useRemoteAssets = true;
        }
    }

    public function getName()
    {
        return "asset";
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('asset', array($this, 'assetFunction')),
        );
    }

    public function assetFunction($path)
    {
        if ($this->useRemoteAssets) {
            return "{$this->staticPrefix}/s/{$this->componentName}/{$this->assetVersion}/{$path}";
        }

        return '/static/' . $path;
    }
}
