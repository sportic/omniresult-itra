<?php

namespace Sportic\Omniresult\Itra;

use Sportic\Omniresult\Common\RequestDetector\HasDetectorTrait;
use Sportic\Omniresult\Common\TimingClient;
use Sportic\Omniresult\Itra\Scrapers\EventPage;
use Sportic\Omniresult\Itra\Scrapers\ResultPage;
use Sportic\Omniresult\Itra\Scrapers\ResultsPage;

/**
 * Class ItraClient
 * @package Sportic\Omniresult\Itra
 */
class ItraClient extends TimingClient
{
    use HasDetectorTrait;

    /**
     * @param $parameters
     * @return \Sportic\Omniresult\Common\Parsers\AbstractParser|Parsers\EventPage
     */
    public function event($parameters)
    {
        return $this->executeScrapper(EventPage::class, $parameters);
    }

    /**
     * @param $parameters
     * @return \Sportic\Omniresult\Common\Parsers\AbstractParser|Parsers\ResultsPage
     */
    public function results($parameters)
    {
        return $this->executeScrapper(ResultsPage::class, $parameters);
    }

    /**
     * @param $parameters
     * @return \Sportic\Omniresult\Common\Parsers\AbstractParser|Parsers\ResultPage
     */
    public function result($parameters)
    {
        return $this->executeScrapper(ResultPage::class, $parameters);
    }
}
