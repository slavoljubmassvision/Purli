<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Fetching HTML page using GET request
try {
    $purli = (new \Purli\Purli())
        ->get('http://localhost/Purli/Tests/testresponse.php')
        ->close();

    $response = $purli->response();

    echo $response->asText();
} catch(\Exception $e) {
    echo $e->getMessage();
}

// Fetching HTML page using POST request
try {
    $purli = (new \Purli\Purli())
        ->setParams(['foo' => 'bar'])
        ->post('http://localhost/Purli/Tests/testresponsepost.php')
        ->close();

    $response = $purli->response();

    echo $response->asText();
} catch(\Exception $e) {
    echo $e->getMessage();
}

// Sending and receiving JSON data using PUT
try {
    $data = array('foo' => 'bar');
    $json = json_encode($data);

    $purli = (new \Purli\Purli())
        ->setConnectionTimeout(3)
        ->setHeader('Content-Type', 'application/json')
        ->setHeader('Connection', 'Close')
        ->setHeader('Content-Length', strlen($json))
        ->setBody($json)
        ->post('http://localhost/Purli/Tests/testresponsejson.php')
        ->close();

    $response = $purli->response();

    print_r($response->asObject());
} catch(\Exception $e) {
    echo $e->getMessage();
}

// Sending and receiving XML data using POST
try {
    $data = '<root><foo>bar</foo></root>';

    $purli = (new \Purli\Purli())
        ->setUserAgent('curl 7.16.1 (i386-portbld-freebsd6.2) libcurl/7.16.1 OpenSSL/0.9.7m zlib/1.2.3')
        ->setHeader('Content-Type', 'text/xml')
        ->setHeader('Content-Length', strlen($data))
        ->setBody($data)
        ->post('http://localhost/Purli/Tests/testresponsexml.php')
        ->close();

    $response = $purli->response();

    print_r($response->asArray());
} catch(\Exception $e) {
    echo $e->getMessage();
}

// Setting custom CURL option
try {
    $purli = (new \Purli\Purli());

    if ($purli->getHandlerType() === \Purli\Purli::CURL) {
        curl_setopt($purli->getHandler(), CURLOPT_TIMEOUT, 10);
    }

    $purli
        ->get('http://localhost/Purli/Tests/testresponse.php')
        ->close();

    $response = $purli->response();

    echo $response->asText();
} catch(\Exception $e) {
    echo $e->getMessage();
}