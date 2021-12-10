<!DOCTYPE html>
<?php
$title = "Cadastro de Disciplina";
include 'connect/connect.php';
include 'acaodisciplinamaster.php';
$acao = '';
$codigo = '';
$dados = array();
if (isset($_GET["acao"])) {
    $acao = $_GET["acao"];
}

if ($acao == "editar") {
    if (isset($_GET["codigo"])) {
        $dados = carregaBDParaVetor($codigo);
        $codigo = $dados["codigo"];
    }
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel=stylesheet href='css/jquery-calendario.css' />
    <link rel=stylesheet href='css/calendario.css' />
    <link rel=stylesheet href='css/estilo.css' />
    <script src="js/jquery.maskedinput.js"></script>
    <script src='js/calendario.js'></script>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script>
        jQuery(function($) {
            $("#dataVencimento").mask("99/99/9999");
            $("#dataPagamento").mask("99/99/9999");
        });

        function excluirRegistro(url) {
            if (confirm("Excluir disciplina?"))
                location.href = url;
        }
    </script>
</head>

<body>
    <?php include 'menu.php'; ?>
    <form action="acaodisciplinamaster.php" id="form" method="post">
        <fieldset>
            <legend><?php echo $title; ?></legend>
            Código
            <input type="text" name="codigo" id="codigo" size="3" value="<?php if ($acao == "editar") echo $dados['codigo'];else echo "0"; ?>" readonly>
                                                                                                                            

            Nome da Disciplina
            <input type='text' size='11' name='name' id='name' value="<?php if ($acao == "editar") echo $dados['nome']; ?>"><br>
            


            <label for="">Nome do Professor</label>
            <select name="professor" id="professor">
                <?php
                $sql = "SELECT * FROM disciplina, professor WHERE disciplina.professor_codigo = professor.codigo AND disciplina.codigo = 1;";
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
            <label for="">Nome do Turma</label>
            <select name="turma" id="turma">
                <?php
                $sql = "SELECT * FROM turma;";
                #$pdo = Conexao::getInstance();
                #$consulta = $pdo->query($sql);
                $result = mysqli_query($conexao, $sql);
                #while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option value="' . $row['codigo'] . '"';
                    if ($acao == "editar" && $dados['turma'] == $row['codigo'])
                        echo ' selected';
                    echo '>' . $row['nome'] . '</option>';
                }
                ?>
            </select>
            <br><br>
            <button name="acao" value="addAluno" id="acao" type="submit">Salvar</button>
            <a href="alistardisciplinamaster.php">Consultar</a>

            <br><br>
            <?php if ($acao == "editar") { ?>

                <table width="100%"   border="1" align="left" id='painel'>
                
                    <?php
                    $sql = "SELECT aluno.codigo AS codigo_aluno, disciplina.codigo, aluno.nome as anome, aluno.idade, disciplina.nome, disciplina.professor_codigo AS professor, disciplina.turma_codigo AS turma FROM aluno, aluno_has_disciplina, disciplina LEFT JOIN professor ON disciplina.professor_codigo = professor.codigo LEFT JOIN turma ON disciplina.turma_codigo = turma.codigo
                        WHERE disciplina.codigo = $codigo
                        AND aluno_has_disciplina.disciplina_codigo = disciplina.codigo AND aluno.codigo = aluno_has_disciplina.aluno_codigo;";
                    $result = mysqli_query($conexao, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td align="center"><?php echo $row['codigo_aluno']; ?></td>
                            <td width="400"><?php echo $row['anome']; ?></td>
                            <td><?php echo $row['idade']; ?></td>
                            <td><a href="javascript:excluirRegistro('acaodisciplinamaster.php?acao=excluirAluno&aluno=<?php echo $row['codigo_aluno'];?>&disciplina=<?php echo $codigo;?>')"><img border="0" src="img/form/delete.png" alt="Excluir"></a></td>
                        </tr>
                    <?php }
                    ?>
                </table>
                        <tr>
                            <td width="400" align="center"><b>Nome|</b></td>
                            <td width="400" align="center"><b>Idade</b></td>
                            <td width="20" ></td>
                        </tr>
                </tr>
                <tr>
                    <td width="90" align="center">
                        <select name="aluno" id="aluno">
                            <?php
                            $sql = "SELECT * FROM aluno";
                            echo $sql;
                            $result = mysqli_query($conexao,$sql);
                            while ($row = mysqli_fetch_array($result)) {      
                                ?>
                                <option value="<?php echo $row[0];?>">
                                    <?php echo $row[1]." | ".$row[2];?></option>
                                    <?php } ?>
                                </select>
                            </td>

                    </tr>
                </table>
                    <tr>
                        <?php 
                        ?>
                           
                        </td>
                        <td width="120" align="right">
                            <button name="acao" id="acao" value="addAluno" type="submit" onclick="return validaAddProd();">
                                <img src="img/form/add.png" alt="Adicionar">Adicionar Aluno
                            </button><br><br>
                        </td>
                    </tr>
                </table>


                <br><br>
                
            <?php } ?>
        </fieldset>
    </form>
</body>

</html>