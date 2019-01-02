<?php
namespace app\services;

use app\services\storage\StorageInterface;
use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

/**
 * FileStorageService 
 * 
 * The service responsible for storing a file locally.
 */
class FileStorageService implements StorageInterface {
	
	
	public function __construct() {
		
	}
	
	/**
	 * Sends a file to the cdn for storage.
	 * 
	 * @param string $bucket The bucket to save it on in AWS
	 * @param string $object The key to reference the image
	 * @param string $body The content to be uploaded
	 * @param string $acl Access priviliges on AWS
	 * @param string $contenty_type Assign a content type
	 * 
	 * @return string Returns a url where the object was saved
	 */
	public function upload($name_location, $content) {
		
		if(file_put_contents($name_location , $content)){
			return $name_location;
		}
		
		return false;
	
	}
	
}
