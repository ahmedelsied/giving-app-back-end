<?php
namespace lib\vendor;

trait input_filter
{
    public function filter_int($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }

    public function filter_float($input)
    {
        return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public function filter_string($input)
    {
        return htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}