<?php

namespace Core;

use Controller\TableController;
use Model\DbTable;
use mysqli;
use View\View;

class Dispatcher
{

    public function __construct()
    {
    }

    public function run()
    {
        // ?action=show
        // ?action=add

        include __DIR__ . "/../../config/config.php";

        $view = new View();
        $view->setLayout('mainLayout');

        $controller = new TableController(
            new DbTable(
                new \mysqli(
                    $config['mysql']['host'],
                    $config['mysql']['user'],
                    $config['mysql']['password'],
                    $config['mysql']['database']
                ),
                $config['mysql']['table']
            ),

            $view
        );

        $action = "action" . $_GET["action"];

        $controllerData = $_POST;

        if (method_exists($controller, $action)) {
            $controller->{$action}($controllerData);
        } else{
            $controller->actionDefault();
        }

        // $controller->actionShow()
        // $controller->{"actionshow"}();
    }
}