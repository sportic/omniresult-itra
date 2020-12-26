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
class ResultPage extends AbstractScraper
{

    /**
     * @param $value
     */
    public function setUid($value)
    {
        list($event, $bib) = explode(Helper::slugsSeparator(), $value);
        $this->setParameter('event', $event);
        $this->setParameter('bib', $bib);
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->getParameter('event');
    }

    /**
     * @return mixed
     */
    public function getBib()
    {
        return $this->getParameter('bib');
    }

    /**
     * @inheritdoc
     */
    protected function generateCrawler()
    {
        $client = $this->getClient();
        $crawler = $client->request(
            'GET',
            $this->getCrawlerUri()
        );

        return $crawler;
    }

    /**
     * @return array
     */
    protected function generateParserData()
    {
        $this->getRequest();

        return [
            'response' => $this->getClient()->getResponse(),
        ];
    }

    /**
     * @return string
     */
    public function getCrawlerUri()
    {
        return $this->getApiUriHost()
            . '/events'
            . '/' . $this->getEvent()
            . '/result'
            . '/' . $this->getBib()
            . '/detail';
    }
}
