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
$sender_email = <SENDER_EMAIL>;

// Replace these sample addresses with the addresses of your recipients. If
// your account is still in the sandbox, these addresses must be verified.
$recipient_emails = [<RECIPIENT_EMAIL_1>, <RECIPIENT_EMAIL_2];

// Specify a configuration set. If you do not want to use a configuration
// set, comment the following variable, and the
// 'ConfigurationSetName' => $configuration_set argument below.
// $configuration_set = 'ConfigSet';

$subject = 'Amazon SES test (AWS SDK for PHP)';
$plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
$html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
              '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
              'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
              'AWS SDK for PHP</a>.</p>';
$char_set = 'UTF-8';

try {
    $result = $client->sendEmail([
        'Content' => [ // REQUIRED
            'Simple' => [
                'Body' => [ // REQUIRED
                    'Html' => [
                        'Charset' => $char_set,
                        'Data' => $html_body, // REQUIRED
                    ],
                    'Text' => [
                        'Charset' => $char_set,
                        'Data' => $html_body, // REQUIRED
                    ],
                ],
                'Subject' => [ // REQUIRED
                    'Charset' => $char_set,
                    'Data' => $subject, // REQUIRED
                ],
            ]
        ],
        'Destination' => [
            'ToAddresses' => $recipient_emails,
        ],
        'FromEmailAddress' => $sender_email
    ]);
    $messageId = $result['MessageId'];
    echo("Email sent! Message ID: $messageId"."\n");
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
    echo "\n";
}
