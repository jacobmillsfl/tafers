<?php
/*
Author:		 Jacob Mills
Date:			6/8/2018
Description:	Creates the DAL class for  File table and respective stored procedures

*/



class ToDoItemCountsViewModel {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $total;
    protected $open;
    protected $closed;

    /******************************************************************/
    // Constructors
    /******************************************************************/
    public function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__constructBase();
                break;
            case 3:
                self::__constructFull( $argv[0], $argv[1], $argv[2]);
        }
    }


    public function __constructBase() {
        $this->total = 0;
        $this->open = 0;
        $this->closed = 0;
    }

    public function __constructFull($paramTotal,$paramOpen,$paramClosed) {
			$this->total = $paramTotal;
			$this->open = $paramOpen;
			$this->closed = $paramClosed;
    }


    /******************************************************************/
    // Accessors / Mutators
    /******************************************************************/

    public function getTotal(){
        return $this->total;
    }
    public function setTotal($value){
        $this->total = $value;
    }
		public function getOpen(){
				return $this->open;
		}
		public function setOpen($value){
				$this->open = $value;
		}
		public function getClosed(){
				return $this->closed;
		}
		public function setClosed($value){
				$this->closed = $value;
		}


    /******************************************************************/
    // Public Methods
    /******************************************************************/
    private static function setNullValue($value){
        if ($value == "")
            return null;
        else
            return $value;
    }

    public static function loadTotalCounts() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_ToDoItem_GetCounts()');
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						return new ToDoItemCountsViewModel($row['total'],$row['open'],$row['closed']);
        }
        else {
            return new ToDoItemCountsViewModel();
        }
    }

}
