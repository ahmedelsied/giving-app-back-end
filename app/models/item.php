<?php
namespace models;
class item extends model
{
    protected static $table_name = 'item';
    public static $table_schema = array(
        'id'            => '',
        'user_id'       => '',
        'item_title'    => '',
        'category_id'   => '',
        'description'   => '',
        'item_img'      => '',
        'coords'        => '',
        'country'       => '',
        'city'          => '',
        'status'        => '',
        'request_status'=> '',
        'request_date'  => '',
        'applicant_id'  => '',
        'is_requested'  => '',
        'created_at'    => '',
        'updated_at'    => ''
    );
    protected static $primary_key = 'id';
    public function get_accepted($user_id,$params)
    {
        $selected_data = "item.id,item_title,description,item_img,category.name as category_name,country,city";
        return $this->join("category")->on("category.id","=","item.category_id")->where(["user_id","=",$user_id],["status","=",ACCEPTED],["is_requested","=",$params["requested"],["request_status","!=",DELIVERED]])->limit(SERVER_LIMIT)->offset($params["page"]*SERVER_LIMIT)->get($selected_data)->data;
    }
    public function get_pending($user_id,$params)
    {
        $selected_data = "item.id,item_title,description,item_img,category.name as category_name,country,city";
        return $this->join("category")->on("category.id","=","item.category_id")->where(["user_id","=",$user_id],["status","=",PENDING],["is_requested","=",NOT_REQUESTED],["request_status","!=",DELIVERED])->limit(SERVER_LIMIT)->offset($params["page"]*SERVER_LIMIT)->get($selected_data)->data;
    }
    public function item_profile($item_id)
    {
        return $this->where(["item.id","=",$item_id],["request_status","!=",DELIVERED])->left_join("user")->on("user.id","=","applicant_id")->get("user_id,item_title,category_id,description,item_img,ST_X(coords) as lat,ST_Y(coords) as lng,country,city,is_requested,request_status,request_date,user.*")->data;
    }
    public function get_user_requests($user_id)
    {
        return $this->build_query("SELECT * FROM request_view WHERE applicant_id = ".$user_id." AND is_requested = ".REQUESTED.";SELECT COUNT(id) as requests_count FROM request_view WHERE applicant_id = ".$user_id." AND YEAR(request_date) = ".date("Y")." AND MONTH(request_date) = ".date("m"),\PDO::FETCH_ASSOC,true);
    }
    public function make_item_requests($item_id,$user_id)
    {
        $this->applicant_id = $user_id;
        $this->request_date = date("Y-m-d h:i:s");
        $this->request_status = PENDING;
        $this->is_requested = REQUESTED;
        if($this->where(["id","=",$item_id],["is_requested","=",REQUESTED])->is_exist()) return false;
        return $this->where(["id","=",$item_id],["is_requested","=",NOT_REQUESTED],["request_status","!=",DELIVERED])->save();
    }
    public function delete_item_requests($item_id,$user_id)
    {
        $this->applicant_id = null;
        $this->request_date = null;
        $this->request_status = PENDING;
        $this->is_requested = NOT_REQUESTED;
        if(!$this->where(["id","=",$item_id],["applicant_id","=",$user_id],["is_requested","=",REQUESTED],["request_status","=",PENDING])->is_exist()) return false;
        return $this->where(["id","=",$item_id])->save();
    }
    public function accept_item_request($item_id,$user_id)
    {
        $this->request_status = ACCEPTED;
        if(!$this->where(["id","=",$item_id],["user_id","=",$user_id],["is_requested","=",REQUESTED],["request_status","=",PENDING])->is_exist()) return false;
        return $this->where(["id","=",$item_id],["user_id","=",$user_id])->save();
    }
    public function refuse_item_request($item_id,$user_id)
    {
        $this->applicant_id = null;
        $this->request_date = null;
        $this->request_status = PENDING;
        $this->is_requested = NOT_REQUESTED;
        if(!$this->where(["id","=",$item_id],["user_id","=",$user_id],["is_requested","=",REQUESTED],["request_status","=",PENDING])->is_exist()) return false;
        return $this->where(["id","=",$item_id])->save();
    }
    public function delivered($item_id,$user_id)
    {
        $this->request_status = DELIVERED;
        if(!$this->where(["id","=",$item_id],["user_id","=",$user_id],["is_requested","=",REQUESTED],["request_status","=",ACCEPTED])->is_exist()) return false;
        return $this->where(["id","=",$item_id])->save();
    }
    public function home_items($user_id,$page)
    {
        $offset = $page*SERVER_LIMIT;
        return $this->build_query("SELECT * FROM home_items WHERE user_id != $user_id LIMIT ".SERVER_LIMIT." OFFSET $offset",\PDO::FETCH_ASSOC);
    }
    public function search($user_id,$params)
    {
        $offset = $params['page']*SERVER_LIMIT;
        return $this->build_query("SELECT * FROM home_items WHERE item_title LIKE '%".$params['query']."%' AND user_id != $user_id LIMIT ".SERVER_LIMIT." OFFSET $offset",\PDO::FETCH_ASSOC);
    }
    public function filter($user_id,$params)
    {
        $offset = $params['page']*SERVER_LIMIT;
        $query_condition = $this->set_query_filter_condition($params);
        return $this->build_query("SELECT * FROM home_items WHERE user_id != $user_id ".$query_condition." LIMIT ".SERVER_LIMIT." OFFSET $offset",\PDO::FETCH_ASSOC);
    }
    private function set_query_filter_condition($params)
    {
        $query = "";
        if(!empty($params["query"])) $query.="AND item_title LIKE %".$params['query']."%";
        if(!empty($params["country"])) $query.= " AND country = '".$params["country"]."'";
        if(!empty($params["city"])) $query.=" AND city = '".$params["city"]."'";
        if(!empty($params["category_id"])) $query.= " AND category_id = '".$params["category_id"]."'";
        return $query;
    }
    public function __set($prop,$value)
    {
        self::$table_schema[$prop] = $value;
    }
    public function __get($prop)
    {
        return self::$table_schema[$prop];
    }
}