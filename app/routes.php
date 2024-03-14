<?php

declare(strict_types=1);

use App\Auth\Actions\AuthAction;
use App\Auth\Actions\RegisterAction;
use App\Banks\Mono\Actions\LoadClientAction as MonoBankClientLoad;
use App\Banks\Mono\Actions\LoadStatementsActions as MonoBankStatementLoad;
use App\Categories\Actions\CreateCategoryAction;
use App\Categories\Actions\ListCategoryAction;
use App\Categories\Actions\ViewCategoryAction;
use App\Tokens\Actions\SaveTokenAction;
use App\Tokens\Actions\TokenListAction;
use App\Transactions\Actions\CreateTransactionAction;
use App\Transactions\Actions\ListTransactionAction;
use App\Transactions\Actions\ViewTransactionAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/transactions', function (Group $group) {
        $group->get('', ListTransactionAction::class);
        $group->get('/{id}', ViewTransactionAction::class);

        $group->post('', CreateTransactionAction::class);
    });

    $app->group('/categories', function (Group $group) {
        $group->get('', ListCategoryAction::class);
        $group->get('/{id}', ViewCategoryAction::class);

        $group->post('', CreateCategoryAction::class);
//        $group->post('', )
    });

    $app->group('/auth', function (Group $group) {
        $group->post('/login', AuthAction::class); //todo patch method
        $group->post('/register', RegisterAction::class);
    });

    $app->group('/bank', function (Group $group) {
        $group->get('/mono', MonoBankClientLoad::class);
        $group->get('/mono/statements', MonoBankStatementLoad::class);
    });

    $app->group('/token', function (Group $group) {
        $group->post('', SaveTokenAction::class);
        $group->get('', TokenListAction::class);
    });
};
