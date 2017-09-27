<?php

require_once('bootstrap.php');

use RingCentral\SDK\SDK;

try {

$rcsdk = new SDK("", "" , "https://platform.ringcentral.com", 'Demo', '1.0.0');

$platform = $rcsdk->platform();

$auth = $platform->login("", "", "");

print 'Authorized' . PHP_EOL . print_r($auth);

$token = $platform->auth()->data()['access_token'];

$apiResponse = $platform->get('/glip/groups');

print 'The GLIP Groups are  ' . print_r($apiResponse->json()) . PHP_EOL;


} catch (\RingCentral\SDK\Http\ApiException $e) {

    // In order to get Request and Response used to perform transaction:
    $apiResponse = $e->apiResponse();
    print "The final api response is : " . PHP_EOL . print_r(($apiResponse)) . PHP_EOL;
    print "The request is" . print_r($apiResponse->request());
    print "The resposne is" . print_r($apiResponse->response());

}
