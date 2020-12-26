<?php

namespace Sportic\Omniresult\Itra\Parsers;

use Sportic\Omniresult\Common\Content\ListContent;
use Sportic\Omniresult\Common\Models\Result;
use Sportic\Omniresult\Itra\Helper;

/**
 * Class ResultsPage
 * @package Sportic\Omniresult\Itra\Parsers
 */
class ResultsPage extends AbstractParser
{

    /**
     * @return array
     */
    protected function generateContent()
    {
        $json = $this->getResponse()->getContent();
        $rawData = json_decode($json);
        if (!is_array($rawData) || count($rawData) < 1) {
            return [];
        }

        return [
            'records' => $this->parseResults($rawData)
        ];
    }

    /**
     * @param $config
     * @return array
     */
    protected function parseResults($data): array
    {
        $return = [];
        foreach ($data as $item) {
            $return[] = $this->parseResult($item);
        }
        return $return;
    }

    /**
     * @param $data
     * @return Result
     */
    protected function parseResult($data)
    {
        $matches = [
            'posGen' => 'place',
            'id' => 'id',
            'bib' => 'bi',
            'full_name' => 'nom_coureur',
            'first_name' => 'nom',
            'last_name' => 'prenom',
            'gender' => 'sexe',
            'country' => 'nationalite',
            'time' => 'temps',
        ];

        $parameters = [];
        foreach ($matches as $field => $key) {
            if (isset($data->{$key})) {
                $parameters[$field] = $data->{$key};
            }
        }
        $parameters['gender'] = Helper::translateGender($parameters['gender']);
        return new Result($parameters);
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
        return Result::class;
    }
}
