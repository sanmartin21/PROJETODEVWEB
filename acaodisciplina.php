<?php
header('Content-Type: text/html; charset=UTF-8');
include 'connect/connect.php';
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";

$acao = '';
if (isset($_GET["acao"]))
    $acao = $_GET["acao"];

if ($acao == "excluir") {
    $codigo = 0;
    if (isset($_GET["codigo"])) {
        $codigo = $_GET["codigo"];
        excluir($codigo);
    }
} else {
    if (isset($_POST["acao"])) {
        $acao = $_POST["acao"];
        if ($acao == "salvar") {
            $codigo = 0;
            if (isset($_POST["codigo"])) {
                $codigo = $_POST["codigo"];
                if ($codigo == 0)
                    inserir();
                else
                    alterar($codigo);
            }
        }
    }
}

function excluir($codigo)
{
    $sql = "DELETE FROM disciplina WHERE codigo = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:alistardisciplina.php');
    else
        header('location:alistardisciplina.php');
}

function alterar($codigo)
{
    $vet = carregarTelaParaVetor();
    $sql = 'UPDATE ' . $GLOBALS['tb_disciplina'] .
        ' SET professor_codigo = "' . $vet['professor'] . '"' .
        ', turma_codigo = ' . $vet['turma'] .
        ', nome = "' . $vet['nome'] . '"' .
        ' WHERE codigo = ' . $codigo;
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    if ($result == 1)
        header('location:caddisciplina.php?msg="sa"&acao=editar&codigo=' . $codigo);
    else
        header('location:caddisciplina.php?msg="er"&acao=editar&codigo=' . $codigo);
}

function inserir()
{

    $dados = carregarTelaParaVetor();
    //var_dump($dados);

    $pdo = Conexao::getInstance();
    $stmt = $pdo->prepare('INSERT INTO disciplina (codigo, nome, professor_codigo, turma_codigo) VALUES (:codigo, :nome, :professor_codigo, :turma_codigo)');
    $codigo = $dados['codigo'];
    $nome = $dados['nome'];
    $professor_codigo = $dados['professor'];
    $turma_codigo = $dados['turma'];
    $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':professor_codigo', $professor_codigo, PDO::PARAM_INT);
    $stmt->bindParam(':turma_codigo', $turma_codigo, PDO::PARAM_INT);

    $stmt->execute();

    header("location:caddisciplina.php");

}

function carregarTelaParaVetor()
{
    $vet = array();
    $vet['codigo'] = $_POST["codigo"];
    $vet['professor'] = $_POST["professor"];
    $vet['turma'] = $_POST["turma"];
    $vet['nome'] = $_POST["nome"];
    return $vet;
}

function carregaBDParaVetor($codigo)
{
    $sql = "SELECT * FROM disciplina WHERE codigo = $codigo;";
    $result = mysqli_query($GLOBALS['conexao'], $sql);
    $dados = array();
    while ($row = mysqli_fetch_array($result)) {
        $dados['codigo'] = $row['codigo'];
        $dados['professor'] = $row['professor_codigo'];
        $dados['turma'] = $row['turma_codigo'];
        $dados['nome'] = $row['nome'];
    }
    return $dados;
}
