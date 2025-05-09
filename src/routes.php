<?php

$routes = [
    "GET:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "retornaEventos",
        'protegido' => true
    ],
    "POST:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "gravaEvento"
    ],
    "PUT:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "atualizaEvento"
    ],
    "DELETE:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "excluiEvento"
    ],

    "GET:user" => [
        'controlador' => "UserController",
        'metodo' => "retornaUsuarios"
    ],
    "POST:user" => [
        'controlador' => "UserController",
        'metodo' => "gravaUser"
    ],
    "PUT:user" => [
        'controlador' => "UserController",
        'metodo' => "atualizaUser"
    ],
    "DELETE:user" => [
        'controlador' => "UserController",
        'metodo' => "excluiUser"
    ],
    "POST:login" => [
        'controlador' => "UserController",
        'metodo' => 'login'
    ]

];
