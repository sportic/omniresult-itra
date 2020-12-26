<?php

namespace Sportic\Omniresult\Itra\Tests\Scrapers;

use Sportic\Omniresult\Itra\Scrapers\ResultsPage;
use Sportic\Omniresult\Itra\Tests\AbstractTest;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ResultsPageTest
 * @package Sportic\Omniresult\Itra\Tests\Scrapers
 */
class ResultsPageTest extends AbstractTest
{

    public function test_getCrawlerHtml()
    {
        $scraper = $this->getScraper();
        $crawler = $scraper->getCrawler();

        static::assertInstanceOf(Crawler::class, $crawler);

        $response = $scraper->getClient()->getResponse();
        $responseContent = $response->getContent();
        static::assertStringContainsString('FILIPESCU', $responseContent);
        file_put_contents(TEST_FIXTURE_PATH . '/Parsers/ResultsPage/SimpleEvent/results.json', $responseContent);
    }

    /**
     * @return ResultsPage
     */
    protected function getScraper(): ResultsPage
    {
        $params = [
            'raceid' => '15581',
            'year' => '2018',
            'page' => '1',
        ];
        $scraper = new ResultsPage();
        $scraper->initialize($params);
        return $scraper;
    }
}
