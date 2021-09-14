<?php
namespace lib\vendor\DS;
class collection{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function clear ( ) : void {
        $this->data = [];
    }
    public function copy ( ) : self {
        return $this;
    }
    public function is_empty ( ) : bool {
        return empty($this->data);
    }
    public function to_array( ) : array {
        $array = (array) $this;
        return $array;
    }
    public function flatten()
    {
        $result = [];
        $arr = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->data));
        foreach($arr as $v) {
            $result[] = $v;
        }
        return $result; 
    }
    public function pluck(string $arg)
    {
        if($this->is_empty()) return;
        $array_keys = explode(",",$arg);
        $result = [];
        foreach($this->data as $i => $value){
            foreach($array_keys as $j => $key){
                if(isset($value[$key]) && !isset($result[$i])) $result[$i] = [$value[$key]];
                elseif(isset($value[$key])) $result[$i][] = $value[$key];
            }
        }
        return count($result) > 1 ? $result : (count($result[0]) > 1 ? $result[0] : $result[0][0]);
    }
}