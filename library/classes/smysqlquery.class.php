<?php

class sMYSQLQuery extends sRoot {
	private $dbLinkIdentifier = null;
	private $resultResource = null;
	private $lastInsertId = null;
	private $affectedRows = null;
	private $query;

	public function __construct() {
		parent::__construct();
		$this->query = new sQueryWrapper();
	}

	/**
	 * Connect to the database
	 * @return bool
	 */
	public function connect() {
		$dbAddress = $this->config->db['host'];
		$dbUser = $this->config->db['user'];
		$dbPass = $this->config->db['password'];
		$dbName = $this->config->db['name'];
		if(!$this->dbLinkIdentifier) {
			$this->dbLinkIdentifier = @mysql_connect($dbAddress, $dbUser, $dbPass);
			if ($this->dbLinkIdentifier != 0) {
				if (mysql_select_db($dbName, $this->dbLinkIdentifier)) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		return true;
	}

	/**
	 * Disconnect from the database
	 * @return bool
	 */
	public function disconnect() {
		if($this->dbLinkIdentifier){
			if (mysql_close($this->dbLinkIdentifier) != 0) {
				$this->dbLinkIdentifier = null;
				return true;
			}
			return false;
		}
		return true;
	}

	/**
	 *
	 * @param string $query
	 * @param bool $singleResult
	 * @return array
	 */
	public function queryDb($query) {
		if(!$this->dbLinkIdentifier) {
			if(!$this->connect()) {
				$this->error('Could not connect to database');
			}
		}
		$this->resultResource = mysql_query($query, $this->dbLinkIdentifier);
		$error = $this->getError();
		if($error) {
			$this->error($error);
		}
		if($this->resultResource && !is_bool($this->resultResource)) {
				$result = array();
				$field = array();
				$tempResults = array();
				$numOfFields = mysql_num_fields($this->resultResource);
				for ($i = 0; $i < $numOfFields; ++$i) {
					array_push($field,mysql_field_name($this->resultResource, $i));
				}
				while ($row = mysql_fetch_row($this->resultResource)) {
					for ($i = 0;$i < $numOfFields; ++$i) {
						$tempResults[$field[$i]] = $row[$i];
					}
					array_push($result,$tempResults);
				}
				return($result);
		}
		return $this->resultResource;
	}

	/**
	 * Clean out the variables so we can start a new query
	 */
	public function newQuery() {
		$this->resultResource  = '';
		$this->lastInsertId = '';
		return $this->query->newQuery();
	}

	/**
	 * Attempt to escape the whole query
	 * @param string $query
	 * @return string
	 */
	public function escapeQuery($query) {
		$this->error('Not implemented');
		return $query;
	}

	/**
	 *
	 * @return int
	 */
	public function getNumRows() {
		return mysql_num_rows($this->resultResource);
	}

	/**
	 * Free the results
	 */
	private function freeResult() {
		if($this->resultResource && !is_bool($this->resultResource)){
			if(mysql_free_result($this->resultResource)){
				$this->resultResource = null;
				return true;
			} else {
				return false;
			}
		}
		return true;
	}

	/**
	 * Get the latest error
	 * @return string
	 */
	private function getError() {
		return mysql_error($this->dbLinkIdentifier);
	}

	/**
	 * Add a table to the query
	 * @param string $table
	 */
	public function setFrom($table) {
		return $this->query->setFrom('`'.$this->escape($table).'`');
	}

	/**
	 * Add some tables to your query
	 */
	public function from() {
		$tables = func_get_args();
		if(is_array($tables[0])){
			$tables = $tables[0];
		}
		foreach($tables as $table){
			$this->query->from('`'.$this->escape($table).'`');
		}
		return true;
	}

	/**
	 * Set the group by statement
	 * @param string $column
	 */
	public function addGroupBy($column) {
		return $this->query->addGroupBy('`'.$this->escape($column).'`');
	}

	/**
	 * set the order
	 * @param string $column
	 */
	public function addOrder($column, $order='ASC') {
		return $this->query->addOrder("`{$this->escape($column)}`", $this->escape($order));
	}

	/**
	 * Set the limit
	 * @param int $int
	 */
	public function setLimit($int) {
		return $this->query->setLimit($this->escape($int));
	}

	/**
	 * Set the offset
	 * @param int $int
	 */
	public function setOffset($int) {
		return $this->query->setOffset($this->escape($int));
	}

	/**
	 * Add one of the columns that you want to retrieve
	 * @param string $column
	 */
	public function addColumn($column) {
		if(strpos($column, ' ') === false){
			return $this->query->addColumn('`'.$this->escape($column).'`');
		} else {
			return $this->query->addColumn($this->escape($column));
		}
	}

	/**
	 * Add the columns that you want to retrieve
	 */
	public function addColumns() {
		$columns = func_get_args();
		if(is_array($columns[0])){
			$columns = $columns[0];
		}
		foreach($columns as $column) {
			if(!$this->addColumn($column)){
				$this->error('Could not add column '. $column);
			}
		}
		return true;
	}

	/**
	 * Add a where
	 * @param string $column
	 * @param string $value
	 * @param string $comparison
	 */
	public function addWhere($column, $value=null, $comparison=null) {

		if(is_object($value)) {
			return $this->query->addWhere($this->escape($column), $value,  $this->escape($comparison));
		}
		if(is_null($comparison) && !is_null($value)){
			$comparison = '=';
		}
		if(is_null($value)){
			$value = 'NULL';
		} else {
			$value = '\''.$this->escape($value).'\'';
		}
		if($column && $comparison) {
			return $this->query->addWhere($this->escape($column), $value, $this->escape($comparison));
		} elseif($column && $value) {
			return $this->query->addWhere($this->escape($column), $value, '=');
		} elseif($column) {
			return $this->query->addWhere($this->escape($column), '', '');
		} elseif(!$column) {
			$this->error('Column cannot be null');
		}
	}

	/**
	 * Add a field and a value for that field for an insert statement
	 * @param string $field
	 * @param string $value
	 */
	public function addField($field, $value) {
		return $this->query->addField("`{$this->escape($field)}`", "'{$this->escape($value)}'");
	}

	/**
	 * Add a join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addJoin($table, $where) {
		if(strpos($table, ' ') === false){
			return $this->query->addJoin("`{$this->escape($table)}`", $this->escape($where));
		} else {
			return $this->query->addJoin($this->escape($table), $this->escape($where));
		}
	}

	/**
	 * Add a Left Join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addLeftJoin($table, $where) {
		if(strpos($table, ' ') === false){
			return $this->query->addLeftJoin("`{$this->escape($table)}`", $this->escape($where));
		} else {
			return $this->query->addLeftJoin($this->escape($table), $this->escape($where));
		}
	}

	/**
	 * Add a Right Join to the query
	 * @param str $table
	 * @param str $where
	 * @return bool
	 */
	public function addRightJoin($table, $where) {
		if(strpos($table, ' ') === false){
			return $this->query->addRightJoin("`{$this->escape($table)}`", $this->escape($where));
		} else {
			return $this->query->addRightJoin($this->escape($table), $this->escape($where));
		}
	}

	/**
	 * Get all results for this query
	 * @return array
	 */
	public function selectAll() {
		$query = $this->getSelect();
		$result = $this->queryDb($query);
		$this->freeResult($this->resultResource);
		return $result;
	}

	/**
	 * Get one row
	 * @return array
	 */
	public function selectRow() {
		$this->query->setLimit(1);
		$query = $this->getSelect();
		$result = $this->queryDb($query);
		$this->freeResult($this->resultResource);
		if($result && is_array($result)) {
			$result = $result[0];
		}
		return $result;
	}

	/**
	 * Return the enum values from a field in the database
	 */
	public function selectEnum() {
		$table = $this->getTableString();
		$column = $this->getColumnString();
		$this->connect();
		$sql = "SHOW COLUMNS FROM {$table} LIKE '{$column}'";
		$result=mysql_query($sql, $this->dbLinkIdentifier);
		if($error = $this->getError()) {
			$this->error($error);
		}
		$options = array();
		if(mysql_num_rows($result)>0){
			$row=mysql_fetch_row($result);
			$temp=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
			foreach($temp as $option){
				$options[$option] = $option;
			}
		}
		return $options;
	}

	/**
	 * Get the select query
	 * @return string
	 */
	public function getSelect($queryObject=null) {
		if(!is_null($queryObject)) {
			$sql = "( \n /*begin subselect*/ \n".$queryObject->getSelect()."\n /*end subselect*/ \n)";
		} else {
			$sql= 'SELECT';
			$sql .= $this->getColumnString($queryObject);
			$sql .= ' FROM '.$this->getTableString($queryObject);
			$sql .= $this->getJoinString($queryObject);
			$sql .= $this->getWhereString($queryObject);
			$sql .= $this->getGroupByString($queryObject);
			$sql .= $this->getOrderByString($queryObject);
			$sql .= $this->getLimitString($queryObject);
			$sql .= $this->getOffsetString($queryObject);
		}
		return $sql;
	}

	/**
	 * Get the delete query
	 * @return string
	 */
	public function getDelete($queryObject=null) {
		$sql = 'DELETE ';
		$sql .= ' FROM '.$this->getTableString();
		$sql .= $this->getWhereString();
		$sql .= $this->getOrderByString();
		$sql .= $this->getLimitString();
		return $sql;
	}

	/**
	 * Delete something
	 * @return int
	 */
	public function delete() {
		$sql = $this->getDelete();
		$this->queryDb($sql);
		$this->affectedRows = mysql_affected_rows($this->dbLinkIdentifier);
		return $this->affectedRows;
	}

	/**
	 * Get the affected rows
	 * @return int
	 */
	public function affectedRows() {
		return $this->affectedRows;
	}

	/**
	 * Get the insert Query
	 * @return string
	 */
	public function getInsert() {
		$tables = $this->getTableString();
		$sql= "INSERT INTO {$tables}";
		$sql .= $this->getFieldString();
		$sql .= $this->getValueString();
		return $sql;
	}

	/**
	 * Get the count query
	 * @return string
	 */
	public function getCount() {
		$sql  = 'SELECT';
		$sql .= ' COUNT(*) ' . "\n";
		$sql .= ' FROM '.$this->getTableString();
		$sql .= $this->getJoinString();
		$sql .= $this->getWhereString();
		$sql .= $this->getGroupByString();
		$sql .= $this->getOrderByString();
		$sql .= $this->getLimitString();
		$sql .= $this->getOffsetString();
		return $sql;
	}
	/**
	 * Get the update query
	 * @return <type>
	 */
	public function getUpdate() {
		$tables = $this->getTableString();
		$sql= "UPDATE $tables";
		$sql .= " SET" . $this->getFieldValueString()."\n";
		$sql .= $this->getWhereString();
		$sql .= $this->getJoinString();
		$sql .= $this->getLimitString();
		$sql .= $this->getOffsetString();
		return $sql;
	}
	/**
	 * Get the fields of the specified table
	 */
	public function tableFields() {
		$tables = $this->getTableString();
		$result = $this->queryDb('DESCRIBE '. $tables);
		foreach($result as $r) {
			$fields[$r['Field']] = $r['Field'];
		}
		return $fields;
	}

	public function describe() {
		$tables = $this->getTableString();
		$result = $this->queryDb('DESCRIBE '. $tables);
		$this->freeResult();
		return $result;
	}

	public function insert() {
		$sql = $this->getInsert();
		$this->queryDb($sql);
		$this->lastInsertId = mysql_insert_id($this->dbLinkIdentifier);
		return $this->lastInsertId;
	}

	public function update() {
		$sql = $this->getUpdate();
		$this->queryDb($sql);
		$this->affectedRows = mysql_affected_rows($this->dbLinkIdentifier);
		/**
		 * When using UPDATE, MySQL will not update columns where the new value is the
		 * same as the old value. This creates the possibility that
		 * mysql_affected_rows may not actually equal the number
		 * of rows matched, only the number of rows that were literally affected by
		 * the query.
		 */
		if($this->affectedRows === 0){
			$this->affectedRows = true;
		}
		return $this->affectedRows;
	}

	/**
	 * Get the last insert id returned
	 * @return int
	 */
	public function lastInsertId() {
		if($this->lastInsertId){
			return $this->lastInsertId;
		}
		return null;
	}

	/**
	 * Get the count from the query
	 * @return string
	 */
	public function count() {
		$sql = $this->getCount();
		$result = $this->queryDb($sql);
		$result = (int)$result[0]['COUNT(*)'];
		$this->freeResult($this->resultResource);
		return $result;
	}

	/**
	 * Escape a variable
	 * @param $value
	 * @return <type>
	 */
	private function escape($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if(!$this->dbLinkIdentifier){
			$this->connect();
		}
		return mysql_real_escape_string($value, $this->dbLinkIdentifier);
	}
	/**
	 * Get the string for the columns
	 * @return <type>
	 */
	private function getColumnString() {
		$sql = '';
		$columns = $this->query->getColumns();
		if($columns) {
			$sql.= ' '. implode(", ", $columns) . "\n";
		} else {
			$sql .= ' * ' . "\n";
		}
		return rtrim($sql);
	}

	private function getJoinString() {
		$joins = $this->query->getJoins();
		$sql = '';
		if($joins) {
			$sql .= "\n " . implode("\n ", $joins) . "\n";
		}
		return $sql;
	}

	private function getTableString() {
		$tables = $this->query->getTables();
		$sql = '';
		if($tables) {
			$sql .= implode(', ', $tables) . "\n";
		}
		return $sql;
	}

	private function getWhereString() {
		$whereArray = $this->query->getWheres();
		$sql = '';
		if ($whereArray['columns']) {
			$sql .= ' WHERE ';
			foreach($whereArray['columns'] as $k=>$column) {
				if(is_object($whereArray['values'][$k])) {
					$whereArray['values'][$k] = $this->getSelect($whereArray['values'][$k]);
				}
				$whereString = "{$whereArray['columns'][$k]} {$whereArray['comparisons'][$k]} {$whereArray['values'][$k]}";
				if($k == 0) {
					$sql.= " $whereString \n";
					continue;
				}
				$sql .= "  AND $whereString \n";
			}
		}
		return $sql;
	}

	private function getFieldString() {
		$fields = $this->query->getFields();
		$sql = ' (';
		$sql.= implode(', ', $fields);
		$sql.= ") \n";
		return $sql;
	}

	private function getValueString() {
		$values = $this->query->getValues();
		$sql = ' VALUES';
		$sql.= ' (';
		$sql.= implode(', ', $values);
		$sql.= ") \n";
		return $sql;
	}

	private function getFieldValueString() {
		$fields = $this->query->getFields();
		$values = $this->query->getValues();
		$sql = '';
		foreach($fields as $i=>$field) {
			if($i != 0) {
				$sql .= ', ';
			}
			$sql .= ' ' . $fields[$i] . ' = '. $values[$i];
		}
		return $sql;
	}

	private function getGroupByString() {
		$groupBys = $this->query->getGroupBys();
		$sql = '';
		if ($groupBys) {
			$sql .= " GROUP BY ";
			$sql .= implode(", ", $groupBys);
			$sql .= "\n";
		}
		return $sql;
	}

	private function getOrderByString() {
		$orderBys = $this->query->getOrderBys();
		$sql = '';
		if ($orderBys) {
			$sql .= " ORDER BY ";
			$sql .= implode(", ", $orderBys);
			$sql .= "\n";
		}
		return $sql;
	}

	private function getLimitString() {
		$limit = $this->query->getLimit();
		$sql = '';
		if ($limit) {
			$sql.= " LIMIT $limit\n";
		}
		return $sql;
	}

	private function getOffsetString() {
		$offset = $this->query->getOffset();
		$sql = '';
		if ($offset) {
			$sql .= " OFFSET $offset\n";
		}
		return $sql;
	}
}
