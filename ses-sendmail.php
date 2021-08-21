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

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender_email = <EMAIL_SNEDER_ADDRESS>;

// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
$recipient_emails = [<EMAIL_RECIPIENT_ADDRESS_1>, <EMAIL_RECIPIENT_ADDRESS_2>];

try {
    $result = $client->sendEmail(
        [
            'Content' => [ // REQUIRED
                'Simple' => [
                    'Body' => [ // REQUIRED
                        'Html' => [
                            'Charset' => 'utf-8',
                            'Data' => '<h1>Email Test</h1>
    <p>This email was sent through the
     class.</p>', // REQUIRED
                        ],
                        'Text' => [
                            'Charset' => 'utf-8',
                            'Data' => '111111', // REQUIRED
                        ],
                    ],
                    'Subject' => [ // REQUIRED
                        'Charset' => 'utf-8',
                        'Data' => 'ads two', // REQUIRED
                    ],
                ],
            ],
            'Destination' => [
                'ToAddresses' => $recipient_emails,
            ],
            'EmailTags' => [
                [
                    'Name' => 'ses', // REQUIRED
                    'Value' => 'man', // REQUIRED
                ],
            ],
            'FromEmailAddress' => $sender_email
        ]
    );
    
    $messageId = $result['MessageId'];
    echo("Email sent! Message ID: $messageId"."\n");
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}
