<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/info', function () {
        phpinfo();
        exit;
    });
    $app->group('/api/v1', function (Group $group) {
        $group->post('/email-confirm', \App\Register\Actions\ConfirmationEmailAction::class);
    });
};
