<?php
/*
Author:			This code was generated by DALGen version 1.1.0.0 available at https://github.com/H0r53/DALGen
Date:			3/7/2018
Description:	Creates the DAL class for  File table and respective stored procedures

*/



class FileUserViewModel {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $fileId;
    protected $fileName;
    protected $uploadIP;
    protected $uploadDate;
    protected $fileExtension;
    protected $fileSize;
    protected $fileType;
    protected $isPublic;
    protected $userId;
    protected $username;
    protected $email;
    protected $imgUrl;
    protected $createDate;
    protected $roleId;


    /******************************************************************/
    // Constructors
    /******************************************************************/
    public function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__constructBase();
                break;
            case 14:
                self::__constructFull( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7],
                                        $argv[8], $argv[9], $argv[10], $argv[11], $argv[12], $argv[13], $argv[14] );
        }
    }


    public function __constructBase() {
        // File
        $this->fileId = 0;
        $this->fileName = "";
        $this->uploadIP = "";
        $this->uploadDate = "";
        $this->fileExtension = "";
        $this->fileSize = 0;
        $this->fileType = "";
        $this->isPublic = 0;
        // User
        $this->userId = 0;
        $this->username = "";
        $this->email = "";
        $this->imgUrl = "";
        $this->createDate;
        $this->roleId = 0;
    }


    public function __constructPK($paramId) {
        $this->load($paramId);
    }

    public function __constructFull($paramFileId,$paramFileName,$paramUploadIP,$paramUploadDate,$paramFileExtension,$paramFileSize,$paramFileType,$paramIsPublic
                                    ,$paramUserId,$paramUsername, $paramEmail, $paramImgUrl, $paramCreateDate, $paramRoleId) {
        $this->fileId = $paramFileId;
        $this->fileName = $paramFileName;
        $this->uploadIP = $paramUploadIP;
        $this->uploadDate = $paramUploadDate;
        $this->fileExtension = $paramFileExtension;
        $this->fileSize = $paramFileSize;
        $this->fileType = $paramFileType;
        $this->isPublic = $paramIsPublic;

        // User
        $this->userId = $paramUserId;
        $this->username = $paramUsername;
        $this->email = $paramEmail;
        $this->imgUrl = $paramImgUrl;
        $this->createDate = $paramCreateDate;
        $this->roleId = $paramRoleId;
    }


    /******************************************************************/
    // Accessors / Mutators
    /******************************************************************/

    public function getFileId(){
        return $this->fileId;
    }
    public function setFileId($value){
        $this->fileId = $value;
    }
    public function getFileName(){
        return $this->fileName;
    }
    public function setFileName($value){
        $this->fileName = $value;
    }
    public function getUploadIP(){
        return $this->uploadIP;
    }
    public function setUploadIP($value){
        $this->uploadIP = $value;
    }
    public function getUploadDate(){
        return $this->uploadDate;
    }
    public function setUploadDate($value){
        $this->uploadDate = $value;
    }
    public function getFileExtension(){
        return $this->fileExtension;
    }
    public function setFileExtension($value){
        $this->fileExtension = $value;
    }
    public function getFileSize(){
        return $this->fileSize;
    }
    public function setFileSize($value){
        $this->fileSize = $value;
    }
    public function getFileType(){
        return $this->fileType;
    }
    public function setFileType($value){
        $this->fileType = $value;
    }
    public function getIsPublic(){
        return $this->isPublic;
    }
    public function setIsPublic($value){
        $this->isPublic = $value;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function setUserId($value){
        $this->userId = $value;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setUsername($value){
        $this->username = $value;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($value){
        $this->email = $value;
    }
    public function getImgUrl(){
        return $this->imgUrl;
    }
    public function setImgUrl($value){
        $this->imgUrl = $value;
    }
    public function getCreateDate(){
        return $this->createDate;
    }
    public function setCreateDate($value){
        $this->createDate = $value;
    }
    public function getRoleId(){
        return $this->roleId;
    }
    public function setRoleId($value){
        $this->roleId = $value;
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

    public static function loadFileHome($paramContent,$paramBlogCategoryId,$paramOffset) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_ViewModel_LoadFileHome(?,?,?)');
        $arg1 = FileUserViewModel::setNullValue($paramContent);
        $arg2 = FileUserViewModel::setNullValue($paramBlogCategoryId);
        $arg3 = FileUserViewModel::setNullValue($paramOffset);
        $stmt->bind_param('sii',$arg1,$arg2,$arg3);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
            $arr = array();

            while ($row = $result->fetch_assoc()) {
                $file = new FileUserViewModel($row['fileId'],$row['fileName'],$row['uploadIP'],$row['uploadDate'],$row['fileExtension'],$row['fileSize'],$row['fileType'],$row['isPublic'],
                                $row['userId'],$row['username'],$row['email'],$row['imgUrl'],$row['createDate'],$row['roleId']);
                $arr[] = $file;
            }
            return $arr;
        }
        else {
            $arr = array();
            return $arr;
        }
    }

}