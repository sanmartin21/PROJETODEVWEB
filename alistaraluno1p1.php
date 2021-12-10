<!DOCTYPE html>
<?php
include_once "conf/default.inc.php";
require_once "conf/Conexao.php";
?>
<html lang="pt-br">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Endereço do Aluno</title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
    <style>
        <style>
        table {
            text-align: center;
            margin: 0 auto;
            border-collapse: collapse;
            border-radius: 5px;
            padding: .7em;
            width: 75%;
            margin-bottom : .5em;
            table-layout: fixed;
            border-style: center;
            /* hide standard table (collapsed) border */
            box-shadow: 0 0 0 1px black;
            /* this draws the table border  */
        }

        tr,
        th,
        td {
            border: 1px solid black;
        }

        th {
            width: 150px;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>
<?php
    include  "menu.php" ;
?>
    <a href="cadaluno1p1.php">Novo Endereço do Aluno</a>

    <form method="POST">
        <br><h3><B>Consultar endereço do Aluno por: <br></B></h3>
        <input type="radio" name="optionSearchUser" id="" value="codigo" required>Código do Aluno<br>
        <input type="radio" name="optionSearchUser" id="" value="nome" required>Nome do Aluno<br>
        <input type="radio" name="optionSearchUser" id="" value="idade" required>Idade do Aluno<br>
        <input type="radio" name="optionSearchUser" id="" value="cidade" required>Cidade do Aluno<br>
        <input type="radio" name="optionSearchUser" id="" value="bairro" required>Bairro do Aluno<br>
        <input type="radio" name="optionSearchUser" id="" value="rua" required>Rua do Aluno<br>
        <br><h3><B>Ordenar endereço do Aluno por: <br></B></h3>
        <input type="radio" name="optionOrderUser" id="" value="codigo" required>Código do Aluno<br>
        <input type="radio" name="optionOrderUser" id="" value="nome" required>Nome do Aluno<br>
        <input type="radio" name="optionOrderUser" id="" value="idade" required>Idade do Aluno<br>
        <input type="radio" name="optionOrderUser" id="" value="cidade" required>Cidade do Aluno<br>
        <input type="radio" name="optionOrderUser" id="" value="bairro" required>Bairro do Aluno<br>
        <input type="radio" name="optionOrderUser" id="" value="rua" required>Rua do Aluno<br>
        <br>
        <a href="alistaraluno1p1.php">Listar todos endereços de Alunos</a><br><br>
        <input type="text" name="valorUser">
        <input type="submit" value="Consultar endereço do Aluno">
    </form>
    <?php

    try {

        $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

        $WHERE = "";

        if ($optionSearchUser != "") {
            if ($optionSearchUser == "codigo") {
                $WHERE = "WHERE aluno.codigo = $valorUser"; 
            }elseif ($optionSearchUser == "idade") {
                $WHERE = "WHERE aluno.idade = $valorUser";    
            }elseif ($optionSearchUser == "nome") {
                $WHERE = "WHERE aluno.nome LIKE '$valorUser%'";             
            } elseif ($optionSearchUser == "cidade") {
                $WHERE = "WHERE endereco.cidade LIKE '$valorUser%'";           
            } elseif ($optionSearchUser == "bairro") {
                $WHERE = "WHERE endereco.bairro LIKE '$valorUser%'";   
            } elseif ($optionSearchUser == "rua") {
                $WHERE = "WHERE endereco.rua LIKE '$valorUser%'";     
                }
        }

        $ORDER = "";

        if ($optionOrderUser != "") {
            if ($optionOrderUser == "codigo") {
                $ORDER = "ORDER BY aluno.codigo"; 
            }elseif ($optionOrderUser == "idade") {
                $ORDER = "ORDER BY aluno.idade";    
            }elseif ($optionOrderUser == "nome") {
                $ORDER = "ORDER BY aluno.nome";             
            } elseif ($optionOrderUser == "cidade") {
                $ORDER = "ORDER BY endereco.cidade";           
            } elseif ($optionOrderUser == "bairro") {
                $ORDER = "ORDER BY endereco.bairro";   
            } elseif ($optionOrderUser == "rua") {
                $ORDER = "ORDER BY endereco.rua";     
                }
        }

        $sql = "SELECT aluno.codigo, aluno.nome, aluno.idade, endereco.cidade, endereco.bairro, endereco.rua FROM aluno LEFT JOIN endereco ON endereco.codigo = aluno.codigo " .$WHERE." " .$ORDER;
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table><tr><th>Código do Aluno</th><th>Nome do Aluno</th><th>Idade do Aluno</th><th>Cidade do Aluno</th><th>Bairro do Aluno</th><th>Rua do Aluno</th><th>Alterar Endereço do Aluno</th><th>Excluir Endereço do Aluno</th></tr>";
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <tr>
                <td><?php echo $linha['codigo']; ?></td>
                <td><?php echo $linha['nome']; ?></td>
                <td><?php echo $linha['idade']; ?></td>
                <td><?php echo $linha['cidade']; ?></td>
                <td><?php echo $linha['bairro']; ?></td>
                <td><?php echo $linha['rua']; ?></td>
                <td><a href='cadaluno1p1.php?acao=editar&codigo=<?php echo $linha['codigo']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                <td><a href="javascript:excluirRegistro('acaoaluno1p1.php?acao=excluir&codigo=<?php echo $linha['codigo']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
            </tr>
        <?php } ?>
        </table>
    <?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    ?>

</body>

</html>