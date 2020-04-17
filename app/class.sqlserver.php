<?php
// Configurações
if (!defined('SQL_DTF'))
    define('SQL_DTF', 'd/m/Y H:i:s'); // formato de data/hora usado pela instância do SQL Server

/**
 * Abstração de base de dados para Microsoft SQL Server Driver for PHP
 * 
 * @version 0.7
 * @author José Carlos Cieni Júnior
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class SQLServer extends Base {

    /**
     * Resource usado pela conexão
     * 
     * @var resource 
     */
    private $conexao = null;

    /**
     * Estabelece a conexão com o banco de dados especificado
     * 
     * @param string $instancia A instância do SQL Server
     * @param string $usuario O usuário da base de dados
     * @param string $senha A senha da base de dados
     * @param string $database A base de dados a utilizar por padrão
     * @param string $charset O conjunto de caracteres da conexão. UTF-8 por padrão
     */
    public function __construct($instancia, $usuario, $senha, $database, $charset = 'UTF-8') {
        $this->settable = false; // desativa a alteração de dados externa à classe
        $this->dados = array('insert_id' => null, 'affected_rows' => null, 'last_error' => array()); // campos que poderão ser vistos externamente

        // dados da conexão
        $dados = array(
            'Database' => $database,
            'PWD' => $senha,
            'UID' => $usuario,
            'CharacterSet' => $charset
        );

        // realiza a conexao...
        $conexao = sqlsrv_connect($instancia, $dados);
        
        // ... e verifica por erros
        if ($this->errors()) {
            echo '<pre>Erro ao conectar à base de dados! Detalhes: ';
            var_dump($this->last_error);
            die;
        }

        $this->conexao = $conexao;
    }

    /**
     * Libera os recursos utilizados pela base de dados
     */
    public function __destruct() {
        if (!is_null($this->conexao)) {
            @sqlsrv_close($this->conexao);
        }
    }

    /**
     * Verifica pelo acontecimento de erros e os disponibiliza na propriedade
     * last_error, em forma de array.
     * 
     * @return mixed true em caso de erros, null caso contrário
     */
    private function errors() {
        if (($erros = sqlsrv_errors()) != null) {
            $_erros = array();
            foreach ($erros as $_erro) {
                // exclui do tratamento de erros os códigos 5701 e 5703, pois estes
                // são mensagens de informação enviadas durante a conexão, e não erros
                if (!in_array($_erro['code'], array(5701, 5703)))
                    $_erros[] = $_erro;
            }
            $this->dados['last_error'] = $_erros;
            
            if (count($_erros) > 0)
                return true; // se deu erro, saímos...
        }
    }

    /**
     * Realiza query no banco de dados e devolve o resultado diretamente.
     * Para referência sobre os parâmetros, consulte
     * {@link http://php.net/manual/en/function.sqlsrv-query.php }
     * 
     * @param string $query A consulta a ser realizada
     * @param array $params Os parâmetros da query
     * @param array $options Opções da query
     * @return mixed Resultado da função sqlsrv_query ou uma null, em caso de erro
     */
    public function pquery($query, $params, $options) {
        // realiza a query
        $query = sqlsrv_query($this->conexao, $query, $params, $options);
        if ($this->errors()) {
            return;
        }
        return $query;
    }

    /**
     * Executa uma query no banco de dados
     * 
     * @param string $query A consulta a ser realizada
     * @return mixed Um objeto SQLServerResult no caso de select, boolean nos demais casos, null em caso de falha
     * @see SQLServerResult 
     */
    public function query($query) {
        $query = trim($query);
        $result = sqlsrv_query($this->conexao, $query, null, array('Scrollable' => SQLSRV_CURSOR_STATIC));
        // muda o cursor para o tipo estático para poder fazer uso da função sqlsrv_num_rows()

        if ($this->errors()) {
            return;
        }

        // reseta os atributos da classe
        $this->dados['affected_rows'] = null;
        $this->dados['insert_id'] = null;

        // verifica o tipo de consulta
        if (preg_match('/^(update|delete|insert)/i', $query)) {
            // se for update, delete ou insert, salva o numero de linhas afetadas
            $this->dados['affected_rows'] = sqlsrv_rows_affected($result);
            if (preg_match('/^insert/i', $query)) {
                // se for realizado um insert, tenta descobrir o nome da tabela
                // para preencher o atributo insert_id
                if (preg_match('/^insert.*into\s+\\[?([a-zA-Z0-9]+)\\]?.*/i', $query, $matches)) {
                    $query_cod = "SELECT TOP 1 @@IDENTITY FROM [$matches[1]]";
                    $result_cod = sqlsrv_query($this->conexao, $query_cod);
                    list($this->dados['insert_id']) = sqlsrv_fetch_array($result_cod, SQLSRV_FETCH_NUMERIC);
                }
            }
                
            return $result;
        } elseif (preg_match('/^select/i', $query)) { // se for um select, devolve um objeto resultSet
            return new SQLServerResult($result);
        } else {
            return $result;
        }
    }

    /**
     * Escapa uma string no padrão Transact-SQL
     * 
     * @param string $str A string a ser escapada
     * @return string A string escapada
     */
    public static function escape_string($str) {
        return str_replace("'", "''", $str);
    }
}

