<?php

/**
 * Generic query class so it can be used by every other class
 */
class sQueryWrapper extends sRoot{

	private $tables;
	private $whereColumns;
	private $whereComparisons;
	private $whereValues;
	private $groupBy;
	private $orderBy;
	private $limit;
	private $columns;
	private $fields;
	private $values;
	private $joins;
	private $offset;

	public function newQuery(){
		$this->tables  = array();
		$this->wheres  = array();
		$this->whereColumns = array();
		$this->whereComparisons = array();
		$this->whereValues = array();
		$this->groupBy = array();
		$this->orderBy = array();
		$this->limit   = '';
		$this->columns = array();
		$this->fields  = array();
		$this->values  = array();
		$this->offset  = '';
		$this->joins   = array();
		return true;
	}

	public function from(){
		$tables = func_get_args();
		$tables = $tables[0];
		if(!$tables){
			$this->error('You cannot select from no tables');
		}
		if(!is_array($tables)){
			$tables = array($tables);
		}
		foreach($tables as $table){
			$this->tables[] = $table;
		}
	}

	public function setFrom($table){
		$this->tables = array();
		$this->from($table);
	}

	public function addGroupBy($column){
		if(!$column){
			$this->error('You cannot group by no column');
		}
		$this->groupBy[] = $column;
	}

	public function addOrder($column, $order){
		if(!$column){
			$this->error('You cannot order by no column');
		}
		$order = strtoupper($order);
		if(!in_array($order, array('ASC', 'DESC'))){
			$this->error('Order in addOrder has to be either ASC or DESC');
		}
		$this->orderBy[] = "$column $order";
	}

	public function setLimit($int){
		if($int <= 0){
			$this->error('The limit must be greater than 0');
		}
		$this->limit = $int;
	}

	public function setOffset($int){
		if($int <= -1){
			$this->error('The offset must be greater than -1');
		}
		$this->offset = $int;
	}

	public function addWhere($column, $value=null, $comparison=null){
		if($value && !$comparison){
			$comparison = '=';
		}
		$this->whereColumns[] = $column;
		$this->whereComparisons[] = $comparison;
		$this->whereValues[] = $value;
	}

	public function addField($field, $value){
		$this->fields[] = $field;
		$this->values[] = $value;
		return true;
	}
	
	public function addColumn($column){
		$this->columns[] = $column;
		return true;
	}

	public function addJoin($table, $joinWhere){
		$this->joins[] = "JOIN $table ON ($joinWhere)";
		return true;
	}

	public function addLeftJoin($table, $joinWhere){
		$this->joins[] = "LEFT JOIN $table ON ($joinWhere)";
		return true;
	}

	public function addRightJoin($table, $joinWhere){
		$this->joins[] = "RIGHT JOIN $table ON ($joinWhere)";
		return true;
	}

	public function getWheres(){
		return array(
			"columns"=>$this->whereColumns,
			"comparisons"=>$this->whereComparisons,
			"values"=>$this->whereValues,
		);
	}

	public function getTables(){
		if(!$this->tables){
			$this->error('You have to set a table before running this query');
		}
		return $this->tables;
	}

	public function getJoins(){
		return $this->joins;
	}

	public function getGroupBys(){
		return $this->groupBy;
	}

	public function getOrderBys(){
		return $this->orderBy;
	}

	public function getLimit(){
		return $this->limit;
	}

	public function getColumns(){
		return $this->columns;
	}

	public function getFields(){
		return $this->fields;
	}

	public function getValues(){
		return $this->values;
	}

	public function getOffset(){
		return $this->offset;
	}

}
