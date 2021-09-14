<?php
namespace lib\vendor;

trait validator
{
    private $_regexPatterns = [
        'num'           => '/^[0-9]+(?:\.[0-9]+)?$/',
        'int'           => '/^[0-9]+$/',
        'float'         => '/^[0-9]+\.[0-9]+$/',
        'coords'        => '/([0-9.-]+).+?([0-9.-]+)/',
        'alpha'         => '/^[a-zA-Z\p{Arabic}\-\\,. ]+$/u',
        'alphanum'      => '/^[a-zA-Z\p{Arabic}0-9 ]+$/u',
        'vdate'         => '/^[1-2][0-9][0-9][0-9]-(?:(?:0[1-9])|(?:1[0-2]))-(?:(?:0[1-9])|(?:(?:1|2)[0-9])|(?:3[0-1]))$/',
        'email'         => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'url'           => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'
    ];

    protected function req ($value)
    {
        return !empty($value) ? true : false;
    }

    protected function num($value)
    {
        return (bool) preg_match($this->_regexPatterns['num'], $value);
    }
    
    protected function int($value)
    {
        return (bool) preg_match($this->_regexPatterns['int'], $value);
    }

    protected function float($value)
    {
        return (bool) preg_match($this->_regexPatterns['float'], $value);
    }

    public function coords($value)
    {
        return (bool) preg_match($this->_regexPatterns['coords'], $value);
    }

    protected function alpha($value)
    {
        return (bool) preg_match($this->_regexPatterns['alpha'], $value);
    }

    protected function alphanum($value)
    {
        return (bool) preg_match($this->_regexPatterns['alphanum'], $value);
    }

    protected function eq($value, $matchAgainst)
    {
        return $value == $matchAgainst;
    }

    protected function eq_field($value, $otherFieldValue)
    {
        return $value == $otherFieldValue;
    }

    protected function lt($value, $matchAgainst)
    {
        if(is_string($value)) {
            return mb_strlen($value) < $matchAgainst;
        } elseif (is_numeric($value)) {
            return $value < $matchAgainst;
        }
    }

    protected function gt($value, $matchAgainst)
    {
        if(is_string($value)) {
            return mb_strlen($value) > $matchAgainst;
        } elseif (is_numeric($value)) {
            return $value > $matchAgainst;
        }
    }

    protected function min($value, $min)
    {
        if(is_string($value)) {
            return mb_strlen($value) >= $min;
        } elseif (is_numeric($value)) {
            return $value >= $min;
        }
    }

    protected function max($value, $max)
    {
        if(is_string($value)) {
            return mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value <= $max;
        }
    }

    protected function between($value, $min, $max)
    {
        if(is_string($value)) {
            return mb_strlen($value) >= $min && mb_strlen($value) <= $max;
        } elseif (is_numeric($value)) {
            return $value >= $min && $value <= $max;
        }
    }

    protected function floatlike($value, $beforeDP, $afterDP)
    {
        if(!$this->float($value))
        {
            return false;
        }
        $pattern = '/^[0-9]{' . $beforeDP . '}\.[0-9]{' . $afterDP . '}$/';
        return (bool) preg_match($pattern, $value);
    }

    protected function vdate($value)
    {
        return (bool) preg_match($this->_regexPatterns['vdate'], $value);
    }

    protected function email($value)
    {
        return (bool) preg_match($this->_regexPatterns['email'], $value);
    }

    protected function url($value)
    {
        return (bool) preg_match($this->_regexPatterns['url'], $value);
    }
    protected function params_exist(array $params,array $entity) : bool
    {
        for($i=0;$i<count($params);$i++){
            if(!array_key_exists($params[$i],$entity)){
                return false;
            }
        }
        return true;
    }
}