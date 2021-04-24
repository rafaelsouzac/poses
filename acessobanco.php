<?php
/* 

Função que tem a responsabilidade de conectar ao SGDB Mysql ou MariaDB, Ver
Documentação da infraestrutura do sistema para saber. Ainda faz a manipulação de 
Comandos DML do SQL.

Entrada: Recebe uma String contendo os DML do SQL.

Saída: Retornar um objeto com o resultado do comando. Quando o comando é Select 
retorna a tabela com os dados ou um campo vazio. Os demais comandos INSERT, UPDATE
e DELETE, retorna o numero de linhas afetadas.

Autor código: Rafael de Souza Corrêa
Data da criação: fev. 2019

Autor do Refactory: 
Data da Revisão:
O que foi executado:

1) Gerou a documentação incial do código.
1) Análise e se necessário alteração do padrão do código.
2) Análise da lógica e o que pode ser alterado para diminuir o tamanho do código.
3) Quais blocos de códigos podem tornar-se outras funções.
4) Testar as entradas e saídas, garantindo o tipo de informação que será manipulada.

*/

function ConexaoBanco($strParamQuery)
{
    $strServidor = (string)"localhost";
    $strUsuario = (string)"root";
    $strSenha = (string)"";
    $strBanco = (string)"gastronomia";
    $strQuery = (string)$strParamQuery;
    //$strResultado = "";
    $arrResultado = array();
    $intVerificaQuery = 0;
    
    $strConexao = mysqli_connect($strServidor, $strUsuario, $strSenha, $strBanco, 3307);
    
    $strParamQuery = strtolower($strParamQuery);
        
    if($strConexao)
    {
        $intVerificaQuery = substr_count($strParamQuery, "select");
        if($intVerificaQuery > 0)
        {
            $strResultado = mysqli_query($strConexao,$strQuery);
            return $strResultado;
        }
        else
        {
            $strResultado = mysqli_query($strConexao,$strQuery);
            //trocar pelo numero de linhas afetadas
            $strResultado = mysqli_affected_rows($strConexao);
            return $strResultado;
        }
    }
    else
    {
        die("Falha na Conexao com Banco".mysqli_connect_errno());
    }
    
    mysqli_close($strConexao);
}
?>
