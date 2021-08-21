<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;  
use Aws\Exception\AwsException;

$s3Client = new Aws\S3\S3Client([
    'profile' => 'default',
    'region' => 'ap-northeast-1',
    'version' => '2006-03-01',
    'use_accelerate_endpoint' => true
]);

$cmd = $s3Client->getCommand('PutObject', [
    'Bucket' => <BUCKET_NAME>,
    'Key' => 'index.html'
]);

$request = $s3Client->createPresignedRequest($cmd, '+240 minutes');

// Get the actual presigned-url
$presignedUrl = (string)$request->getUri();
// var_dump($presignedUrl);
echo $presignedUrl;
echo "\n";

?>
