<?php
/**
 * User: h0r53
 * Date: 3/7/18
 * Time: 5:43 PM
 */

session_start();

include_once("Utilities/Authentication.php");
include_once("DAL/File.php");

Authentication::checkFilePermissions();

if (array_key_exists("fid",$_GET))
{
    $fid = $_GET['fid'];
    $file = new File($fid);
    if ($file->getId() != 0)
    {
        $filename = "../privateFiles/" . $file->getFileName();
        if (file_exists($filename))
        {
            if(false !== ($handler = fopen($filename, 'r')))
            {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($filename));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename)); //Remove

                //Send the content in chunks
                while(false !== ($chunk = fread($handler,4096)))
                {
                    echo $chunk;
                }
            }
            exit;
        }
    }
}