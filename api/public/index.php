<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);

    Debug::enable();
}

// reverse proxy for sapper app
$uriPrefix = substr(strtolower($_SERVER['REQUEST_URI']), 0, 3);
if (in_array($uriPrefix, ['/en', '/fr'])) {
    $path = substr($_SERVER['REQUEST_URI'], 3);

    $client = HttpClient::create();
    $response = $client->request($_SERVER['REQUEST_METHOD'], 'http://localhost:3000'.$path, [
        'headers' => ['Accept-Language' => substr($uriPrefix, 1, 2)],
    ]);

    print($response->getContent(false));

} else {
    // regular symfony (api app)
    $kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
    $request = Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
}
