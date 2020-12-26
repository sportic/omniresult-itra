<?php

namespace Sportic\Omniresult\Itra\Scrapers;

use Sportic\Omniresult\Itra\Parsers\EventPage as Parser;

/**
 * Class CompanyPage
 * @package Sportic\Omniresult\Itra\Scrapers
 *
 * @method Parser execute()
 */
class EventPage extends AbstractScraper
{
    /**
     * @return mixed
     */
    public function getS3Path()
    {
        return $this->getParameter('s3_path');
    }

    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->getParameter('hash');
    }

    /**
     * @throws \Sportic\Omniresult\Common\Exception\InvalidRequestException
     */
    protected function doCallValidation()
    {
        $this->validate('s3_path', 'hash');
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
        return $this->getS3Path()
            . 'results/results-'
            . $this->getHash()
            . '.jsonp';
    }
}
