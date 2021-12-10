<!DOCTYPE html>
<?php
include_once "acaoturma.php";
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
<a href="alistarturma.php"><button>Listar</button></a>
<a href="cadturma.php"><button>Novo</button></a>
<br><br>
<form action="acaoturma.php" method="post">
    <input readonly  type="number" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo 0; ?>"><br>
    Nome da Turma: 
    <input required=true   type="text" name="nome" id="nome" value="<?php if ($acao == "editar") echo $dados['nome']; ?>"><br>
    Número de Alunos:
    <input required=true   type="text" name="numeroAlunos" id="numeroAlunos" value="<?php if ($acao == "editar") echo $dados['numeroAlunos']; ?>"><br>
    <br><button type="submit" name="acao" id="acao" value="salvar">Salvar Turma</button>
</form>
</body>
</html>