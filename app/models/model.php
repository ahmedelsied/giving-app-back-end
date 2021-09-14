<?php
namespace models;
use lib\vendor\DS\collection;
class model
{
    private $join = '';
    private $on = '';
    private $condition = '';
    private $limit = '';
    private $group_by = '';
    private $order_by = '';
    private $order = '';
    private $offset = '';

    public function __construct(){}
    public function delete_all()
    {
        global $con;
        $sql = "DELETE FROM ".static::$table_name;
        $stmt = $con->prepare($sql);
        $stmt->execute();
    }
    public function get(string $custom = '*',int $fetch_type = \PDO::FETCH_ASSOC) : collection
    {
        global $con;
        $sql = "SELECT ".$custom." FROM " . static::$table_name.$this->join.$this->condition.$this->group_by.$this->order_by.$this->order.$this->limit.$this->offset;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll($fetch_type);
        $this->empty_params();
        return new collection($result);
    }
    public function last_insert_id()
    {
        global $con;
        $sql = "SELECT LAST_INSERT_ID() FROM " . static::$table_name;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function build_query(string $sql,int $fetch_type = null,$multible_fetch = false) : array
    {
        global $con;
        $con->setAttribute(\PDO::ATTR_EMULATE_PREPARES, 1);
        $stmt = $con->prepare("$sql");
		$stmt->execute();
        if($multible_fetch){
            $result = [];
            do {
                $result[] = $stmt->fetchAll($fetch_type);
            } while ($stmt->nextRowset());
        }else{
            $result = $stmt->fetchAll($fetch_type);
        }
        return $result;
    }
    public function execute_multi(string $sql)
    {
        global $con;
        $stmt = $con->prepare("$sql");
		$stmt->execute();
    }

    /**
     * where() is work to handle condition in query
     * It Can Take Any Number Of Params
     * It Can Take An Arguments As Arrays Like => ["key","operator","value"]
     * It Return this Object (model)
     */
    public function where() : self
    {
        if(is_array(func_get_arg(0))){
            $cond = "";
            for($i=0;$i<func_num_args();$i++){
                $key = func_get_arg($i)[0];
                $operator = func_get_arg($i)[1];
                $value = func_get_arg($i)[2];
                $cond .= empty($cond) ? "$key $operator \"$value\"" : " AND $key $operator \"$value\"";
            }
            $this->condition .= !empty($this->condition) ? " AND ".$cond : " WHERE ".$cond;
        }else{
            $key = func_get_arg(0);
            $value = func_get_arg(1);
            $operator = func_num_args() == 3 ? func_get_arg(2) : "=";
            $this->condition .= !empty($this->condition) ? " AND $key $operator \"$value\"" : " WHERE $key $operator \"$value\"";
        }
        return $this;
    }
    public function or_where()
    {
        if(is_array(func_get_arg(0))){
            $cond = "";
            for($i=0;$i<func_num_args();$i++){
                $key = func_get_arg($i)[0];
                $operator = func_get_arg($i)[1];
                $value = func_get_arg($i)[2];
                $cond .= empty($cond) ? "$key $operator \"$value\"" : " OR $key $operator \"$value\"";
            }
            $this->condition .= !empty($this->condition) ? " AND (".$cond.")" : " WHERE ".$cond;
        }else{
            $key = func_get_arg(0);
            $value = func_get_arg(1);
            $operator = func_num_args() == 3 ? func_get_arg(2) : "=";
            $this->condition .= !empty($this->condition) ? " OR $key $operator \"$value\"" : " WHERE $key $operator \"$value\"";
        }
        return $this;
    }
    public function where_in(string $key,array $value) : self
    {
        $this->condition .= !empty($this->condition) ? ' AND '.$key.' in ('.implode(',',$value).')' : ' WHERE '.$key.' in ('.implode(',',$value).')';
        return $this;
    }
    public function is_null($col)
    {
        $this->condition .= !empty($this->condition) ? " AND ".$col." IS NULL" : "WHERE ".$col."IS NULL";
        return $this;
    }
    public function join(string $table) : self
    {
        $this->join .= ' INNER JOIN '.$table;
        return $this;
    }
    public function on(string $first_param,string $operator,string $second_param)
    {
        $this->join .= ' ON ' . $first_param.$operator.$second_param.' ';
        return $this;
    }
    public function left_join(string $table) : self
    {
        $this->join .= ' LEFT JOIN '.$table;
        return $this;
    }
    public function right_join(string $table) : self
    {
        $this->join .= ' RIGHT JOIN '.$table;
        return $this;
    }
    public function limit(string $limit) : self
    {
        $this->limit = ' LIMIT '.$limit.' ';
        return $this;
    }
    public function offset(string $offset) : self
    {
        $this->offset = " OFFSET $offset ";
        return $this;
    }
    public function group_by(string $col) : self
    {
        $this->group_by = " GROUP BY $col ";
        return $this;
    }
    public function order_by(string $col) : self
    {
        $this->order_by = " ORDER BY $col ";
        $this->order = " ASC ";
        return $this;
    }
    public function order(string $order) : self
    {
        $this->order = " $order ";
        return $this;
    }
    public function sum($col) : array
    {
        global $con;
        $sql = "SELECT SUM(".$col.") as sum_".$col." FROM " . static::$table_name . $this->condition;
        $stmt = $con->prepare($sql);
		$stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->empty_params();
        return $result;
    }
    public function is_exist()
    {
        return $this->row_count() > 0;
    }
    public function row_count() : int
    {
        global $con;
        $sql = 'SELECT COUNT('.static::$table_name.".".static::$primary_key.') FROM '.static::$table_name.$this->join.$this->on.$this->condition;
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $this->empty_params();
        return $stmt->fetchColumn();
    }
    public function delete() : bool
    {
        global $con;
        $sql = 'DELETE FROM '. static::$table_name . $this->condition;
        $stmt = $con->prepare($sql);
        try{
            $stmt->execute();
            $this->empty_params();
            return true;
        }catch(\Exception $e){
            echo json_encode(["key"=>"fail","msg"=>"somthing_is_wrong"]);
            exit();
        }
    }
    public function save($return_id = false) : bool
    {
        if($this->condition != null){
            if($this->update()){
                $this->empty_params();
                return true;
            }else{
                return false;
            }
        }else{
            return $this->insert($return_id) ? true : false;
        }
    }
    private function insert($return_id) : bool
    {
        global $con;
        $sql = 'INSERT INTO ' . static::$table_name . ' SET ' . $this->build_name_parameters_SQL();
        try{
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return true;
        }catch(\Exception $e){
            echo json_encode(["key"=>"fail","msg"=>"somthing_is_wrong"]);
            exit();
        }
    }
    private function update() : bool
    {
        global $con;
        $sql = 'UPDATE ' . static::$table_name . ' SET ' . $this->build_name_parameters_SQL().$this->condition;
        try{
            $stmt = $con->prepare($sql);
            $stmt->execute();
        }catch(\Exception $e){
            echo json_encode(["key"=>"fail","msg"=>"somthing_is_wrong"]);
            exit();
        }
        $this->empty_params();
        return true;
    }
    private function build_name_parameters_SQL() : string
    {
        $namedParams = '';
        foreach (static::$table_schema as $columnName => $val) {
            if($val !== ""){
                if(strpos($val, '(') !== false){
                    $namedParams .= $columnName . ' = ' . $val . ',';
                }elseif($val === null){
                    $namedParams .= $columnName . ' = NULL ,';
                }else{
                    $namedParams .= $columnName . ' = "' . $val . '",';
                }
            }
        }
        return trim($namedParams, ', ');
    }
    private function empty_params(){
        $this->condition = '';
        $this->limit = '';
        $this->join = '';
        $this->on = '';
        $this->group_by = '';
        $this->order_by = '';
        $this->order = '';
        $this->offset = '';
    }
}