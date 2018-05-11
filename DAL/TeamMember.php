<?php
/*
Author:         Jacob Mills
Date:           09/20/2017
Description:    DAL class for TeamMember

*/




class TeamMember {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() {
        return "DAL/db_localsettings.php";
    }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $id;
    protected $name;
    protected $title;
    protected $bio;
    protected $email;
    protected $createDate;
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
            case 7:
                self::__constructFull( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6] );
        }
    }

    public function __constructBase() {
        $this->id = 0;
        $this->name = "";
        $this->title = "";
        $this->bio = "";
        $this->email = "";
        $this->createDate = "";
        $this->imgUrl = "";
    }

    public function __constructPK($paramId) {
        $this->load($paramId);
    }

    public function __constructFull($paramId,$paramName,$paramTitle,$paramBio,$paramEmail,$paramCreateDate,$paramImgUrl) {
        $this->id = $paramId;
        $this->name = $paramName;
        $this->title = $paramTitle;
        $this->bio = $paramBio;
        $this->email = $paramEmail;
        $this->createDate = $paramCreateDate;
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
    public function getName(){
        return $this->name;
    }
    public function setName($value){
        $this->name = $value;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setTitle($value){
        $this->title = $value;
    }
    public function getBio(){
        return $this->bio;
    }
    public function setBio($value){
        $this->bio = $value;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($value){
        $this->email = $value;
    }
    public function getCreateDate(){
        return $this->createDate;
    }
    public function setCreateDate($value){
        $this->createDate = $value;
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
        $stmt = $conn->prepare('CALL usp_TeamMember_Load(?)');
        $stmt->bind_param('i', $paramId);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);

        while ($row = $result->fetch_assoc()) {
            $this->setId($row['id']);
            $this->setName($row['name']);
            $this->setTitle($row['title']);
            $this->setBio($row['bio']);
            $this->setEmail($row['email']);
            $this->setCreateDate($row['createDate']);
            $this->setCreateDate($row['imgUrl']);
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
        $stmt = $conn->prepare('CALL usp_TeamMember_Add(?,?,?,?,?,?)');
        $arg1 = $this->getName();
        $arg2 = $this->getTitle();
        $arg3 = $this->getBio();
        $arg4 = $this->getEmail();
        $arg5 = $this->getCreateDate();
        $arg6 = $this->getImgUrl();
        $stmt->bind_param('ssssss',$arg1,$arg2,$arg3,$arg4,$arg5,$arg6);
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
        $stmt = $conn->prepare('CALL usp_TeamMember_Update(?,?,?,?,?,?,?)');
        $arg1 = $this->getId();
        $arg2 = $this->getName();
        $arg3 = $this->getTitle();
        $arg4 = $this->getBio();
        $arg5 = $this->getEmail();
        $arg6 = $this->getCreateDate();
        $arg7 = $this->getImgUrl();
        $stmt->bind_param('isssss', $arg1,$arg2,$arg3,$arg4,$arg5,$arg6,$arg7);
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
        $stmt = $conn->prepare('CALL usp_TeamMember_LoadAll');
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
            $arr = array();
            while ($row = $result->fetch_assoc()) {

                $teamMember = new TeamMember($row['id'],$row['name'],$row['title'],$row['bio'],$row['email'],$row['createDate'],$row['imgUrl']);
                $arr[] = $teamMember;
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
        $stmt = $conn->prepare('CALL usp_TeamMember_Delete(?)');
        $stmt->bind_param('i', $paramId);
        $stmt->execute();
    }

    public static function search($paramId,$paramName,$paramTitle,$paramBio,$paramEmail,$paramCreateDate,$paramImgUrl) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_TeamMember_Search(?,?,?,?,?,?,?)');
        $arg1 = TeamMember::setNullValue($paramId);
        $arg2 = TeamMember::setNullValue($paramName);
        $arg3 = TeamMember::setNullValue($paramTitle);
        $arg4 = TeamMember::setNullValue($paramBio);
        $arg5 = TeamMember::setNullValue($paramEmail);
        $arg6 = TeamMember::setNullValue($paramCreateDate);
        $arg7 = TeamMember::setNullValue($paramImgUrl);
        $stmt->bind_param('issssss', $arg1,$arg2,$arg3,$arg4,$arg5,$arg6,$arg7);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
            $arr = array();
            while ($row = $result->fetch_assoc()) {

                $teamMember = new TeamMember($row['id'],$row['name'],$row['title'],$row['bio'],$row['email'],$row['createDate'],$row['imgUrl']);
                $arr[] = $teamMember;
            }
            return $arr;
        }
        else {
            die("The query yielded zero results. No rows found.");
        }
    }
}
