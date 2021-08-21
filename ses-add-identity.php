<?php

// If necessary, modify the path in the require statement below to refer to the 
// location of your Composer autoload.php file.
require 'vendor/autoload.php';

use Aws\SesV2\SesV2Client;
use Aws\Exception\AwsException;

// Create an SesClient. Change the value of the region parameter if you're 
// using an AWS Region other than US West (Oregon). Change the value of the
// profile parameter if you want to use a profile in your credentials file
// other than the default.
$client = new SesV2Client([
    'profile' => 'default',
    'version' => '2019-09-27',
    'region'  => 'us-east-1'
]);

// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
$emails = '<EMAIL_ADDRESS>';

try {
    $result = $client->createEmailIdentity(
        [
            'EmailIdentity' => $emails, // REQUIRED
            'Tags' => [
                [
                    'Key' => 'ads', // REQUIRED
                    'Value' => 'one', // REQUIRED
                ],
                // ...
            ],
        ]
    );
    
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}
