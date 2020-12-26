<?php

namespace Sportic\Omniresult\Itra\Scrapers;

use ByTIC\GouttePhantomJs\Clients\ClientFactory;
use Goutte\Client;

/**
 * Class AbstractScraper
 * @package Sportic\Omniresult\Itra\Scrapers
 */
abstract class AbstractScraper extends \Sportic\Omniresult\Common\Scrapers\AbstractScraper
{
    /** @noinspection PhpMissingParentCallCommonInspection
     * @return Client
     */
    protected function generateClient(): Client
    {
        return ClientFactory::getGoutteClient();
    }
}
