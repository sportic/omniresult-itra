<?php

namespace Sportic\Omniresult\Itra\Scrapers;

use Sportic\Omniresult\Itra\Helper;
use Sportic\Omniresult\Itra\Parsers\EventPage as Parser;

/**
 * Class CompanyPage
 * @package Sportic\Omniresult\Itra\Scrapers
 *
 * @method Parser execute()
 */
class ResultsPage extends AbstractScraper
{
    /**
     * @inheritdoc
     */
    protected function generateCrawler(): \Symfony\Component\DomCrawler\Crawler
    {
        $client = $this->getClient();

        $initialRequest = $client->request(
            'GET',
            'https://itra.run/race/'.$this->getParameter('raceid').'&'.$this->getParameter('year').'#raceResults'
        );

        // Get the cookie Jar
        $cookieJar = $client->getCookieJar();

        return $client->request(
            'POST',
            'https://itra.run/racedata/results',
            $this->generatePostData(),
            [],
            [
                'HTTP_X-XSRF-TOKEN' => $cookieJar->get('XSRF-TOKEN')->getValue()
            ]
        );
    }

    /**
     * @return array
     */
    protected function generatePostData(): array
    {
        return [
            'raceid' => $this->getParameter('raceid'),
            'year' => $this->getParameter('year'),
            'page' => $this->getParameter('page', 1)
        ];
    }
}