class SQLServerResult extends Base {

    /**
     * Índice do registro atual do result set
     * @var int
     */
    private $indiceAtual = 0;
    /**
     * Linhas do result set
     * @var mixed[]
     */
    private $linhas;

    /**
     * Preenche os campos da classe com base nos resultados da query
     * 
     * @param resource $result O resultado de uma query do SQLSRV
     */
    public function __construct($result) {
        $this->settable = false; // desativa alteração nos pseudo-membros da classe
        
        // preenche os campos da classe com base nos resultados
        $this->dados = array(
            'num_rows' => sqlsrv_num_rows($result),
            'num_fields' => sqlsrv_num_fields($result),
            'has_rows' => sqlsrv_has_rows($result)
        );

        $this->fetch($result); // preenche o array de resultados
    }

    /**
     * Percorre todas as linhas do resultado e as armazena no vetor
     *
     * @param resource $result O resultado de uma query do SQLSRV
     */
    private function fetch($result) {
        $linhas =& $this->linhas;

        $linhas = array();
        while ($r = sqlsrv_fetch_array($result)) {
            $linhas[] = $r;
        }
        
        sqlsrv_free_stmt($result); // libera o resource da memória, já que não precisaremos percorre-lo novamente
    }

    /**
     * Retorna um array contendo todos os resultados da query, com os campos em forma de objeto
     *
     * @return stdClass[] Um array com os resultados da query em forma de objeto
     */
    public function get_as_object() {
        $linhas = $this->linhas;
        foreach ($linhas as $i => $linha) {
            $linhas[$i] = (object) $linha;
        }

        return $linhas;
    }

    /**
     * Retorna um array contendo todos os resultados da query, com os campos em forma de array
     *
     * @return mixed[][] Um array com os resultados da query em forma de array
     */
    public function get_as_array() {
        return $this->linhas;
    }

    /**
     * Simula o funcionamento da função sqlsrv_fetch_array(), percorrendo o
     * result set registro a registro. Devolve a linha atual em forma de array associativo.
     * 
     * @return mixed A linha atual ou falso, caso não haja mais registros
     */
    public function fetch_array() {
        if ($this->indiceAtual < $this->dados['num_rows']) {
            $resultado = $this->linhas[$this->indiceAtual];
            $this->indiceAtual++;

            return $resultado;
        } else {
            return false;
        }
    }

    /**
     * Simula o funcionamento da função sqlsrv_fetch_array(), percorrendo o
     * result set registro a registro. Devolve a linha atual em forma de objeto.
     * 
     * @return mixed A linha atual ou falso, caso não haja mais registros
     */
    public function fetch_object() {
        $row = $this->fetch_array();
        return $row ? (object) $row : false;
    }

    /**
     * Pega uma linha do set e devolve como array associativo. Simula o funcionamento
     * do FETCH ABSOLUTE.
     * 
     * @param int $indice A linha a ser selecionada
     * @return mixed Um array com os campos da linha caso ela exista ou null, caso a linha não esteja no set
     */
    public function get_row_as_array($indice) {
        if ($indice > 0 && $indice < $this->dados['num_rows']) {
            return $this->linhas[$indice];
        } else {
            return null;
        }
    }

    /**
     * Pega uma linha do set e devolve como objeto. Simula o funcionamento
     * do FETCH ABSOLUTE.
     * 
     * @param int $indice A linha a ser selecionada
     * @return mixed Um objeto com os campos da linha caso ela exista ou null, caso a linha não esteja no set
     */
    public function get_row_as_object($indice) {
        return (object) $this->get_row_as_array($indice);
    }

