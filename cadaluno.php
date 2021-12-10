<!DOCTYPE html>
<?php
include_once "acaoaluno.php";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
$dados;
if ($acao == 'editar'){
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : "";
    if ($codigo > 0)
        $dados = buscarDados($codigo);
}
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<br>
<a href="alistaraluno.php"><button>Listar</button></a>
<a href="cadaluno.php"><button>Novo</button></a>
<br><br>
<form action="acaoaluno.php" method="post">
    <input readonly  type="number" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo 0; ?>"><br>
    Nome do Aluno: 
    <input required=true   type="text" name="nome" id="nome" value="<?php if ($acao == "editar") echo $dados['nome']; ?>"><br>
    Idade: 
    <input required=true   type="number" name="idade" id="idade" value="<?php if ($acao == "editar") echo $dados['idade']; ?>"><br>
    <br><button type="submit" name="acao" id="acao" value="salvar">Salvar</button>
</form>
</body>
</html>