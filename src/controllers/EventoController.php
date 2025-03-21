<?php

class EventoController
{

    public function retornaEventos()
    {
        if (isset($_GET["id_evento"])) {
            $this->retornaEvento($_GET["id_evento"]);
        } else {
            $this->retornaTodosEventos();
        }
    }

    public function retornaEvento(int $id)
    {
        $obj = new Evento();
        $evento = $obj->getById($id);
        if (!$evento) {
            http_response_code(404);
            $evento = ["error" => "Evento Não encontrado"];
        }
        echo json_encode($evento);
    }

    public function retornaTodosEventos()
    {
        $obj = new Evento();
        $lista = $obj->getAll();
        echo json_encode($lista);
    }

    public function gravaEvento()
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);
        $evento = new Evento();
        $evento->jsonToEvento($objJson);
        if ($evento->save($evento)) {
            http_response_code(201);
            echo json_encode($evento);
        } else {
            echo "Erro ao gravar os dados";
            http_response_code(400);
            exit;
        }
    }

    public function atualizaEvento()
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);
        if (!isset($objJson->nome) || strlen($objJson->nome) < 1) {
            http_response_code(400);
            die('{"erro": "Nome do Evento não informado"}');
        }
        $evento = new Evento();
        $evento->jsonToEvento($objJson);
        if ($evento->update($evento)) {
            echo json_encode($evento);
            http_response_code(202);
        } else {
            echo "Erro ao Atualizar os dados";
            http_response_code(400);
            exit;
        }
    }

    public function excluiEvento()
    {
        if (isset($_GET["id_evento"])) {
            Evento::delete($_GET["id_evento"]);
        }
    }
}
