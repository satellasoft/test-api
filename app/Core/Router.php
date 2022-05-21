<?php

namespace App\Core;

class Router
{
    private ?string $path;
    private string $type;

    private array $postRoute = [];
    private array $getRoute = [];

    public function __construct()
    {
        $this->path = $this->getPath();

        $this->type = $_SERVER['REQUEST_METHOD'];
    }

    public function post(string $path, array $action)
    {
        $this->postRoute[] = [
            $path, $action
        ];
    }

    public function get(string $path, array $action)
    {
        $this->getRoute[] = [
            $path, $action
        ];
    }

    public function run()
    {
        if ($this->type == 'POST') {
            if ($this->runPost())
                return;
        }

        if ($this->type == 'GET') {
            if ($this->runGet())
                return;
        }

        return responseJson([], 404);
    }

    private function runPost(): bool
    {
        foreach ($this->postRoute as $route) {
            if (isset($route[0]) && $route[0] == $this->path) {

                if (!isset($route[1][0]) || !isset($route[1][1]))
                    continue;

                call_user_func([
                    $route[1][0],
                    $route[1][1]
                ]);

                return true;
            }
        }

        return false;
    }

    private function runGet(): bool
    {
        foreach ($this->getRoute as $route) {
            if (isset($route[0]) && $route[0] == $this->path) {

                if (!isset($route[1][0]) || !isset($route[1][1]))
                    continue;

                call_user_func([
                    $route[1][0],
                    $route[1][1]
                ]);

                return true;
            }
        }

        return false;
    }

    private function executeController($controller, $method)
    {
    }

    private function getPath(): ?string
    {
        $parameter = $_SERVER['REQUEST_URI'] ?? null;

        $hasQuery = strpos($parameter, '?');

        if ($hasQuery) {
            $parameter = substr($parameter, 0, $hasQuery);
        }

        $parameter = str_replace(['/', '\\'], '', $parameter);

        return $parameter;
    }
}
