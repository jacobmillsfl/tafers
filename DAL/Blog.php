<?php

/*
Author:			This code was generated by DALGen Web available at https://dalgen.opendevtools.org
Date:			11/01/2019
Description:		Creates the Blog class with methods for interacting with respective stored procedures

*/

class Blog {

	// This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
	protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

	/******************************************************************/
	// Properties
	/******************************************************************/

	protected $id;
	protected $createdByUserId;
	protected $bandId;
	protected $createDate;
	protected $message;


	/******************************************************************/
	// Constructors
	/******************************************************************/
	public function __construct() {
		$argv = func_get_args();

		switch( func_num_args() ) {
			case 0:
				self::__constructBase();
				break;
			case 1:
				self::__constructPK( $argv[0] );
				break;
			case 5:
				self::__constructFull($argv[0], $argv[1], $argv[2], $argv[3], $argv[4]);
		}
	}


	public function __constructBase() {
		$this->id = 0;
		$this->createdByUserId = 0;
		$this->bandId = 0;
		$this->createDate = '';
		$this->message = '';
	}

	public function __constructPK($paramId) {
		$this->load($paramId);
	}

	public function __constructFull($paramId, $paramCreatedByUserId, $paramBandId, $paramCreateDate, $paramMessage){
		$this->id = $paramId;
		$this->createdByUserId = $paramCreatedByUserId;
		$this->bandId = $paramBandId;
		$this->createDate = $paramCreateDate;
		$this->message = $paramMessage;
	}


	/******************************************************************/
	// Accessors / Mutators
	/******************************************************************/
	public function getId(){
		return $this->id;
	}
	public function setId($value){
		 $this->id = $value;
	}
	public function getCreatedByUserId(){
		return $this->createdByUserId;
	}
	public function setCreatedByUserId($value){
		 $this->createdByUserId = $value;
	}
	public function getBandId(){
		return $this->bandId;
	}
	public function setBandId($value){
		 $this->bandId = $value;
	}
	public function getCreateDate(){
		return $this->createDate;
	}
	public function setCreateDate($value){
		 $this->createDate = $value;
	}
	public function getMessage(){
		return $this->message;
	}
	public function setMessage($value){
		 $this->message = $value;
	}

	/******************************************************************/
	// Public Methods
	/******************************************************************/
	public function load($paramId) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_Load(?)');
		$stmt->bind_param('i', $paramId);
		$stmt->execute();

		$result = $stmt->get_result();
		if (!$result) die($conn->error);

		while ($row = $result->fetch_assoc()) {
			 $this->setId($row['id']);
			 $this->setCreatedByUserId($row['createdByUserId']);
			 $this->setBandId($row['bandId']);
			 $this->setCreateDate($row['createDate']);
			 $this->setMessage($row['message']);
		}
	}

	public function save() {
		if ($this->getId() == 0)
			$this->insert();
		else
			$this->update();
	}

	/******************************************************************/
	// Private Methods
	/******************************************************************/


	private function insert() {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_Add(?,?,?,?)');
		$arg1 = $this->getCreatedByUserId();
		$arg2 = $this->getBandId();
		$arg3 = $this->getCreateDate();
		$arg4 = $this->getMessage();
		$stmt->bind_param('iiss',$arg1,$arg2,$arg3,$arg4);
		$stmt->execute();

		$result = $stmt->get_result();
		if (!$result) die($conn->error);
		while ($row = $result->fetch_assoc()) {
			// By default, the DALGen generated INSERT procedure returns the scope identity as id
			$this->load($row['id']);
		}
	}

	private function update() {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_Update(?,?,?,?,?)');
		$arg1 = $this->getId();
		$arg2 = $this->getCreatedByUserId();
		$arg3 = $this->getBandId();
		$arg4 = $this->getCreateDate();
		$arg5 = $this->getMessage();
		$stmt->bind_param('iiiss',$arg1,$arg2,$arg3,$arg4,$arg5);
		$stmt->execute();
	}

	public static function setNullValue($value){
		if ($value == "")
			return null;
		else
			return $value;
	}



	/******************************************************************/
	// Static Methods
	/******************************************************************/

	public static function loadall(){
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_LoadAll()');
		$stmt->execute();
		$result = $stmt->get_result();
		if (!$result) die($conn->error);
		$arr = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$blog = new Blog($row['id'],$row['createdByUserId'],$row['bandId'],$row['createDate'],$row['message']);
				$arr[] = $blog;
			}
		}

		return $arr;
	}

	public static function remove($paramId) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_Remove(?)');
		$stmt->bind_param('i', $paramId);
		$stmt->execute();
	}

	public static function search($paramId,$paramCreatedByUserId,$paramBandId,$paramCreateDate,$paramMessage) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Blog_Search(?,?,?,?,?)');
		$arg1 = Blog::setNullValue($paramid);
		$arg2 = Blog::setNullValue($paramcreatedByUserId);
		$arg3 = Blog::setNullValue($parambandId);
		$arg4 = Blog::setNullValue($paramcreateDate);
		$arg5 = Blog::setNullValue($parammessage);
		$stmt->bind_param('iiiss',$arg1,$arg2,$arg3,$arg4,$arg5);
		$stmt->execute();
		$result = $stmt->get_result();
		if (!$result) die($conn->error);
		$arr = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$blog = new Blog($row['id'],$row['createdByUserId'],$row['bandId'],$row['createDate'],$row['message']);
				$arr[] = $blog;
			}
		}

		return $arr;
	}

}

