<?php

class sQuery extends sRoot{
	private $db;
	/**
	 *  Connects to database
	 */
	public function __construct() {
		parent::__construct();
		//$dbType = strtoupper($this->config-db['type']);
		$dbClass = 's'.$this->config->db['type'].'Query';
		$this->db = new $dbClass();
	}
	/**
	 * disconnects from the database
	 */
	public function __destruct(){
		$this->disconnect();
	}
	/**
	 * Disconnect from the database
	 * @return sQuery
	 */
	public function disconnect() {
		$this->db->disconnect();
		return $this;
	}
	/**
	 * Clean out the variables so we can start a new query
	 * @return sQuery
	 */
	public function newQuery(){
		$this->db->newQuery();
		return $this;
	}
    /**
     * Do a direct query on the database bypassing the query builder
     * @param string $query
     * @return array
     */
    public function queryDb($query){
        return $this->db->queryDb($query);
    }
	/**
	 * Add some tables to your query
	 * @param string any number of parameters, each one is a table name
	 */
	public function from(){
		$this->db->from(func_get_args());
		return $this;
	}
	/**
	 * Alias for from()
	 * @see $this->from()
	 * @param string any number of parameters, each one is a table name
	 */
	public function into(){
		$this->db->from(func_get_args());
		return $this;
	}
	/**
	 * Alias for from()
	 * @see $this->from()
	 * @param string any number of parameters, each one is a table name
	 */
	public function table(){
		$this->db->from(func_get_args());
		return $this;
	}
	/**
	 * Add a group by
	 * @param string $column
	 * @return sQuery
	 */
	public function groupBy($column){
		$this->db->groupBy($column);
		return $this;
	}
	/**
	 * Add an order
	 * @param string $column
	 * @return sQuery
	 */
	public function orderBy($column, $direction){
		$this->db->orderBy($column, $direction);
		return $this;
	}
	/**
	 * Set the limit
	 * @param int $int
	 * @return sQuery
	 */
	public function limit($int){
		$this->db->limit($int);
		return $this;
	}

	/**
	 * Set the offset
	 * @param int $int
	 */
	public function offset($int){
		$this->db->offset($int);
		return $this;
	}
	/**
	 * Add one of the columns that you want to retrieve
	 * @param string $column
	 * @return sQuery
	 */
	public function column($column){
		$this->db->column($column);
		return $this;
	}
	/**
	 * Add the columns that you want to retrieve
	 * @return sQuery
	 */
	public function columns(){
		$this->db->columns(func_get_args());
		return $this;
	}
	/**
	 * Add a where
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 * @return sQuery
	 */
	public function where($column, $value=null, $comparison=null){
		$this->db->where($column, $value, $comparison);
		return $this;
	}
	/**
	 * Add a field and a value for that field for an insert statement
	 * @param string $field
	 * @param string $value
	 */
	public function set($field, $value){
		$this->db->set($field, $value);
		return $this;
	}
	/**
	 * Add a join to the query
	 * @param str $table
	 * @param str $where
	 * @return sQuery
	 */
	public function join($table, $where){
		$this->db->join($table, $where);
		return $this;
	}
	/**
	 * Add a Left Join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function leftJoin($table, $where){
		$this->db->leftJoin($table, $where);
		return $this;
	}

	/**
	 * Add a Right Join to the query
	 * @param str $table
	 * @param str $where
	 * @return sQuery
	 */
	public function rightJoin($table, $where){
		$this->db->rightJoin($table, $where);
		return $this;
	}

	/**
	 * Get all results for this query
	 * @return array
	 */
	public function selectAll(){
		return $this->db->selectAll();
	}

	/**
	 * Get one row
	 * @return array
	 */
	public function selectRow(){
		return $this->db->selectRow();
	}

	/**
	 * Get the enum values from a field in the database
	 * @return array
	 */
	public function selectEnum(){
		return $this->db->selectEnum();
	}
	/**
	 *
	 * @return int
	 */
	public function getNumRows() {
		return $this->db->getNumRows();
	}
	/**
	 * Get the select query
	 * @return string
	 */
	public function getSelect(){
		return $this->db->getSelect();
	}

	/**
	 * Get the insert Query
	 * @return string
	 */
	public function getInsert(){
		return $this->db->getInsert();
	}

	/**
	 * Get the update Query
	 * @return string
	 */
	public function getUpdate(){
		return $this->db->getUpdate();
	}

	/**
	 * Get the count query
	 * @return string
	 */
	public function getCount(){
		return $this->db->getCount();
	}



	/**
	 * Escape a value
	 * @param string $value
	 * @return string the last insert id
	 */
	public function insert(){
		if(!$id = $this->db->insert()){
			$error = $this->getError();
			if($error){
				$this->error($error);
				return false;
			}
		}
		return $id;
	}

	/**
	 * Run an update query on the database
	 * @return int the number of affected rows
	 */
	public function update(){
		return $this->db->update();
	}

	/**
	 * Get fields of a table
	 */
	public function tableFields(){
		return $this->db->tableFields();
	}
	/**
	 * Get the table information
	 * @return <type>
	 */
	public function describe(){
		return $this->db->describe();
	}

	/**
	 * Get the last insert id returned
	 * @return int
	 */
	public function lastInsertId(){
		$this->db->lastInsertId();
	}

	/**
	 * Get the affected rows from the last query
	 * @return <type>
	 */
	public function affectedRows(){
		return $this->db->affectedRows();
	}
	/**
	 * Get the count from the query
	 * @return string
	 */
	public function count(){
		return $this->db->count();
	}

	/**
	 * Get the delete query
	 * @return string
	 */
	public function getDelete(){
		return $this->db->getDelete();
	}

	/**
	 * Delete something
	 * @return int
	 */
	public function delete(){
		return $this->db->delete();
	}
}
