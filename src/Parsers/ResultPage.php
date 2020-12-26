<?php

namespace Sportic\Omniresult\Itra\Parsers;

use Sportic\Omniresult\Common\Content\RecordContent;
use Sportic\Omniresult\Common\Models\Race;
use Sportic\Omniresult\Common\Models\Result;
use Sportic\Omniresult\Common\Models\Split;

/**
 * Class ResultPage
 * @package Sportic\Omniresult\Itra\Parsers
 */
class ResultPage extends AbstractParser
{
    protected $returnContent = [];

    /**
     * @return array
     */
    protected function generateContent()
    {
        $configArray = $this->getConfigArray();
        $result = $this->parseResult($configArray);
        $this->parseSplits($result, $configArray['records']);

        $params = [
            'record' => $result
        ];

        return $params;
    }

    /**
     * @param $config
     * @return Result
     */
    protected function parseResult($config)
    {
        $parameters = [
            'bib' => $config['bib'],
            'firstname' => $config['firstname'],
            'lastname' => $config['lastname'],
            'gender' => $config['gender'],
            'country' => $config['nationality'],
            'club' => $config['team'],
            'dob' => $config['year'],
            'time' => $config['time'],
            'time_gross' => $config['realtime'],
            'category' => $config['category'],
            'pos_gen' => $config['position'],
            'pos_category' => $config['category_position'],
            'pos_gender' => $config['gender_position'],
        ];

        $race = new Result($parameters);
        return $race;
    }

    /**
     * @param Result $result
     * @param $splits
     * @return Result
     */
    protected function parseSplits($result, $splits)
    {
        array_shift($splits);
        while (count($splits) > 1) {
            $timeConfig = array_shift($splits);
            $splitConfig = array_shift($splits);
            $split = $this->parseSplit($timeConfig, $splitConfig);
            if ($split instanceof Split) {
                $result->getSplits()->add($split);
            }
        }
        return $result;
    }

    /**
     * @param $timeConfig
     * @param $splitConfig
     * @return Split
     */
    protected function parseSplit($timeConfig, $splitConfig)
    {
        $params = [
            'name' => $splitConfig['name'],
            'time' => $timeConfig['items'][0]['detail'],
            'timeFromStart' => $splitConfig['items'][0]['detail'],
        ];
        return new Split($params);
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
        return RecordContent::class;
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritdoc
     */
    public function getModelClassName()
    {
        return Result::class;
    }
}
