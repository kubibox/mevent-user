<?php

declare(strict_types=1);

use App\Auth\Actions\AuthAction;
use App\Auth\Actions\LogoutAction;
use App\Register\Actions\ConfirmationEmailAction;
use App\Register\Actions\RegisterAction;
use App\Token\Actions\AuthTokenGenerateAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->group('/api/v1', function (Group $group) {
        $group->post('/email-confirm', ConfirmationEmailAction::class);
        $group->post('/token/generate', AuthTokenGenerateAction::class);

        /**  */
        $group->post('/register', RegisterAction::class);

        $group->post('/login', AuthAction::class);

        $group->post('/logout', LogoutAction::class);
    //    $group->post('/forgot-password'); todo
    //    $group->post('/reset-password'); todo
    });
};
