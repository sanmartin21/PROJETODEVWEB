<!DOCTYPE html>
<?php 
    $title = "Cadastro de Vendas";
    include 'connect/connect.php';
    include 'acaoturmamaster.php';
    $acao = '';
    $codigo = '';
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
    <link rel=stylesheet href='css/jquery-calendario.css'/>
    <link rel=stylesheet href='css/calendario.css'/>
    <link rel=stylesheet href='css/estilo.css'/>  
    <script src="js/jquery.maskedinput.js"></script>
    <script src='js/calendario.js'></script>      
    <script src="js/jquery-2.1.4.min.js"></script>
    <script>
    jQuery(function($){
        $("#dataVencimento").mask("99/99/9999");
        $("#dataPagamento").mask("99/99/9999");
    });

    function excluirRegistro(url) {
        if(confirm("Excluir aluno?"))
        location.href = url;
    }
    </script>
    
</head>
<body>
    <?php include 'menu.php'; ?>
    <form action="acaoturmamaster.php" id="form" method="post">
        <fieldset>
            <legend><?php echo $title; ?></legend>
            Código
            <input type="text" name="codigo" id="codigo" size="3" value="<?php if ($acao == "editar") echo $dados['codigo']; else echo "0";?>" readonly>
            
            Nome da Turma
            <input type='text' size='11' name='nome' id='nome' value="<?php if ($acao == "editar") echo $dados['nome'];?>"/>

            Número de Alunos
            <input type='text' size='11' name='numeroAlunos' id='numeroAlunos' value="<?php if ($acao == "editar") echo $dados['numeroAlunos'];?>"/>

            <br><br>
            <button name="acao" value="salvar" id="acao" 
            type="submit">Salvar</button>
            <a href="alistarturmamaster.php">Consultar</a>    

            <br><br>
            <?php if ($acao == "editar"){ ?>

            <table width="100%"   border="1" align="left" id='painel'>
                <tr><tr>
                    <td width="90" align="center"><b>Nome|Idade</b></td>
                    <td width="120" align="right"><b></b></td>
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
                            <td width="120" align="right">
                                <button name="acao" id="acao" value="addAluno"  type="submit" onclick="return validaAddProd();">
                                    <img src="img/form/add.png" alt="Adicionar">Adicionar Aluno
                                </button><br><br>
                            </td>
                        </tr>
                    </table>


                    <br><br>

                    <table width="100%"   border="1" align="left" id='painel'>
                        <tr>
                            <td width="90" align="center"><b>Código</b></td>
                            <td width="400" ><b>Nome</b></td>
                            <td width="400" ><b>Idade</b></td>
                            <td width="20" ></td>
                        </tr>


                        
                        <?php 
                        $sql = "SELECT aluno.codigo AS codigo_aluno, turma.codigo, aluno.nome as anome, aluno.idade, turma.nome, turma.numeroAlunos FROM turma, aluno, aluno_has_turma
                        WHERE turma.codigo = $codigo
                        AND aluno_has_turma.turma_codigo = turma.codigo AND aluno.codigo = aluno_has_turma.aluno_codigo;";
                        $result = mysqli_query($conexao,$sql);
                        while ($row = mysqli_fetch_array($result))  {         
                            ?>
                            <tr>
                                <td align="center"><?php echo $row['codigo_aluno'];?></td>
                                <td width="400"><?php echo $row['anome'];?></td>
                                <td><?php echo $row['idade'];?></td>
                                <td><a href="javascript:excluirRegistro('acaoturmamaster.php?acao=excluirAluno&aluno=<?php echo $row['codigo_aluno'];?>&turma=<?php echo $codigo;?>')"><img border="0" src="img/form/delete.png" alt="Excluir"></a></td>
                            </tr>
                            <?php } 
                            ?>
                        </table> 
                        <table width="100%"   border="1" align="left" id='painel'>
                         <tr>

                        </tr>      
                    </table>
                    <?php } ?>
                </fieldset>
            </form>
        </body>
        </html>