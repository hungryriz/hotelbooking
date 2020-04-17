<?php
/**
 * Métodos básicos que fazem a classe simular o funcionamento de stdClass
 * sem o uso de ArrayObject, de forma mais avançada e com maior controle dos campos.
 * 
 * @author José Carlos
 * @see ArrayObject
 * @see stdClass
 */
class Base {

    protected $settable = true; // pode alterar os dados externamente?
    protected $gettable = true; // pode visualizar os dados externamente?
    protected $dados = array(); // precisa ser sobrescrito com os campos existentes!
    protected $campos_protegidos = array(); // campos que não podem ser escritos externamente
    private $campos_alterados = array();
    
    // altera um valor
    public function set($nome, $valor) {
        // previne que sejam alterados campos não existentes
        if ($this->settable && !in_array($nome, $this->campos_protegidos))
            $this->_set($nome, $valor);
    }
    
    // limpa a array de campos alterados, "salvando" edições
    public function save() {
        $this->campos_alterados = array();
    }
    
    private function _set($nome, $valor){
        if (array_key_exists($nome, $this->dados)) {
            if (!array_key_exists($nome, $this->campos_alterados))
                $this->campos_alterados[$nome] = $this->dados[$nome];
            
            $this->dados[$nome] = $valor;
        }
    }
    
    // permite alteração de vários campos de uma só vez
    protected function _setFields($campos) {
        if (!is_array($campos))
            trigger_error(__FUNCTION__ . ' espera que o primeiro parâmetro seja um array, '
                    . gettype($campos) . ' recebido.', E_USER_WARNING);
        
        foreach ($campos as $nome => $valor) {
            $this->_set($nome, $valor);
        }
    }
    
    public function setFields($campos) {
        if (!is_array($campos))
            trigger_error(__FUNCTION__ . ' espera que o primeiro parâmetro seja um array, '
                    . gettype($campos) . ' recebido.', E_USER_WARNING);
        
        foreach ($campos as $nome => $valor) {
            $this->set($nome, $valor);
        }
    }
    
    // devolve uma array com campos alterados
    public function getModified($save = true) {
        $dados = array();
        
        foreach ($this->dados as $campo => $valor) {
            if (array_key_exists($campo, $this->campos_alterados)) {
                $dados[$campo] = $valor;
            }
        }
        
        if ($save)
            $this->save();
        
        return $dados;
    }
    
    public function getFields() {
        return array_keys($this->dados);
    }

    /* Métodos mágicos! */

    // Pseudo-setter
    public function __set($nome, $valor) {
        $this->set($nome, $valor);
    }

    // Pseudo-getter
    public function __get($nome) {
        if ($this->gettable) {
            if (array_key_exists($nome, $this->dados)) {
                return $this->dados[$nome];
            } else {
                return false;
            }
        }
    }

    // O valor existe?
    public function __isset($nome) {
        if ($this->gettable) {
            return array_key_exists($nome, $this->dados) && $this->dados[$nome] !== '';
        }
    }

    // Limpa valor
    public function __unset($nome) {
        if ($this->settable && !in_array($nome, $this->campos_protegidos)) {
            // previne que sejam alterados campos
            if (array_key_exists($nome, $this->dados)) {
                $antigo = "";
                if (array_key_exists($nome, $this->campos_alterados)) {
                    $antigo = $this->campos_alterados[$nome];
                    unset($this->campos_alterados[$nome]);
                }

                $this->dados[$nome] = $antigo;
            }
        }
    }
}