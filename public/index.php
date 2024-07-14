<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Adapters\Handler\HttpErrorHandler;
use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$callableResolver = $app->getCallableResolver();
$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/../app/Main/Routes/api.php';
$routes($app);


$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$errorMiddleware = $app->addErrorMiddleware(false, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$app->run();
