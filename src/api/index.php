<?php
require_once("../internal/vendor/autoload.php");
require_once("../internal/lib/__init__.php");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$AppVersion = new \PHLAK\SemVer\Version("<%PKG.VERSION%>");
$app = new \Slim\App(array("debug" => false));
$tv = new \VRPilot\App(1);

$container = $app->getContainer();

$container["errorHandler"] = function ($container) use ($app, $tv) {
    return function (Request $request, Response $response, Exception $ex) use ($container, $app, $tv) {
        return $response->write(var_export($ex));
    };
};

$container["phpErrorHandler"] = function ($container) use ($app, $tv) {
    return function (Request $request, Response $response, $ex) use ($container, $app, $tv) {
        return $response->write(var_export($ex));
    };
};

$container["notFoundHandler"] = function ($container) {
    return function (Request $request, Response $response) {
        return $response->withStatus(404)
            ->withHeader("Content-Type", "application/json")
            ->withJson(array("status" => 404, "message" => "Not Found"));
    };
};

$app->get("/spf", function (Request $request, Response $response, array $args) use ($tv) {
    $data = array(
        "status" => 200,
        "message" => "OK",
        "response" => array(
            "spf" => $tv->getSecondsPerFrame()
        ),
    );

    $response = $response->withHeader("Content-Type", "application/json");
    $response = $response->withJson($data);
    return $response;
});

$app->get("/mode", function (Request $request, Response $response, array $args) use ($tv) {
    $data = array(
        "status" => 200,
        "message" => "OK",
        "response" => array(
            "mode" => $tv->getBroadcastMode()
        ),
    );

    $response = $response->withHeader("Content-Type", "application/json");
    $response = $response->withJson($data);
    return $response;
});

$app->get("/version", function (Request $request, Response $response, array $args) use ($AppVersion) {
    $data = array(
        "status" => 200,
        "message" => "OK",
        "response" => array(
            "version" => $AppVersion->__toString()
        ),
    );

    $response = $response->withHeader("Content-Type", "application/json");
    $response = $response->withJson($data);
    return $response;
});

$app->run();
?>