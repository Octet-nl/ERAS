<?php
/* NicEdit - Micro Inline WYSIWYG
 * Copyright 2007-2009 Brian Kirchoff
 *
 * NicEdit is distributed under the terms of the MIT license
 * For more information visit http://nicedit.com/
 * Do not remove this copyright message
 *
 * nicUpload Reciever Script PHP Edition
 * @description: Save images uploaded for a users computer to a directory, and
 * return the URL of the image to the client for use in nicEdit
 * @author: Brian Kirchoff <briankircho@gmail.com>
 * @sponsored by: DotConcepts (http://www.dotconcepts.net)
 * @version: 0.9.0
 * 15-08-2020 Hans de Rijck. Flink aangepast voor lokale opslag.
 */
require_once 'utilities.php';

// Set the path (relative or absolute) to the directory to save image files
$ini = parse_ini_file( CONFIG_FILENAME, true );
$nicUploadPath = $ini['settings']['image_directory'];

$nicupload_allowed_extensions = array('jpg','jpeg','png','gif','bmp');

$logger = new Logger();
$logger->level( LOGLEVEL_DUMP );
$logger->error( 'nicUpload started' );

// You should not need to modify below this line

if(!function_exists('json_encode')) {
    GLOBAL $logger;
    $logger->error( '{"error" : "Image upload host does not have the required dependencies (json_encode/decode)"}' );

    die('{"error" : "Image upload host does not have the required dependencies (json_encode/decode)"}');
}

$logger->dump( $_GET );

if($_SERVER['REQUEST_METHOD']=='POST') { // Upload is complete

    $logger->dump( $_POST );
    $logger->dump( $_FILES );
        
    if(!is_dir($nicUploadPath) || !is_writable($nicUploadPath)) {
        nicupload_error('Upload directory '.$nicUploadPath.' must exist and have write permissions on the server');
    }
    
    $file = $_FILES['nicImage'];
    $image = $file['tmp_name'];
    
    $max_upload_size = ini_max_upload_size();
    if(!$file) {
        nicupload_error('Must be less than '.bytes_to_readable($max_upload_size));
    }
    
    $ext = strtolower(substr(strrchr($file['name'], '.'), 1));
    @$size = getimagesize($image);
    if(!$size || !in_array($ext, $nicupload_allowed_extensions)) {
        nicupload_error('Invalid image file, must be a valid image less than '.bytes_to_readable($max_upload_size));
    }
    
    $filename = $file['name'];
    $path = $nicUploadPath.'/'.$filename;
    
    if(!move_uploaded_file($image, $path)) {
        nicupload_error('Server error, failed to move file');
    }
    
    $status = array();

    $status['done'] = 1;
    $status['width'] = $size[0];
    $status['link'] = $path;
    
    echo json_encode($status);

    exit;
} 
else if(isset($_GET['check'])) 
{ // Upload progress check
    $check = $_GET['check'];
    if(!is_numeric($check)) {
        nicupload_error('Invalid upload progress id');
    }
    
    if($status['total'] > 500000 && $status['current']/$status['total'] < 0.9 ) 
    { // Large file and we are < 90% complete
		$status['interval'] = 3000;
    }
    else if($status['total'] > 200000 && $status['current']/$status['total'] < 0.8 ) 
    { // Is this a largeish file and we are < 80% complete
		$status['interval'] = 2000;
    }
    else 
    {
		$status['interval'] = 1000;
	}
        
    nicupload_output($status);

    $status = array();
    $status['noprogress'] = true;

    nicupload_output($status);
    $logger->debug( $status );
}


// UTILITY FUNCTIONS

function nicupload_error($msg) {
    GLOBAL $logger;

    echo nicupload_output(array('error' => $msg)); 
    $logger->errordump( nicupload_output(array('error' => $msg)) );
}

function nicupload_output($status, $showLoadingMsg = false) {
    GLOBAL $logger;

    $script = '
        try {
            '.(($_SERVER['REQUEST_METHOD']=='POST') ? 'top.' : '').'nicUploadButton.statusCb('.json_encode($status).');
        } catch(e) { alert(e.message); }
    ';
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        echo '<script>'.$script.'</script>';
    } else {
        echo $script;
    }

    $logger->debug( $script );

    if($_SERVER['REQUEST_METHOD']=='POST' && $showLoadingMsg) {      

echo <<<END
    <html><body>
        <div id="uploadingMessage" style="text-align: center; font-size: 14px;">
            <img src="res/icons/ajax-loader.gif" style="float: right; margin-right: 40px;" />
            <strong>Uploading...</strong><br />
            Please wait
        </div>
    </body></html>
END;

    }
    
    exit;
}

function ini_max_upload_size() {
    $post_size = ini_get('post_max_size');
    $upload_size = ini_get('upload_max_filesize');
    if(!$post_size) $post_size = '8M';
    if(!$upload_size) $upload_size = '2M';
    
    return min( ini_bytes_from_string($post_size), ini_bytes_from_string($upload_size) );
}

function ini_bytes_from_string($val) 
{
    GLOBAL $logger;
   
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = substr( $val, 0, strlen($val) - 1 );
    $logger->debug( 'Vals: ' . $val . ', Last: ' .$last );

    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function bytes_to_readable( $bytes ) {
    if ($bytes<=0)
        return '0 Byte';
   
    $convention=1000; //[1000->10^x|1024->2^x]
    $s=array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
    $e=floor(log($bytes,$convention));
    return round($bytes/pow($convention,$e),2).' '.$s[$e];
}

?>
