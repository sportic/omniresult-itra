<?php

namespace Sportic\Omniresult\Itra\Parsers;

use Sportic\Omniresult\Common\Content\ListContent;
use Sportic\Omniresult\Common\Models\Race;

/**
 * Class EventPage
 * @package Sportic\Omniresult\Itra\Parsers
 */
class EventPage extends AbstractParser
{
    protected $returnContent = [];

    /**
     * @return array
     */
    protected function generateContent()
    {
        $configArray = $this->getConfigArray();
        $races = $this->parseRaces($configArray);

        $params = [
            'records' => $races
        ];

        return $params;
    }

    /**
     * @param $config
     * @return Race[]
     */
    public function parseRaces($config)
    {
        $racesArray = $config['ga'];
        $return = [];
        foreach ($racesArray as $raceArray) {
            $return[] = $this->parseRace($raceArray);
        }
        return $return;
    }

    /**
     * @param $config
     * @return Race
     */
    protected function parseRace($config)
    {
        $parameters = [
            'id' => $config['id'],
            'name' => $config['nm'],
            'endpoint' => $config['cl'][0]['da'],
        ];
        $race = new Race($parameters);
        return $race;
    }

    /**
     * @return array
     */
    protected function getConfigArray()
    {
        $configHtml = $this->getConfigString();

        $data = json_decode($configHtml, true);
        return $data;
    }

    /**
     * @return mixed|string
     */
    protected function getConfigString()
    {
        $string = $this->getResponse()->getContent();
        $string = str_replace('jresults(', '', $string);
        $string = str_replace(');', '', $string);

        return $string;
    }


    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     */
    protected function getContentClassName()
    {
        return ListContent::class;
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     */
    public function getModelClassName()
    {
        return Race::class;
    }
}
