<?php

namespace Sportic\Omniresult\Itra;

/**
 * Class Helper
 * @package Sportic\Omniresult\Itra
 */
class Helper extends \Sportic\Omniresult\Common\Helper
{
    /**
     * @param $gender
     * @return string
     */
    public static function translateGender($gender): string
    {
        $gender = strtolower($gender);
        if ($gender == 'h') {
            return 'male';
        }
        if ($gender == 'f') {
            return 'female';
        }
        return '';
    }
}
