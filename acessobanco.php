<?php

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
