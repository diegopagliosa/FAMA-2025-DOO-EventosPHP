<?php

class EventoController
{

    public function retornaEventos(User $user)
    {
        error_log($user->id . ' - ' . $user->nome);
        if (isset($_GET["id_evento"])) {
            $evento = $this->retornaEvento($_GET["id_evento"]);
            echo json_encode($evento);
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
            die(json_encode(["error" => "Evento Não encontrado"]));
        }
        return $evento;
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
        $this->validaEvento($objJson);
        $evento = new Evento();
        $evento->jsonToEvento($objJson);

        if ($evento->save($evento)) {
            http_response_code(201);
            echo json_encode($evento);
        } else {
            http_response_code(400);
            die("Erro ao gravar os dados");
        }
    }

    public function atualizaEvento()
    {
        $jsonEntrada = file_get_contents("php://input");
        $objJson = json_decode($jsonEntrada);

        $eventoById = $this->retornaEvento($objJson->id_evento);
        $data_hoje = date('Y-m-d');
        if ($eventoById->data_evento <= $data_hoje) {
            http_response_code(400);
            die('{"erro": "Evento não pode ser atualizado, pois já passou a sua data."}');
        }

        $this->validaEvento($objJson);
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

    private function validaEvento($objJson)
    {
        if (!isset($objJson->nome) || strlen($objJson->nome) < 5  || strlen($objJson->nome) > 100) {
            http_response_code(400);
            die('{"erro": "Nome do Evento não informado ou Tamanho inválido."}');
        }

        if (!isset($objJson->data_evento)) {
            http_response_code(400);
            die('{"erro": "Informe uma Data válida para o Evento."}');
        }
        $data_hoje = date('Y-m-d');
        if ($objJson->data_evento <= $data_hoje) {
            http_response_code(400);
            die('{"erro": "Data informada deve Futura."}');
        }
        if (!isset($objJson->endereco) || strlen($objJson->endereco) < 5  || strlen($objJson->endereco) > 150) {
            http_response_code(400);
            die('{"erro": "Endereço do Evento não informado ou Tamanho inválido."}');
        }

        if (!isset($objJson->descricao) || strlen($objJson->descricao) < 15  || strlen($objJson->descricao) > 255) {
            http_response_code(400);
            die('{"erro": "Descrição do Evento não informado ou Tamanho inválido."}');
        }

        if (!isset($objJson->max_vagas)) {
            http_response_code(400);
            die('{"erro": "Informe uma número para o limite de vagas."}');
        }
        if ($objJson->max_vagas <= 1) {
            http_response_code(400);
            die('{"erro": "Evento deve ter ao menos duas vagas."}');
        }
    }
}
