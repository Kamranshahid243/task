<?php

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


function getAdminID(){
	return 'ADM-'. strtoupper( Str::random( 8 ) );
} 

function getCustomerID(){
	return 'ADM-'. strtoupper( Str::random( 8 ) );
}
function getServiceID(){
	return 'SER-'.time();
}

function getTaskID(){
	return 'TSK-'.time();
}

function getCurrentTimestamp(){
	return date("Y-m-d H:i:s");
}

// handles image upload
function handleFileUpload( $file, $dir){
    $path = $file->store( $dir, 'public' );

    return [
        'path' => 'public/'.$path, 
        'url' => 'storage/'.$path,
    ];
}

// handles image upload
function handleImageUpload( $file, $dir, $width=null, $height=null){
    $path = $file->store( $dir, 'public' );
	//dd( file_exists(public_path( 'storage/'.$path )) );
    if( $width AND $height ){
        
        //$image = Image::make( public_path( 'storage/'.$path )  )->fit( $width, $height );
        $image = Image::make( 'storage/'.$path   )->fit( $width, $height );
        $image->save();
    }
    return [
        'path' => 'public/'.$path, 
        'url' => 'storage/'.$path,
    ];
}

function slug($text) { 
    $text = strtolower(htmlentities($text)); 
    $text = str_replace(get_html_translation_table(), "-", $text);
    $text = str_replace(" ", "-", $text);
    $text = preg_replace("/[-]+/i", "-", $text);
    return $text;
}

function fileFileIcon($filename){

	// <i class="fa fa-file-text"></i> Project-document.docx</a>
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
	if( $ext == 'docx' OR $ext == 'docm' OR $ext == 'dotx' OR  $ext == 'docb' OR  $ext == 'doc' OR  $ext == 'dot' ){
		//ms word fa-file-word-o
		return '<i class="fa fa-file-word-o"></i> '.$filename;
	}
	else if($ext == 'xls' OR $ext == 'xlt' OR $ext == 'xlm' OR  $ext == 'xlsx' OR  $ext == 'xlsm' OR  $ext == 'xltx' OR $ext == 'xltm' OR  $ext == 'xlsb'){
		//ms excel
		return '<i class="fa fa-file-excel-o"></i> '.$filename;
	}
	else if($ext == 'ppt' OR $ext == 'pot' OR $ext == 'pps' OR  $ext == 'pptx' OR  $ext == 'pptm' OR  $ext == 'potx' OR $ext == 'potm' OR $ext == 'ppam' OR $ext == 'ppsx' OR $ext == 'ppsm'){
		//ms power point
		return '<i class="fa fa-file-powerpoint-o"></i> '.$filename;
	}
	else if($ext == 'jpeg' OR $ext == 'jpg' OR $ext == 'bmp' OR  $ext == 'png' OR  $ext == 'webp' OR  $ext == 'svg' OR $ext == 'gif' OR $ext == 'psd' OR $ext == 'psb' OR $ext == 'tiff'){
		//image
		return '<i class="fa  fa-file-picture-o"></i> '.$filename;
	}
	else if($ext == 'zip' OR $ext == 'rar' OR $ext == '7z' OR $ext ==  'xz' OR $ext ==  'tar' OR $ext ==  'iso' OR $ext == 'gzip' OR $ext == 'rpm' OR $ext == 'wim' OR $ext == 'xar'){
		//zip
		return '<i class="fa fa-file-zip-o"></i> '.$filename;
	}
	else if($ext == 'mp3' OR $ext == 'aac' OR $ext == 'ogg' OR $ext ==  'wma' OR $ext ==  'tar' OR $ext ==  'wav' OR $ext == 'webm' OR $ext == 'opus' OR $ext == 'flac' OR $ext == 'awb'){
		//audio
		return '<i class="fa fa-file-audio-o"></i> '.$filename;
	}
	else if($ext == 'webm' OR $ext == 'mkv' OR $ext == 'flv' OR $ext ==  'vob' OR $ext ==  'ogg' OR $ext ==  'wmv' OR $ext == 'mp4' OR $ext == '3gp' OR $ext == 'mov' OR $ext == 'asf'){
		//video
		return '<i class="fa fa-file-video-o"></i> '.$filename;
	}
	else if($ext == 'html'){
		//html
		return '<i class="fa fa-html5"></i> '.$filename;
	}
	else if($ext == 'css'){
		//css
		return '<i class="fa fa-css3"></i> '.$filename;
	}
	else if($ext == 'js'){
		//js
		return '<i class="fa fa-file"></i> '.$filename;
	}
	else if($ext == 'php'){
		//php
		return '<i class="fa fa-file"></i> '.$filename;
	}
	else if($ext == 'java'){
		//java
		return '<i class="fa fa-file"></i> '.$filename;
	}
	else if($ext == 'cpp' OR $ext == 'h'){
		//css
		return '<i class="fa fa-file"></i> '.$filename;
	}
	else if($ext == 'xml' OR $ext == 'exd' OR $ext == 'dtd' ){
		//xml
		return '<i class="fa fa-code"></i> '.$filename;
	}
	else if($ext == 'pdf' ){
		//xml
		return '<i class="fa fa-file-pdf-o"></i> '.$filename;
	}
	else{
		return '<i class="fa fa-file-pdf-o"></i> '.$filename;
	}
}

