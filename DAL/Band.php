<?php

/*
Author:			This code was generated by DALGen Web available at https://dalgen.opendevtools.org
Date:			10/31/2019
Description:		Creates the Band class with methods for interacting with respective stored procedures

*/

class Band {

	// This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
	protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

	/******************************************************************/
	// Properties
	/******************************************************************/

	protected $id;
	protected $name;
	protected $createDate;
	protected $genre;
	protected $description;


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
		$this->name = '';
		$this->createDate = '';
		$this->genre = '';
		$this->description = '';
	}

	public function __constructPK($paramId) {
		$this->load($paramId);
	}

	public function __constructFull($paramId, $paramName, $paramCreateDate, $paramGenre, $paramDescription){
		$this->id = $paramId;
		$this->name = $paramName;
		$this->createDate = $paramCreateDate;
		$this->genre = $paramGenre;
		$this->description = $paramDescription;
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
	public function getName(){
		return $this->name;
	}
	public function setName($value){
		 $this->name = $value;
	}
	public function getCreateDate(){
		return $this->createDate;
	}
	public function setCreateDate($value){
		 $this->createDate = $value;
	}
	public function getGenre(){
		return $this->genre;
	}
	public function setGenre($value){
		 $this->genre = $value;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setDescription($value){
		 $this->description = $value;
	}

	/******************************************************************/
	// Public Methods
	/******************************************************************/
	public function load($paramId) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Band_Load(?)');
		$stmt->bind_param('i', $paramId);
		$stmt->execute();

		$result = $stmt->get_result();
		if (!$result) die($conn->error);

		while ($row = $result->fetch_assoc()) {
			 $this->setId($row['id']);
			 $this->setName($row['name']);
			 $this->setCreateDate($row['createDate']);
			 $this->setGenre($row['genre']);
			 $this->setDescription($row['description']);
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
		$stmt = $conn->prepare('CALL usp_Band_Add(?,?,?,?)');
		$arg1 = $this->getName();
		$arg2 = $this->getCreateDate();
		$arg3 = $this->getGenre();
		$arg4 = $this->getDescription();
		$stmt->bind_param('ssss',$arg1,$arg2,$arg3,$arg4);
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
		$stmt = $conn->prepare('CALL usp_Band_Update(?,?,?,?,?)');
		$arg1 = $this->getId();
		$arg2 = $this->getName();
		$arg3 = $this->getCreateDate();
		$arg4 = $this->getGenre();
		$arg5 = $this->getDescription();
		$stmt->bind_param('issss',$arg1,$arg2,$arg3,$arg4,$arg5);
		$stmt->execute();
	}

	private static function setNullValue($value){
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
		$stmt = $conn->prepare('CALL usp_Band_LoadAll()');
		$stmt->execute();
		$result = $stmt->get_result();
		if (!$result) die($conn->error);
		$arr = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$band = new Band($row['id'],$row['name'],$row['createDate'],$row['genre'],$row['description']);
				$arr[] = $band;
			}
		}

		return $arr;
	}

	public static function remove($paramId) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Band_Remove(?)');
		$stmt->bind_param('i', $paramId);
		$stmt->execute();
	}

	public static function search($paramId,$paramName,$paramCreateDate,$paramGenre,$paramDescription) {
		include(self::getDbSettings());
		$conn = new mysqli($servername, $username, $password, $dbname);
		$stmt = $conn->prepare('CALL usp_Band_Search(?,?,?,?,?)');
		$arg1 = Band::setNullValue($paramid);
		$arg2 = Band::setNullValue($paramname);
		$arg3 = Band::setNullValue($paramcreateDate);
		$arg4 = Band::setNullValue($paramgenre);
		$arg5 = Band::setNullValue($paramdescription);
		$stmt->bind_param('issss',$arg1,$arg2,$arg3,$arg4,$arg5);
		$stmt->execute();
		$result = $stmt->get_result();
		if (!$result) die($conn->error);
		$arr = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$band = new Band($row['id'],$row['name'],$row['createDate'],$row['genre'],$row['description']);
				$arr[] = $band;
			}
		}

		return $arr;
	}

}

