<?php

$routes = [
    "GET:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "retornaEventos",
        'protegido' => false
    ],
    "GET:meusEventos" => [
        'controlador' => "UserController",
        'metodo' => "retornaEventos",
        'protegido' => true
    ],
    "POST:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "gravaEvento",
        'protegido' => true
    ],
    "PUT:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "atualizaEvento",
        'protegido' => true
    ],
    "DELETE:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "excluiEvento",
        'protegido' => true
    ],

    "GET:user" => [
        'controlador' => "UserController",
        'metodo' => "retornaUsuarios",
        'protegido' => true
    ],
    "POST:user" => [
        'controlador' => "UserController",
        'metodo' => "gravaUser",
        'protegido' => false
    ],
    "PUT:user" => [
        'controlador' => "UserController",
        'metodo' => "atualizaUser",
        'protegido' => true
    ],
    "DELETE:user" => [
        'controlador' => "UserController",
        'metodo' => "excluiUser",
        'protegido' => true
    ],
    "POST:login" => [
        'controlador' => "UserController",
        'metodo' => 'login',
        'protegido' => false
    ]

];
