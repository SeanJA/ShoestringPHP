<?php

/**
 * @property int $id
 */
class objectmodel extends sModel{
	/**
	 * The data array
	 * @var array
	 */
	protected $data = array();
	/**
	 * The query object
	 * @var sQuery
	 */
	protected $q;
	/**
	 * The name of the table
	 * @var string
	 */
	protected $tableName;
	public function  __construct($table) {
		parent::__construct();
		$this->q = new sQuery();
		$this->tableName = $table;
	}
	/**
	 * Load an instance from the table
	 * @param int $id
	 */
	public function load($id){
		$this->q->newQuery();
		$this->data = $this->q->table($this->tableName)->where('id', $id);
	}
	/**
	 * Save the data to the table
	 */
	public function save(){
		$this->q->newQuery();
		$this->q->into($this->tableName);
		foreach($this->data as $column=>$value){
			$this->q->set($column, $value);
		}
		$this->q->where('id', $this->id);
		$this->q->update();
	}
	/**
	 * Get a value from the data array
	 * @param string $name
	 * @return mixed
	 */
	public function  __get($name) {
		$getter = '_get'.$name;
		$value = (method_exists($this, $getter))? $this->$getter() : $this->data[$name];
		return $value;
	}
	/**
	 * Set a value in the data array
	 * @param string $name
	 * @param mixed $value
	 * @return mixed
	 */
	public function  __set($name, $value) {
		$setter = '_set'.$name;
		if(method_exists($this, $setter)){
			$value = $this->$setter($value);
		}
		return $this->data[$name] = $value;
	}
	/**
	 * Create a new instance in the table
	 */
	public function create(){
		$this->q->newQuery();
		$this->q->into($this->tableName);
		foreach($this->data as $column=>$value){
			$this->q->set($column, $value);
		}
		$this->q->insert();
	}
	/**
	 * Delete an instance from the table
	 */
	public function delete(){
		$this->q->newQuery();
		$this->q->into($this->tableName);
		foreach($this->data as $column=>$value){
			$this->q->set($column, $value);
		}
		$this->q->where('id', $this->id);
		$this->q->delete();
	}
}
