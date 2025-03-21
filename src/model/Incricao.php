<?php

class Inscricao{
    /**Table: inscricoes
Columns:
id_inscricao int AI PK 
id_evento int 
id_participante int 
data_inscricao datetime 
status_inscricao enum('confirmada','pendente') */

    public $id_inscricao;
    public $id_evento;
    public $id_participante;
    public $data_incricao;
    public $status_inscricao;

    /**
     * @param int $id_inscricao
     * @return Inscricao
     */
    public function getById($id_inscricao){
        /**
         * buscar no banco o evento com o id passado, 
         * criar um objeto com o retorno do banco, ou um ojbeto null
         * para retornar
         */
        return new Inscricao();
    }

    /**
     * @return Inscricao[]
     */
    public function getAll(){
        /**
         * buscar no banco todos os eventos, 
         * criar um objeto com o retorno do banco, para cada retorno ou uma lista vazia []
         * para retornar
         */
        return [new Inscricao(), new Inscricao()];
    }

    /**
     * @param Inscricao $evento
     * @return Inscricao
     */
    public function save(Inscricao $inscricao){
        /**
         * montar a sql de inserção sem o id_evento,
         * executar ela,
         * pegar o retorno e colocar o id insereido no evento inserção e retorna-lo
         */
        return $inscricao;
    }

    /**
     * @param Inscricao $evento
     * @return boolean
     */
    public function update(Inscricao $inscricao){
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
    public function delete($id_inscricao){
        /**
         * criar a sql para delete do id
         * e verificar se deu certo, e retornar o status
         */
        return false;

    }

}