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
    <title>Lista de Professores</title>
    <script>
        function excluirRegistro(url) {
            if (confirm("Confirmar Exclusão?"))
                location.href = url;
        }
    </script>
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
    <a href="cadprofessor.php">Novo Professor</a>

    <form method="POST">
        <br><h3><B>Consultar professor por:</h3></B>
        <input type="radio" name="optionSearchUser" id="" value="codigo" required>Código do Professor<br>
        <input type="radio" name="optionSearchUser" id="" value="nome" required>Nome do Professor<br>
        <input type="radio" name="optionSearchUser" id="" value="materia" required>Matéria do Professor<br>
        <br><h3><B>Ordenar professor por:</h3></B>
        <input type="radio" name="optionOrderUser" id="" value="codigo" required>Código do Professor<br>
        <input type="radio" name="optionOrderUser" id="" value="nome" required>Nome do Professor<br>
        <input type="radio" name="optionOrderUser" id="" value="materia" required>Matéria do Professor<br>
        <br>
        <a href="alistarprofessor.php">Listar todos os Professores</a><br><br>
        <input type="text" name="valorUser">
        <input type="submit" value="Consultar Professor">
    </form>
    <?php

    try {

        $optionSearchUser = isset($_POST["optionSearchUser"]) ? $_POST["optionSearchUser"] : "";
        $optionOrderUser = isset($_POST["optionOrderUser"]) ? $_POST["optionOrderUser"] : "";
        $valorUser = isset($_POST["valorUser"]) ? $_POST["valorUser"] : "";

        $sql = "";

        if ($optionSearchUser != "") {
            if ($valorUser == "") {

                $sql = ("SELECT * FROM professor ORDER BY $optionOrderUser;");
            } elseif ($optionSearchUser == "materia") {
                $sql = ("SELECT * FROM professor WHERE $optionSearchUser LIKE '$valorUser%' ;");
            } else {
                $sql = ("SELECT * FROM professor WHERE $optionSearchUser LIKE '$valorUser%' ORDER BY $optionOrderUser;");
            }
        } else {
            $sql = ("SELECT * FROM professor;");
        }
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query($sql);
        echo "<br><table><tr><th>Código do Professor</th><th>Nome do Professor</th><th>Matéria do Professor</th><th>Alterar Professor</th><th>Excluir Professor</th></tr>";
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <tr>
                <td><?php echo $linha['codigo']; ?></td>
                <td><?php echo $linha['nome']; ?></td>
                <td><?php echo $linha['materia']; ?></td>
                <td><a href='cadprofessor.php?acao=editar&codigo=<?php echo $linha['codigo']; ?>'><img class="icon" src="img/edit.png" alt=""></a></td>
                <td><a href="javascript:excluirRegistro('acaoprofessor.php?acao=excluir&codigo=<?php echo $linha['codigo']; ?>')"><img class="icon" src="img/delete.png" alt=""></a></td>
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