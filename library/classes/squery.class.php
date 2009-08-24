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
	 * Disconnect from the database
	 * @return <type>
	 */
	public function disconnect() {
		return $this->db->disconnect();
	}

	/**
	 * Clean out the variables so we can start a new query
	 */
	public function newQuery(){
		return $this->db->newQuery();
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
	 *
	 * @param string $query
	 * @return string
	 */
	public function escapeQuery($query){
		return $this->db->escapeQuery($query);
	}

	/**
	 *
	 * @return int
	 */
	public function getNumRows() {
		return $this->db->getNumRows();
	}

	/**
	 * Add a table to the query
	 * @param string $table
	 */
	public function setFrom($table){
		return $this->db->setFrom($table);
	}

	/**
	 * Add some tables to your query
	 * @param string any number of parameters, each one is a table name
	 */
	public function from(){
		return $this->db->from(func_get_args());
	}
	
	/**
	 * Alias for from()
	 * @see $this->from()
	 * @param string any number of parameters, each one is a table name
	 */
	public function into(){
		return $this->db->from(func_get_args());
	}
	/**
	 * Alias for setFrom($table)
	 * @see $this->setFrom
	 * 
	 */
	public function setInto($table){
		return $this->setFrom($table);
	}

	/**
	 * Add a group by
	 * @param string $column
	 */
	public function addGroupBy($column){
		return $this->db->addGroupBy($column);
	}

	/**
	 * Add an order
	 * @param string $column
	 */
	public function addOrder($column, $direction){
		return $this->db->addOrder($column, $direction);
	}

	/**
	 * Set the limit
	 * @param int $int
	 */
	public function setLimit($int){
		return $this->db->setLimit($int);
	}

	/**
	 * Set the offset
	 * @param int $int
	 */
	public function setOffset($int){
		return $this->db->setOffset($int);
	}

	/**
	 * Add one of the columns that you want to retrieve
	 * @param string $column
	 */
	public function addColumn($column){
		return $this->db->addColumn($column);
	}

	/**
	 * Add the columns that you want to retrieve
	 */
	public function addColumns(){
		return $this->db->addColumns(func_get_args());
	}

	/**
	 * Add a where
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 */
	public function addWhere($column, $value=null, $comparison=null){
		return $this->db->addWhere($column, $value, $comparison);
	}

	/**
	 * Add a field and a value for that field for an insert statement
	 * @param string $field
	 * @param string $value
	 */
	public function addField($field, $value){
		return $this->db->addField($field, $value);
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
	 * Add a join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addJoin($table, $where){
		return $this->db->addJoin($table, $where);
	}

	/**
	 * Add a Left Join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addLeftJoin($table, $where){
		return $this->db->addLeftJoin($table, $where);
	}

	/**
	 * Add a Right Join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addRightJoin($table, $where){
		return $this->db->addRightJoin($table, $where);
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