    /**
     * Posiciona o ponteiro interno da classe (usado no fetch_array()) em um determinado índice.
     * 
     * @param int $indice O novo índice do ponteiro.
     * @return mixed Falso caso o índice esteja fora dos limites do result set, a posição antiga caso contrário.
     */
    public function seek($indice) {
        if ($indice >= 0 && $indice < $this->dados['num_rows']) {
            $indiceAntigo = $this->indiceAtual;
            $this->indiceAtual = $indice;

            return $indiceAntigo;
        } else {
            return false;
        }
    }

    /**
     * Posiciona o ponteiro interno da classe (usado no fetch_array()) no primeiro registro.
     * 
     * @return mixed O mesmo de seek()
     */
    public function first() {
        return $this->seek(0);
    }

    /**
     * Posiciona o ponteiro interno da classe (usado no fetch_array()) no último registro.
     * 
     * @return mixed O mesmo de seek()
     */
    public function last() {
        return $this->seek($this->dados['num_rows'] - 1);
    }

    /**
     * Devolve o valor de um campo da tabela, passando o índice da linha e o índice da coluna
     * 
     * @param int $row O índice da linha no set
     * @param int $col O índice da coluna no set
     * @return mixed O valor do campo caso ele exista, null caso contrário.
     */
    public function get_field($row, $col) {
        if ($row >= 0 && $row < $this->dados['num_rows'] && $col >= 0 && $col < $this->dados['num_fields']) {
            return $this->linhas[$row][$col];
        } else {
            return null;
        }
    }

}

// Conjunto de funções para gerar queries de insert, update, select e delete
class SQLServerFactory {
    
    /**
     * Gera query de INSERT dada uma tabela e um array associativo dos valores à inserir
     * 
     * @param string $tabela O nome da tabela
     * @param mixed $campos Array associativo com os campos da tabela e seus respectivos valores
     * @return string O INSERT gerado
     */
    public static function insert($tabela, $campos) {
        // previne SQL Injections
        foreach ($campos as $campo => $valor) {
            $_valor = $valor;
            if ($_valor instanceof DateTime) {
                $_valor = $_valor->format(SQL_DTF);
            } elseif (is_bool($_valor)) { 
                $_valor = $_valor ? 1 : 0;
            }
            $campos[$campo] = "'" . SQLServer::escape_string($_valor) . "'";
        }
        
        // DDL => Data Definition Language
        $ddl = "[" . implode("], [", array_keys($campos)) . "]";
        
        // DML => Data Manipulation Language
        $dml = implode(", ", array_values($campos));
        
        // monta a query
        $query = "INSERT INTO [$tabela] ($ddl) VALUES ($dml) ";
        
        return $query;
    }
    
    /**
     * Gera query de UPDATE dada uma tabela e um array associativo dos valores à atualizar
     * 
     * @param string $tabela O nome da tabela
     * @param mixed $campos Array associativo com os campos da tabela e seus respectivos valores
     * @param string $campocodigo Nome da coluna que filtrará o update
     * @param mixed $codigo O valor que filtrará o update
     * @return string O UPDATE gerado
     */
    public static function update($tabela, $campos, $campocodigo, $codigo) {
        $set = array();
        $codigo = SQLServer::escape_string($codigo);
        
        // previne SQL Injections
        foreach ($campos as $campo => $valor) {
            // converte possíveis tipos incompatíveis em strings
            $_valor = $valor;
            if ($_valor instanceof DateTime) {
                $_valor = $_valor->format(SQL_DTF);
            } elseif (is_bool($_valor)) { 
                $_valor = (int) $_valor;
            }
            $set[] = "[$campo] = '" . SQLServer::escape_string($_valor) . "'";
        }
        
        $set = implode(', ', $set);
        
        // monta a query
        $query = "UPDATE [$tabela] SET $set WHERE [$campocodigo] = '$codigo' ";
        
        return $query;
    }
    
    /**
     * Gera query de DELETE dada uma tabela e o campo a filtrar
     * 
     * @param string $tabela O nome da tabela
     * @param string $campocodigo Nome da coluna que filtrará o delete
     * @param mixed $codigo O valor que filtrará o delete
     * @return string O DELETE gerado
     */
    public static function delete($tabela, $campocodigo, $codigo) {
        $codigo = SQLServer::escape_string($codigo);
        $query = "DELETE FROM [$tabela] WHERE [$campocodigo] = '$codigo'";
        
        return $query;
    }
    
}