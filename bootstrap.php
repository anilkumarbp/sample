c<?php

// Include the composer autoloader
if(!file_exists('vendor/autoload.php')) {
    echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
    exit(1);
}

// require_once(__DIR__ . '/../lib/autoload.php');
require_once('vendor/autoload.php');

use RingCentral\http\HttpException;

date_default_timezone_set('UTC');

// Make all PHP errors to be thrown as Exceptions

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// Set up global exception handler (this includes Guzzle HTTP Exceptions)

set_exception_handler(function (Exception $e) {

    print 'Exception: ' . $e->getMessage() . PHP_EOL;

    if ($e instanceof HttpException && $response = $e->getResponse()) {

        print 'SDK HTTP Error: ' . $response->getError() . ' at ' . $e->getRequest()->getUrl() . PHP_EOL;

        print print_r($response->getJson(), true) . PHP_EOL;

        if ($e->getPrevious()) {
            print 'Previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
        }

    }

    print $e->getTraceAsString() . PHP_EOL;

});
