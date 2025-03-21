<?php

/**id_participante int AI PK 
nome varchar(255) 
email varchar(255) 
telefone varchar(20) */
class Participante
{

    public $id_participante;
    public $nome;
    public $email;
    public $telefone;

    /**
     * @param int $id_participante
     * @return Participante
     */
    public function getById($id_participante)
    {
        /**
         * buscar no banco o evento com o id passado, 
         * criar um objeto com o retorno do banco, ou um ojbeto null
         * para retornar
         */
        return new Participante();
    }

    /**
     * @return Participante[]
     */
    public function getAll()
    {
        /**
         * buscar no banco todos os eventos, 
         * criar um objeto com o retorno do banco, para cada retorno ou uma lista vazia []
         * para retornar
         */
        return [new Participante(), new Participante()];
    }

    /**
     * @param Participante $evento
     * @return Participante
     */
    public function save(Participante $participante)
    {
        /**
         * montar a sql de inserção sem o id_evento,
         * executar ela,
         * pegar o retorno e colocar o id insereido no evento inserção e retorna-lo
         */
        return $participante;
    }

    /**
     * @param Participante $evento
     * @return boolean
     */
    public function update(Participante $participante)
    {
        /**
         * criar o comando de update para atualizar todos os campos fora as chaves primárias
         * executar, e retornar se exeutado.
         */
        return true;
    }

    /**
     * @param int $id_evento
     * @return boolean
     */
    public function delete($id_participante)
    {
        /**
         * criar a sql para delete do id
         * e verificar se deu certo, e retornar o status
         */
        return false;
    }
}
