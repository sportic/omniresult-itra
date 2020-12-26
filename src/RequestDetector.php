<?php

namespace Sportic\Omniresult\Itra;

use \Sportic\Omniresult\Common\RequestDetector\Detectors\AbstractUrlDetector;

/**
 * Class RequestDetector
 * @package Sportic\Omniresult\Itra
 */
class RequestDetector extends AbstractUrlDetector
{
    protected $pathParts = null;

    /**
     * @inheritdoc
     */
    protected function isValidRequest(): bool
    {
        if (in_array(
            $this->getUrlComponent('host'),
            ['www.itra.run', 'itra.run']
        )) {
            return true;
        }
        return parent::isValidRequest();
    }

    /**
     * @return string
     */
    protected function detectAction(): string
    {
        $pathParts = $this->getPathParts();

        if ($pathParts[0] != 'race') {
            return '';
        }
        if (count($pathParts) == 2) {
            return 'race';
        }
        return '';
    }

    /**
     * @inheritdoc
     */
    protected function detectParams()
    {
        $pathParts = $this->getPathParts();

        $return = [];
        $return['raceSlug'] = $pathParts[1];

        return $return;
    }

    /**
     * @return array
     */
    public function getPathParts(): array
    {
        if ($this->pathParts === null) {
            $this->detectUrlPathParts();
        }
        return $this->pathParts;
    }

    protected function detectUrlPathParts()
    {
        $path = strtolower($this->getUrlComponent('path'));
        $path = trim($path, '/');
        $this->pathParts = explode('/', $path);
    }
}
