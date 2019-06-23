<?php
require_once("internal/vendor/autoload.php");
require_once("internal/lib/__init__.php");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$AppVersion = new \PHLAK\SemVer\Version("<%PKG.VERSION%>");
$app = new \Slim\App(array("debug" => false));
$tv = new \VRPilot\App();

$container = $app->getContainer();

$container["view"] = function ($container) {
    return new \Slim\Views\PhpRenderer("internal/templates/");
};

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

$container["notFoundHandler"] = function ($container) use ($app, $AppVersion, $tv) {
    return function (Request $request, Response $response) use ($container, $AppVersion, $tv) {
        $response = $response->withStatus(404)
            ->withHeader("Content-Type", "text/html");

        $container->get("view")->setLayout("layout.nosession.phtml");
        return $container->get("view")->render($response, "errordocs/404.phtml", [
            "AppVersion" => $AppVersion,
            "title" => "Dashboard",
            "page" => "dashboard",
            "tv" => $tv
        ]);
    };
};

$app->get("/admin", function (Request $request, Response $response, array $args) use ($app, $tv, $AppVersion) {
    return $response->withRedirect("/admin/dashboard");
});

$app->get("/admin/dashboard", function (Request $request, Response $response, array $args) use ($app, $tv, $AppVersion) {
    $this->view->setLayout("layout.phtml");

    return $this->view->render($response, "admin/dashboard.phtml", [
        "AppVersion" => $AppVersion,
        "title" => "Dashboard",
        "page" => "dashboard",
        "tv" => $tv
    ]);
});

$app->get("/admin/shows", function (Request $request, Response $response, array $args) use ($app, $tv, $AppVersion) {
    $this->view->setLayout("layout.phtml");

    return $this->view->render($response, "admin/shows.phtml", [
        "AppVersion" => $AppVersion,
        "title" => "Shows",
        "page" => "shows",
        "tv" => $tv
    ]);
});

$app->get("/admin/config", function (Request $request, Response $response, array $args) use ($app, $tv, $AppVersion) {
    $this->view->setLayout("layout.phtml");

    return $this->view->render($response, "admin/config.phtml", [
        "AppVersion" => $AppVersion,
        "title" => "Configuration",
        "page" => "config",
        "tv" => $tv
    ]);
});

$app->get("/watch", function (Request $request, Response $response, array $args) use ($app, $tv) {
    $refresh = $tv->getSecondsPerFrame() / 2;
    $response = $response->withHeader("Content-Type", "image/jpeg");
    $response = $response->withHeader("Cache-Control", "no-cache, max-age=0, must-revalidate");
    $response = $response->withHeader("Refresh", $refresh . "; url=/watch");

    return $this->view->render($response, "../tv.php", [
        "tv" => $tv
    ]);
});

$app->run();
?>