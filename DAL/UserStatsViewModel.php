<?php
/*
Author:		 Jacob Mills
Date:			6/29/2018
Description:	Creates the DAL class for UserStatsViewModel

*/



class UserStatsViewModel {

    // This is for local purposes only! In hosted environments the db_settings.php file should be outside of the webroot, such as: include("/outside-webroot/db_settings.php");
    protected static function getDbSettings() { return "DAL/db_localsettings.php"; }

    /******************************************************************/
    // Properties
    /******************************************************************/

    protected $filesUploaded;
    protected $songsUploaded;
    protected $songComments;
    protected $tasksCreated;
    protected $tasksClosed;
    protected $blogsCreated;
    protected $blogComments;
    protected $blogLikes;

    /******************************************************************/
    // Constructors
    /******************************************************************/
    public function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__constructBase();
                break;
            case 8:
                self::__constructFull( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7]);
        }
    }


    public function __constructBase() {
        $this->filesUploaded = 0;
        $this->songsUploaded = 0;
        $this->songComments = 0;
        $this->tasksCreated = 0;
        $this->tasksClosed = 0;
        $this->blogsCreated = 0;
        $this->blogComments = 0;
        $this->blogLikes = 0;
    }

    public function __constructFull($files,$songsUploaded,$songComments,$tasksCreated,$tasksClosed,$blogsCreated,$blogComments,$blogLikes) {
      $this->filesUploaded = $files;
      $this->songsUploaded = $songsUploaded;
      $this->songComments = $songComments;
      $this->tasksCreated = $tasksCreated;
      $this->tasksClosed = $tasksClosed;
      $this->blogsCreated = $blogsCreated;
      $this->blogComments = $blogComments;
      $this->blogLikes = $blogLikes;
    }


    /******************************************************************/
    // Accessors / Mutators
    /******************************************************************/

    public function getFilesUploaded(){
        return $this->filesUploaded;
    }
    public function setFilesUploaded($value){
        $this->filesUploaded = $value;
    }
    public function getSongsUploaded(){
        return $this->songsUploaded;
    }
    public function setSongsUploaded($value){
        $this->songsUploaded = $value;
    }
    public function getSongComments(){
        return $this->songComments;
    }
    public function setSongComments($value){
        $this->songComments = $value;
    }
    public function getTasksCreated(){
        return $this->tasksCreated;
    }
    public function setTasksCreated($value){
        $this->tasksCreated = $value;
    }
    public function getTasksClosed(){
        return $this->tasksClosed;
    }
    public function setTasksClosed($value){
        $this->tasksClosed = $value;
    }
    public function getBlogsCreated(){
        return $this->blogsCreated;
    }
    public function setBlogsCreated($value){
        $this->blogsCreated = $value;
    }
    public function getBlogComments(){
        return $this->blogComments;
    }
    public function setBlogComments($value){
        $this->blogComments = $value;
    }
    public function getBlogLikes(){
        return $this->blogLikes;
    }
    public function setBlogLikes($value){
        $this->blogLikes = $value;
    }

    // Return sum of all stats
    public function getTotalStatPoints(){
      $uploadScalar=5;
      $commentScalar=2;
      $taskCreateScalar=3;
      $taskCloseScalar=10;
      $blogCreatedScalar=5;
      $blogCommentScalar=2;
      $blogLikeScalar=2;
      $total=0;
      $total+=$this->getFilesUploaded()*$uploadScalar;
      $total+=$this->getSongsUploaded()*$uploadScalar;
      $total+=$this->getSongComments()*$commentScalar;
      $total+=$this->getTasksCreated()*$taskCreateScalar;
      $total+=$this->getTasksClosed()*$taskCloseScalar;
      $total+=$this->getBlogsCreated()*$blogCreatedScalar;
      $total+=$this->getBlogComments()*$blogCommentScalar;
      $total+=$this->getBlogLikes()*$blogLikeScalar;
      return $total;
    }

    public function loadUserStats($userId) {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_UserStats_LoadUserStats(?)');
    		$stmt->bind_param('i', $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        while ($row = $result->fetch_assoc()) {
         $this->setFilesUploaded($row['FilesUploaded']);
         $this->setSongsUploaded($row['SongsUploaded']);
         $this->setSongComments($row['SongComments']);
         $this->setTasksCreated($row['TasksCreated']);
         $this->setTasksClosed($row['TasksClosed']);
         $this->setBlogsCreated($row['BlogsCreated']);
         $this->setBlogComments($row['BlogComments']);
         $this->setBlogLikes($row['BlogLikes']);
       }
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

    /*
    public static function loadAllUserStats() {
        include(self::getDbSettings());
        $conn = new mysqli($servername, $username, $password, $dbname);
        $stmt = $conn->prepare('CALL usp_UserStats_LoadAll()');
        $stmt->execute();

        $result = $stmt->get_result();
        if (!$result) die($conn->error);
        if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						return new UserStatsViewModel($row['FilesUploaded'],$row['SongsUploaded'],$row['SongComments'],$row['TasksCreated'],$row['TasksClosed']);
        }
        else {
            return new UserStatsViewModel();
        }
    }
    */

}
