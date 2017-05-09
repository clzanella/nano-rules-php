<?php

namespace NanoRules\Tests\DTO;

/**
 * Description of Empresa
 *
 * @author cleber.zanella
 */
class Empresa {
    public $id;
    public $nome;
    public $cep;
    public $pais;
    public $estado;
    public $cidade;
    public $endereco;
    public $observacoes;
    public $telefone1;
    public $telefone2;
    public $email1;
    public $email2;
    public $website;
    public $logomarca;
    
    // associação N..N
    public $categorias = array();
}
