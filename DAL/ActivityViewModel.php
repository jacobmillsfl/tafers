<?php
/*
Author:		 Jacob Mills
Date:			6/29/2018
Description:	Creates the DAL class for UserStatsViewModel

*/



class ActivityViewModel {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $userId;
    protected $imgUrl;
    protected $description;
    protected $eventDate;
    protected $eventType;

    /******************************************************************/
    // Constructors
    /******************************************************************/
    public function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__constructBase();
                break;
            case 5:
                self::__constructFull( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4]);
        }
    }


    public function __constructBase() {
        $this->userId = 0;
        $this->imgUrl = "";
        $this->description = "";
        $this->eventDate = "";
        $this->eventType = "";
    }

    public function __constructFull($uid,$imgurl,$description,$eventDate,$eventType) {
      $this->userId = $uid;
      $this->imgUrl = $imgurl;
      $this->description = $description;
      $this->eventDate = $eventDate;
      $this->eventType = $eventType;
    }


    /******************************************************************/
    // Accessors / Mutators
    /******************************************************************/

    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($value){
        $this->userId = $value;
    }
    public function getImgUrl(){
        return $this->imgUrl;
    }
    public function setImgUrl($value){
        $this->imgUrl = $value;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setDescription($value){
        $this->description = $value;
    }
    public function getEventDate(){
        return $this->eventDate;
    }
    public function setEventDate($value){
        $this->eventDate = $value;
    }
    public function getEventType(){
        return $this->eventType;
    }
    public function setEventType($value){
        $this->eventType = $value;
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

    public static function loadRecentActivity() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_LoadRecentActivity()');
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);


				if ($result->num_rows > 0) {
					$arr = array();
					while ($row = $result->fetch_assoc()) {
						$songCommentViewModel = new ActivityViewModel($row['UserId'],$row['ImgUrl'],$row['Description'],$row['EventDate'],$row['EventType']);
						$arr[] = $songCommentViewModel;
					}
					return $arr;
				}
				else {
					return array();
				}
    }

}
