<?php

$routes = [
    "GET:eventos" => [
        'controlador' => "EventoController",
        'metodo' => "retornaEventos"
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


];
