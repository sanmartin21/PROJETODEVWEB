<!DOCTYPE html>
<?php 
    $title = "Cadastro de Produtos";
    include 'connect/connect.php';
    include 'acaodisciplina.php';
    $acao = '';
    $id = '';
    $dados;
    if (isset($_GET["acao"]))
        $acao = $_GET["acao"];
    if ($acao == "editar"){
        if (isset($_GET["codigo"])){
            $codigo = $_GET["codigo"];
            $dados = carregaBDParaVetor($codigo);
        }
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>        
</head>
<body>
    <a href="alistardisciplina.php"><button>Listar</button></a><br>
    <form action="acaodisciplina.php" id="form" method="post">
    <input readonly  type="text" name="codigo" id="codigo" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo 0; ?>"><br>
        <label for="">Nome do Professor</label>
        <select name="professor" id="professor">
            <?php
            $sql = "SELECT * FROM professor;";
            #$pdo = Conexao::getInstance();
            #$consulta = $pdo->query($sql);
            $result = mysqli_query($conexao, $sql);
            #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['codigo'] . '"';
                if ($acao == "editar" && $dados['professor'] == $row['codigo'])
                    echo ' selected';
                echo '>' . $row['nome'] . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="">Nome da Turma</label>
        <select name="turma" id="turma">
            <?php
            $sql = "SELECT * FROM turma;";
            $result = mysqli_query($conexao, $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['codigo'] . '"';
                if ($acao == "editar" && $dados['turma'] == $row['codigo'])
                    echo ' selected';
                echo '>' . $row['nome'] . '</option>';
            }
            ?>
        </select>
        <br>
        <label for="">Nome da Disciplina</label>
        <input required=true placeholder="nome" type="text" name="nome" id="nome" value="<?php if ($acao == "editar") echo $dados['nome']; ?>"><br>
        <br>
        <button name="acao" value="salvar" id="acao" type="submit">Salvar</button>
    </form>
</body>
</html>