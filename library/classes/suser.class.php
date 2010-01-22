<?php

class sUser extends sRoot{
  /*Settings*/
	/**
	 * The database table that holds all the information
	 * var string
	 */
	private $table;
	/**
	 * The session variable ($_SESSION[$sessionVariable]) which will hold the data while the user is logged on
	 * var string
	 */
	private $session = 'user';
	/**
	 * Those are the fields that our table uses in order to fetch the needed data. The structure is 'fieldType' => 'fieldName'
	 * var array
	 */
	private $fields;
	/**
	 * When user wants the system to remember him/her, how much time to keep the cookie? (seconds)
	 * var int
	 */
	private $keepAlive = 2592000;//One month
	/**
	 * The name of the cookie which we will use if user wants to be remembered by the system
	 * var string
	 */
	private $cookie = 'ckSavePass';
	/**
	 * The cookie domain
	 * var string
	 */
	private $domain = '';
	/**
	 * The method used to encrypt the password. It can be sha1, md5 or nothing (no encryption)
	 * var string
	 */
	private $encryption;
    /**
     * The encryption types that we allow
     * @var array
     */
	private $encryptionTypes = array('sha1', 'md5');
	

	private $userId;
	private $userData=array();
	/**
	 * Class Constructor
	 *
	 * @param string $dbConn
	 * @param array $settings
	 * @return void
	 */
	public function  __construct($id='') {
		parent::__construct();
		$this->table = $this->config->users['table'];
		$this->encryption = $this->config->users['encryption'];
		$this->domain = $this->domain == '' ? $_SERVER['SERVER_NAME'] : $this->domain;
		$this->fields = $this->config->users['fields'];
		if($this->config->users['session_name']){
			$this->session = $this->config->users['session_name'];
		}
		if( !isset( $_SESSION )) {
			session_start();
		}
		if ( !empty($_SESSION[$this->session]) && !$id ) {
			$this->loadUser( $_SESSION[$this->session] );
		} elseif(!empty($_SESSION[$this->session]) && $id) {
			$this->loadUser($id);
		}
	}

	/**
	 * Login function
	 * @param string $username
	 * @param string $password
	 * @param bool $loadUser
	 * @return bool
	 */
	public function login($username, $password, $loadUser = true) {
		$password = $this->encrypt($password);
		$q = new sQuery();
		$q->from($this->table);
		$q->addWhere($this->fields['username'], $username);
		$q->addWhere($this->fields['password'], $password);
		$q->setLimit(1);
		$user = $q->selectRow();
		if(empty($user)){
			$this->error('The username/password combination that you entered does not exist');
			return false;
		}
		if ( $loadUser ) {
			$this->userData = $user;
			$this->userId = $this->userData[$this->fields['id']];
			$_SESSION[$this->session] = $this->userId;
		}
		//if we are tracking the number of logins
		if(isset($this->fields['logins']) && isset($this->userData[$this->fields['logins']])){
			$q = new sQuery();
			$q->from($this->table);
			$this->userData[$this->fields['logins']] += 1;
			$q->addField($this->fields['logins'], $this->userData[$this->fields['logins']]);
			$q->addWhere($this->fields['id'], $this->userData[$this->fields['id']]);
			$q->update();
		}
		return true;
	}

	/**
	 * Logout function
	 * param string $redirectTo
	 * @return bool
	 */
	public function logout($redirectTo = '') {
		if(isset($_SESSION[$this->session])){
			unset($_SESSION[$this->session]);
		}
		$this->userData = array();
		$this->userId = '';
		return true;
	}

	/**
	 * Retrieve a user value (using the names of the columns in your users table)
	 * @param string $var
	 * @return multiple
	 */
	public function  __get($var) {
		if (empty($this->userId)) {
			$this->error('No user is loaded');
		}
		if (!isset($this->userData[$var])) {
			$this->error('Unknown property <b>'.$var.'</b>');
		}
		return $this->userData[$var];
	}

	/**
	 * Get the user data that has been loaded already
	 * @return array
	 */
	public function getUserData(){
		if (empty($this->userId)) {
			$this->error('Cannot get user data. No user is loaded');
		}
		return $this->userData;
	}

	/**
	 * Get the user fields from the database
	 * @return array
	 */
	public function getUserFields() {
		$q = new sQuery();
		$q->from('users');
		return $q->tableFields();
	}

	/**
	 * Is the user logged in?
	 * @ return bool
	 */
	public function loggedIn() {
		return isset($this->userId) && $this->userId && !empty($this->userData);
	}

	/**
	 * Activates the user account
	 * @return bool
	 */
	public function activate() {
		if (empty($this->userId)) {
			$this->error('No user is loaded');
		}
		if ( $this->is_active()) {
			$this->error('Allready active account');
		}
		$q = new sQuery();
		$q->from($this->table);
		$q->addField($this->fields['active'], 1);
		$q->addWhere($this->fields['id'], $this->userId);
		$q->setLimit(1);
		if ($q->update() == 1) {
			$this->userData[$this->fields['active']] = true;
			return true;
		}
		return false;
	}

	/**
	 * Creates a user account. The array should have the form 'database field' => 'value'
	 * @param array $data
	 * return int
	 */
	public function newUser($data) {
		if (!is_array($data)) {
			$this->error('Data is not an array');
		}
		$data['password'] = $this->encrypt($data['password']);
		$q = new sQuery();
		$q->into($this->table);
		foreach($data as $field=>$value) {
			$q->addField($field, $value);
		}
		$q->insert();
		return $q->lastInsertId();
	}

	/**
	 * Creates a random password.
	 * @return string
	 */
	public function randomPass() {
		return base_convert(mt_rand(pow(39, 9), mt_getrandmax()), 10, 26);
	}

	public function getUserLevels(){
		$q = new sQuery();
		$q->from($this->table);
		$q->addColumn($this->fields['level']);
		return $q->selectEnum();
	}
	
	/**
	 * A function that is used to load one user's data
	 * @param string $userId
	 * @return bool
	 */
	private function loadUser($userId) {
		$q = new sQuery();
		$q->from($this->table);
		$q->addWhere($this->fields['id'], $userId);
		$q->setLimit(1);
		$this->userData = $q->selectRow();
		if(!$this->userData) {
			$this->error('Could not load user');
		}
		if(count($this->userData) != count($this->fields)){
			$this->error('Your user config field count ('.count($this->fields).') does not match the database field count ('.count($this->userData).')');
		}
		$this->userId = $userId;
		//if we already have a session var we are already logged in and
		//are now loading another user to do something with
		if(!isset($_SESSION[$this->session])){
			$_SESSION[$this->session] = $this->userId;
		}
		return true;
	}
	
	

	/**
	 * Encrypt something (a password maybe?)
	 * @param <type> $str
	 * @return str but it has been encrypted
	 */
	private function encrypt($str) {
		if(in_array($this->encryption, $this->encryptionTypes)) {
			if($this->encryption == 'md5') {
				$str = md5($str.md5($str));
			}
			elseif($this->encryption == 'sha1'){
				$str = sha1($str.sha1($str));
			}
		//$str = strtoupper($this->encryption) . "('$str')";
		} else {
			$str = "'$str'";
		}
		return $str;
	}


}