function getDirectory( $userId, $dirName ){
	
	$publicPath = str_replace('\\','/',public_path());
	$dir        = $userId.'/'.$dirName; 
	$path       = $publicPath.'/'.$dir;

	if(!is_dir($path)){
		mkdir($path, 0777, true);
	}

	return $path;
}

function getFormattedTime( $date ){
	


	$datetime1 = new DateTime( $date );
	$datetime2 = new DateTime( getCurrentTimestamp() );
	$interval = $datetime1->diff($datetime2);

	$string = $interval->format('%Y-%m-%d %H:%i:%s');
	
	$tmp  = explode(' ', $string);
	$date = explode('-', $tmp[0]);
	$time = explode(':', $tmp[1]);

	$year  = (double)$date[0];
	$month = (double)$date[1];
	$day   = (double)$date[2];
	
	$hours   = (double)$time[0];
	$minutes = (double)$time[1];
	$seconds = (double)$time[2];



	if($year == 0 AND $month == 0 And $day == 0 AND $hours == 0 AND $minutes == 0 AND $seconds >= 0){
		return $seconds.' seconds ago';
	}
	else if($year == 0 AND $month == 0 And $day == 0 AND $hours == 0 AND $minutes >= 0 AND $seconds > 0){
		return $minutes.' minutes ago';
	}
	else if($year == 0 AND $month == 0 And $day == 0 AND $hours >= 0 AND $minutes > 0 AND $seconds > 0){
		return $hours.' hours ago';
	}
	else if($year == 0 AND $month == 0 And $day >= 0 AND $hours > 0 AND $minutes > 0 AND $seconds > 0){
		return $day.' days ago';
	}
	else if($year == 0 AND $month >= 0 And $day > 0 AND $hours > 0 AND $minutes > 0 AND $seconds > 0){
		return $month.' months  ago';
	}
	else if($year >= 0 AND $month > 0 And $day > 0 AND $hours > 0 AND $minutes > 0 AND $seconds > 0){
		return $year.' years ago';
	}

	//echo $interval->format('%Y-%m-%d %H:%i:%s');
}

function isValid( $key, $value ){

	switch( $key ){

        case 'first_name': 			return validate( 'alphabets_with_spaces', 'First Name', $value );
        case 'last_name': 			return validate( 'alphabets_with_spaces', 'Last Name', $value );
		case 'gender': 			    return validate( 'alphabets_only', 'Gender', $value );
		case 'email': 			    return validate( 'email', 'Email', $value );
		case 'password': 			return validate( 'password', 'Password', $value );
		case 'phone': 			    return validate( 'phone', 'Phone', $value );
		case 'role_id': 			return validate( 'numeric', 'Role', $value );	
		case 'designation_id': 		return validate( 'numeric', 'Designation', $value );
		case 'department_id': 		return validate( 'alphanumeric_without_spaces', 'Department', $value );
		case 'epf_no': 				return validate( 'numeric', 'EPF Number', $value );
		case 'salary': 				return validate( 'numeric_comma', 'Basic Salary', $value );
		case 'shift_id': 			return validate( 'alphanumeric_without_spaces', 'Work Shift', $value );
		case 'office_location': 	return validate( 'alphanumeric_space_slashe_hyphen_comma', 'Office Location', $value );	
		case 'joining_date': 	    return validate( 'numeric_hyphens', 'Joining Date', $value );	
	}

}

function validate( $type, $attribute, $value ){

	if( !strlen($value) ){
		return [ 'status' => 'error', 'message' => missing( $attribute )];
	}
	else{
		

		if( $type == 'passoword' ){
			if( strlen( $value ) < 6){
				return [ 'status' => 'error', 'message' => 'Password length should be at least 6 characters!' ];
			}
		}
		else if( $type == 'phone' ){
			if( !preg_match('/^\(\d{3}\)\s\d{3}\-\d{4}$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
		}
		else if( $type == 'email'){

			$pattern = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/';

			if( !preg_match( $pattern , $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}

		}
        else if( $type === 'alphabets_only' ){
			
			if( !preg_match('/^(Male|Female)+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
			
		}  
        else if( $type === 'alphabets_with_spaces' ){
			
			if( !preg_match('/^[A-Za-z ]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
			
		}    
		else if( $type === 'alphanumeric_without_spaces' ){
			
			if( !preg_match('/^[A-Z]+[0-9]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
			
		}
		else if( $type === 'numeric' ){
			
			if( !preg_match('/^[0-9]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
		
		}
		else if( $type === 'numeric_comma' ){

			$value = str_replace( ',', '', $value );	
			
			if( !preg_match('/^[0-9]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
		
		}
		else if( $type === 'alphanumeric_space_slashe_hyphen_comma' ){	
			
			if( !preg_match('/^[a-zA-Z0-9,.!?\-? ]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
		
		}	
		else if( $type === 'alphanumeric_space_slashe_hyphen_comma' ){	
			
			if( !preg_match('/^[0-9\-]+$/', $value) ){
				return [ 'status' => 'error', 'message' => error( $attribute )];
			}
		
		}		

	}

	return true;
}

function missing( $attribute ){ return $attribute.' is missing'; }
function error( $attribute ){ return 'The ' .$attribute.' field contains invalid character(s)'; }
	

