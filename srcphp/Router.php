<?php

namespace proyecto;

use DateTimeImmutable;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\key;
use proyecto\Response\Failure;

class Router
{
    public static function get($route, $path_to_include)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Router::route($route, $path_to_include);
        }
    }

    public static function post($route, $path_to_include, $valid_token = false)
    {
        if ($valid_token) {
            self::is_token_valid();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Router::route($route, $path_to_include);
        }
    }

    public static function route($route, $path_to_include)
    {
        Router::headers();
        self::autoload_classes();
        $callback = $path_to_include;
        if (!is_callable($callback) && !is_array($callback)) {
            if (!strpos($path_to_include, '.php')) {
                $path_to_include .= '.php';
            }
        }
        if ($route == "/404") {
            include_once __DIR__ . "/$path_to_include";
            exit();
        }
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);
        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            // Callback function
            if (is_callable($callback)) {
                call_user_func_array($callback, []);
                exit();
            }
            include_once __DIR__ . "/$path_to_include";
            exit();
        }
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }
        $parameters = [];
        for ($__i__ = 0; $__i__ < count($route_parts); $__i__++) {
            $route_part = $route_parts[$__i__];
            if (preg_match("/^[$]/", $route_part)) {
                $route_part = ltrim($route_part, '$');
                array_push($parameters, $request_url_parts[$__i__]);
                $$route_part = $request_url_parts[$__i__];
            } else if ($route_parts[$__i__] != $request_url_parts[$__i__]) {
                return;
            }
        }
        if (is_array($callback)) {
            try {
                $i = new $callback[0]();
                call_user_func_array([$i, $callback[1]], $parameters);
                exit();
            } catch (\Exception $e) {
                echo json_encode([
                    "error" => $e->getMessage()
                ]);
                exit();
            }
        }

        // Callback function
        if (is_callable($callback)) {
            call_user_func_array($callback, $parameters);
            exit();
        }
        include_once __DIR__ . "/$path_to_include";
        exit();
    }

    public static function autoload_classes()
    {
        spl_autoload_register(function ($class) {
            $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($path)) {
                require_once $path;
            } else {
                error_log("No se encontró el archivo para la clase $class en la ruta $path");
            }
        });
    }

    public static function headers()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization, Content-Type');
        header('Access-Control-Allow-Credentials: true');
    }

    // Métodos adicionales como is_token_valid(), getBearerToken(), etc.
}
