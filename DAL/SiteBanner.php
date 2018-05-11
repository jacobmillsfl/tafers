<?php
/*
Author:         Jacob Mills
Date:           09/20/2017
Description:    DAL class for SiteBanner

*/



class SiteBanner {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() {
        return "DAL/db_localsettings.php";
    }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $id;
    protected $message;
    protected $title;
    protected $imgUrl;

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
            case 4:
                self::__constructFull( $argv[0], $argv[1], $argv[2], $argv[3] );
        }
    }

    public function __constructBase() {
        $this->id = 0;
        $this->title = "";
        $this->message = "";
        $this->imgUrl = "";
    }

    public function __constructPK($paramId) {
        $this->load($paramId);
    }

    public function __constructFull($paramId,$paramTitle,$paramMessage,$paramImgUrl) {
        $this->id = $paramId;
        $this->title = $paramTitle;
        $this->message = $paramMessage;
        $this->imgUrl = $paramImgUrl;
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
    public function getMessage(){
        return $this->message;
    }
    public function setMessage($value){
        $this->message = $value;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($value){
        $this->title = $value;
    }
    public function getImgUrl(){
        return $this->imgUrl;
    }
    public function setImgUrl($value){
        $this->imgUrl = $value;
    }

    /******************************************************************/
    // Public Methods
    /******************************************************************/

    public function load($paramId) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_Load(?)');
        $stmt->bind_param('i', $paramId);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);

        while ($row = $result->fetch_assoc()) {
            $this->setId($row['id']);
            $this->setTitle($row['title']);
            $this->setMessage($row['message']);
            $this->setImgUrl($row['imgUrl']);
        }
    }

    public function save() {
        if ($this->getId() == 0)
            $this->insert();
        else
            $this->update();
    }

    /******************************************************************/
    // Public Methods
    /******************************************************************/

    private function insert() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_Add(?,?,?)');
        $arg1 = $this->getTitle();
        $arg2 = $this->getMessage();
        $arg3 = $this->getImgUrl();
        $stmt->bind_param('sss',$arg1,$arg2,$arg3);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        while ($row = $result->fetch_assoc()) {
            $this->load($row['id']);
        }
    }

    private function update() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_Update(?,?,?,?)');
        $arg1 = $this->getId();
        $arg2 = $this->getTitle();
        $arg3 = $this->getMessage();
        $arg4 = $this->getImgUrl();
        $stmt->bind_param('isss', $arg1,$arg2,$arg3,$arg4);
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

    public static function loadall() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_LoadAll');
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
            $arr = array();
            while ($row = $result->fetch_assoc()) {

                $siteBanner = new SiteBanner($row['id'],$row['title'],$row['message'],$row['imgUrl']);
                $arr[] = $siteBanner;
            }
            return $arr;
        }
        else {
            die("The query yielded zero results. No rows found.");
        }
    }

    public static function remove($paramId) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_Delete(?)');
        $stmt->bind_param('i', $paramId);
        $stmt->execute();
    }

    public static function search($paramId,$paramTitle,$paramMessage,$paramImgUrl) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_SiteBanner_Search(?,?,?,?)');
        $arg1 = SiteBanner::setNullValue($paramId);
        $arg2 = SiteBanner::setNullValue($paramTitle);
        $arg3 = SiteBanner::setNullValue($paramMessage);
        $arg4 = SiteBanner::setNullValue($paramImgUrl);
        $stmt->bind_param('isss', $arg1,$arg2,$arg3,$arg4);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
            $arr = array();
            while ($row = $result->fetch_assoc()) {

                $siteBanner = new SiteBanner($row['id'],$row['title'],$row['message'],$row['imgUrl']);
                $arr[] = $siteBanner;
            }
            return $arr;
        }
        else {
            die("The query yielded zero results. No rows found.");
        }
    }
}
