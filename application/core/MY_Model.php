<?php

class MY_Model extends CI_Model{
	const DB_TABLE = "default";
	const DB_TABLE_PK = "default";
	
	const FIRST_NAME 	= "employee_fname";
	const MIDDLE_NAME 	= "employee_mname";
	const LAST_NAME 	= "employee_lname";

	// toJoin *array -> array('model to join' => 'model already joined or loaded');
	public $toJoin = array();
	public $selects = array();
	// public $parent_table = false;
	// $order_field and $order_type used for order queries



	public $sqlQueries = array("order_field" => '',
								"order_type" => '',
								"toGroup" => '',
								"join_type" => '',
								"selects" => '*',
								'new' => 0
								);

	public function has_many($model)
	{
		if(!isset($this->{$model})){

			$this->load->model($model);
			$class = new $model();

			$objs = $class->search([$this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}]);

			$this->{$model} = $objs;
		}

		return $this->{$model};

	}
	public function belongs_to($model)
	{
		if (!isset($this->{$model})) {
			$this->load->model($model);
			$class = new $model();

			$obj = $class->pop([$class::DB_TABLE_PK => $this->{$class::DB_TABLE_PK} ]);

			$this->{$model} = $obj;

		}		

		return $this->{$model};

	}
	private function insert(){
		$this->db->insert($this::DB_TABLE,$this);
		if ($this::DB_TABLE != "employees") {
			$this->{$this::DB_TABLE_PK} = $this->db->insert_id();
		}
	}
	private function update($pk = false){
		if ($pk) {
			$this->db->where($this::DB_TABLE_PK, $pk);
		}	
		else{
			$this->db->where($this::DB_TABLE_PK, $this->{$this::DB_TABLE_PK});
		}
		$this->db->update($this::DB_TABLE,$this);
	}
	private function getSelect(){
		$selectQry = "";
		if($this->selects){
			$counter = 0;
			foreach ($this->selects as $key => $value) {
				$counter ++;
				if($counter == count($this->selects)){
					$selectQry .= " {$value} ";
				}
				else{
					$selectQry .= " {$value}, ";
				}
			}
		}
		return $selectQry;
	}
	
	// use instantiate for more than one record
	public function instatiate($qry_result){
		$toret = array();
		$class = get_class($this);
		foreach ($qry_result as $row) {
			$model = new $class;
			$model->populate($row);
			$toret[$row->{$this::DB_TABLE_PK}] = $model;
		}
		return $toret;
	}
	private function addJoin($joinType = null){
		if(count($this->toJoin) > 0){
			foreach ($this->toJoin as $value) {
				$this->db->join($value[0], $value[1],$value[2]);
			}
		}
	}
	private function addOrder(){
		if($this->sqlQueries['order_field'] != '' and $this->sqlQueries['order_type'] != ''){
			$this->db->order_by($this->sqlQueries['order_field'],$this->sqlQueries['order_type']);
		}
	}
	private function addGroup(){
		if($this->sqlQueries['toGroup'] != ''){
			$this->db->group_by($this->sqlQueries['toGroup']);
		}
	}
	// use populate if you are looking for only one record
	public function populate($row){
		foreach ($row as $key => $value) {
				$this->$key = $value;
		}
	}
	public function load($id){
		if($this->getSelect() != ""){
			$qry->select($this->getSelect());
		}
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$query = $this->db->where(array($this::DB_TABLE.".".$this::DB_TABLE_PK => $id));
		$query = $this->db->get();
		if(is_array($query->row())){
			if (count($query->row()) > 0) {
				$this->populate($query->row());
			}
		}
		
	
	}
	public function empty_table()
	{
		$this->db->empty_table($this::DB_TABLE);
	}
	public function delete($all = false){
			$this->db->delete($this::DB_TABLE,array(
			$this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}));
			unset($this->{$this::DB_TABLE_PK});
	}
	public function save($pk = false){
		if(isset($this->{$this::DB_TABLE_PK}) && !$this->sqlQueries['new'] ){
			$this->update($pk);
		}
		else{
			$this->insert();
		}
	}
	public function get($limit = 0, $offset = 0){
		$this->db->select('*');
		$this->db->from($this::DB_TABLE);
		$this->addJoin();		
		$this->addGroup();
		$this->addOrder();
		if($limit){
			$query = $this->db->limit($limit,$offset);
		}
		$qry = $this->db->get();
		$toret = $this->instatiate($qry->result());
		return $toret;
	}
	public function get_join(){
		// echo "asddas";
		$this->db->select('*');
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$query = $this->db->get();
		$toret = $this->instatiate($query->result());

		return $toret;

	}
	public function pop($search = array())
	{
		$result = $this->search($search);
		if ($result) {
			return reset($result);
		}
		return $this;
	}
	// @search
	// @parameter $where => array('field' => value)
	// @parameter $joins => array( 'model to join'=> 'model already joined' ) 
	public function search($where = null,$limit = 0, $offset = 0){
		if($this->getSelect() != ""){
			$this->db->select($this->getSelect());
		}
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->addGroup();		
		if ($where) {
			$this->db->where($where);
		}
		$this->addOrder();
		if ($limit) {
			$this->db->limit($limit);
			$this->db->offset($offset);
			$qry = $this->db->get();
		}
		else{
			$qry = $this->db->get();
		}
		$toret = $this->instatiate($qry->result());
		return $toret;
	}
	public function having($where, $limit = 0, $offset = 0)
	{
		if($this->getSelect() != ""){
			$this->db->select($this->getSelect());
		}
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->addGroup();		
		$this->db->having($where);
		$this->addOrder();
		if ($limit) {
			$this->db->limit($limit);
			$this->db->offset($offset);
			$qry = $this->db->get();
		}
		else{
			$qry = $this->db->get();
		}
		$toret = $this->instatiate($qry->result());
		return $toret;
	}
	public function whereLike($orLikes,$andLikes,$where,$orWhere,$between = array(),$limit = 0,$offset = 0){
		$counter = 0;
		$qry = $this->db;
		if($this->getSelect() != ""){
			$qry->select($this->getSelect());
		}
		$qry->from($this::DB_TABLE);
		$this->addJoin('left');
		$whereQuery = "";

		if($orLikes)
		{
			$whereQuery .= "(";
			foreach ($orLikes as $key => $value)
			{
				$counter++;
				if($counter == 1)
				{
					if(is_int($value))
					{
						$whereQuery .= "{$key} = {$value} ";
					}
					else
					{
						$whereQuery .= "{$key} like '%{$value}%' ";
					}
				}
				else{
					if(is_int($value))
					{
						$whereQuery .= "OR {$key} = {$value} ";
					}
					else
					{
						$whereQuery .= "OR {$key} like '%{$value}%' ";
					}
				}
			}
			$whereQuery .= ")";
			if($andLikes OR $where OR $between || $orWhere )
			{
				$whereQuery .= " AND ";
			}
		}
		if($andLikes){
			$whereQuery .= "( ";
			$counter = 0;
			foreach ($andLikes as $key => $value) {
				$counter++;
				if($counter == 1){
					if(is_int($value)){
						$whereQuery .= "{$key}  = {$value} ";
					}
					else{
						$whereQuery .= "{$key} like '%{$value}%' ";
					}
				}else{
					if(is_int($value)){
						$whereQuery .= "AND {$key} = {$value} ";
					}
					else{
						$whereQuery .= "AND {$key} like '%{$value}%' ";
					}
				}
			}		
			$whereQuery .= ") ";
			if($where || $orWhere || $between){
				$whereQuery .= " AND ";
			}

		}
		if($where){
			$counter = 0;
			$whereQuery .= "( ";
				foreach ($where as $key2 => $value2) {
				$counter++;
				foreach ($value2 as $key => $value) {
						if($counter == 1){
							if(is_int($value)){
								$whereQuery .= "{$key} = {$value} ";
							}
							else{
								$whereQuery .= "{$key} = '{$value}' ";
							}
						}else{
							if(is_int($value)){
								$whereQuery .= "AND {$key} = {$value} ";
							}
							else{
								$whereQuery .= "AND {$key} = '{$value}' ";
							}
						}
					}
				
			}
			$whereQuery .= ")";	
			if($orWhere || $between){
				$whereQuery .= " AND ";
			}
		}
		if($orWhere){
			$whereQuery .= "( ";
				$counter = 0;
				foreach ($orWhere as $key2 => $value2) {
					foreach ($value2 as $key => $value) {
							$counter++;
							foreach ($value as $key3 => $value3) {
								if($counter == 1){
									if(is_int($value)){
										$whereQuery .= "{$key3} = {$value3} ";
									}
									else{
										$whereQuery .= "{$key3} = '{$value3}' ";
									}
								}
								else
								{
									if(is_int($value)){
										$whereQuery .= "OR {$key3} = {$value3} ";
									}
									else{
										$whereQuery .= "OR {$key3} = '{$value3}' ";
									}
								}
							}
						}
				}
			$whereQuery .= ")";
			if($between){
				$whereQuery .= " AND ";
			}	
		}
		if($between){
			$whereQuery .= "( ";
				$counter = 0;
				foreach ($between as $key2 => $value2) {
					$whereQuery .= "{$key2} BETWEEN ";
					$counter = 0;
					foreach ($value2 as $key3 => $value3) {
						$counter++;
						if (is_int($value3)) {
							if ($counter == 2) {
								$whereQuery .= "{$value3}";
							}
							else{
								$whereQuery .= "{$value3} AND ";
							}
						}
						else{
							if ($counter == 2) {
								$whereQuery .= "'{$value3}'";
							}
							else{
								$whereQuery .= "'{$value3}' AND ";
							}
						}
					}

				}
			$whereQuery .= ")";
		}

		$qry->where($whereQuery);
		$this->addOrder();
		if ($this->sqlQueries['toGroup']) {
			$this->db->group_by($this->sqlQueries['toGroup']);
		}
		if ($limit) {
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();

		return $this->instatiate($query->result());
	}
	public function load_last_input(){
		$this->get_order_limit1($this::DB_TABLE_PK,'desc',array());
	}
	public function get_order_limit1($field,$order,$where){
		$this->db->from($this::DB_TABLE);
		$this->addJoin();
		$this->db->where($where);
		$this->db->order_by($field,$order);
		$this->db->limit(1);
		$query = $this->db->get();
		if($query){
			$this->populate($query->row());
		}
	}
	public function get_ordered($where,$field,$order){
		$qry = $this->db;
		$qry->from($this::DB_TABLE);
		$qry->where($where);
		$qry->order_by($field,$order);
		$query = $this->db->get();
		$toret = $this->instatiate($query->result());
		
		return $toret;
	}
	public function fullName($format = "l, m. f"){
		$fullName = "";
		$format = str_split($format);
		$mname = "";

		if(isset($this->{$this::FIRST_NAME}) && isset($this->{$this::FIRST_NAME})){
			if ($this->{$this::MIDDLE_NAME} != "") {
				$mname = ucfirst($this->{$this::MIDDLE_NAME}[0]);
			}

			$name = array("f" => ucfirst($this->{$this::FIRST_NAME}),
						  "m" => $mname,
						  "l" => ucfirst($this->{$this::LAST_NAME})
						);
			foreach ($format as $key => $value) {
						if (isset($name[$value])) {
							$fullName .= $name[$value];
						}
						else{
							if (($value == "." || $value == ",")&& $mname == "") {
							}
							else{
								$fullName .= $value;
							}
						}
					}			
		}
		return $fullName;
	}
	public function save_or_get($searchArray,$newValues,$className){
		$class = new $className;
		$objectExists = $class->search($searchArray);
		if($objectExists){
			$toret = array_shift($objectExists);
		}
		else{
			$newObject = new $className;
			foreach ($newValues as $key => $value) {
				$newObject->$key = $value;
			}
			$newObject->save();

			$lastInput = new $className;
			$lastInput->load_last_input();
			$toret = $lastInput;
		}
		return $toret;
	}
	
}