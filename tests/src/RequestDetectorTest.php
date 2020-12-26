<?php

namespace Sportic\Omniresult\Itra\Tests;

use Sportic\Omniresult\Itra\RequestDetector;

/**
 * Class RequestDetectorTest
 * @package Sportic\Omniresult\Itra\Tests
 */
class RequestDetectorTest extends AbstractTest
{
    /**
     * @param $url
     * @param $valid
     * @param $action
     * @param $params
     * @dataProvider detectProvider
     */
    public function testDetect($url, $valid, $action, $params)
    {
        $result = RequestDetector::detect($url);

        self::assertSame($valid, $result->isValid());
        self::assertSame($action, $result->getAction());
        self::assertSame($params, $result->getParams());
    }

    /**
     * @return array
     */
    public function detectProvider()
    {
        return [
            [
                'https://itra.run/race/15581&2018',
                true,
                'race',
                ['raceSlug' => '15581&2018']
            ],
            [
                'https://itra.run/race/15581-baneasa-forest-run-march-2018-half-marathon&2018',
                true,
                'race',
                ['raceSlug' => '15581-baneasa-forest-run-march-2018-half-marathon&2018']
            ],
            [
            'https://itra.run/race/15581-baneasa-fmarch-2018-half-marathon&2018',
                true,
                'race',
                ['raceSlug' => '15581-baneasa-fmarch-2018-half-marathon&2018']
            ]
        ];
    }
}
