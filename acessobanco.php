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

Autor do Refactory: Rafael de Souza Corrêa
Data da Revisão: Abr. 2021
O que foi executado:

1) Gerou a documentação incial do código.
2) Análise e se necessário alteração do padrão do código.
    
    Alteração das variáveis que contém as informações de acesso ao SGDB
    para constantes. Visto que INFORMAÇÕES que não modificam-se ao longo
    do código não devem ser escritas em variáveis, e sim em CONSTANTES.

    Retirada a variável $arrResultado, estava declarada, mas não utilizada.

    Alteração da variável $strRetorno para $strintRetorno, visto que pode
    ser atribuido tanto uma string quanto um integer.

3) Análise da lógica e o que pode ser alterado para diminuir o tamanho do código.

    substituição da função substr_count, que é case sensitive pela
    stripos que é case INSENSITIVE, com isso posso eliminar a linha que 
    transforma a query toda em minúsculo.

4) Quais blocos de códigos podem tornar-se outras funções.

    Não se aplica neste caso.

5) Testar as entradas e saídas, garantindo o tipo de informação que será manipulada.

    Não se aplica neste caso, visto que as funções mysqli já retornam os valores de
    erros caso o programador envie querys de forma inapropriada. Cabendo ao DBA do
    SGDB a verificação e acessos a base de dados.
    
*/

function ConexaoBanco($strParamQuery)
{

    define("strSERVIDOR", "localhost");
    define("strUSUARIO", "root");    
    define("strSENHA", "strS3nh453cr3t4"); 
    //alterar para senha do servidor de produção quando hospedado.
    define("strBASE", "gastronomia"); 

    //Eliminei esta variável pelo fato de estar em excesso,
    //não há sentido em ter dois locais com a mesma informação.
    //fiz o casting na própria variável.
    $strParamQuery = (string)$strParamQuery;

    //alterei o nome da variável para que o prefixo indique os tipos de
    //dados que podem ser atribuidos a ela. VIVA a tipação dinâmica.
    $strintResultado = "";

    //declaração formal da variável $strConexao;
    $strConexao = "";

    $intVerificaQuery = 0;

    $strConexao = mysqli_connect(strSERVIDOR, strUSUARIO, strSENHA, strBASE, 3306);

    if($strConexao)
    {
        $intVerificaQuery = stripos($strParamQuery, "select");

        if($intVerificaQuery > 0)
        {
            $strintResultado = mysqli_query($strConexao,$strParamQuery);
            return $strintResultado;
        }
        else
        {
            $strintResultado = mysqli_query($strConexao,$strParamQuery);
            //substituido pelo numero de linhas afetadas
            $strintResultado = mysqli_affected_rows($strConexao);
            return $strintResultado;
        }
    }
    else
    {
        die("Falha na Conexao com Banco".mysqli_connect_errno());
    }
    
    mysqli_close($strConexao);
}
?>