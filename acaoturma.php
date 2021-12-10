<?php

    include_once "conf/default.inc.php";
    require_once "conf/Conexao.php";

    // Se foi enviado via GET para acao entra aqui
    $acao = isset($_GET['acao']) ? $_GET['acao'] : "";
    if ($acao == "excluir"){
        $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : 0;
        excluir($codigo);
    }

    // Se foi enviado via POST para acao entra aqui
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "";
    if ($acao == "salvar"){
        $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : "";
        if ($codigo == 0)
            inserir($codigo);
        else
            editar($codigo);
    }

    // Métodos para cada operação
    function inserir($codigo){
        $dados = dadosForm();
        //var_dump($dados);
        
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO turma (nome, numeroAlunos) VALUES(:nome, :numeroAlunos)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':numeroAlunos', $numeroAlunos, PDO::PARAM_STR);
        $nome = $dados['nome'];
        $numeroAlunos = $dados['numeroAlunos'];
        $stmt->execute();
        header("location:cadturma.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE turma SET nome = :nome,numeroAlunos = :numeroAlunos WHERE codigo = :codigo');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':numeroAlunos', $numeroAlunos, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $nome = $dados['nome'];
        $numeroAlunos = $dados['numeroAlunos'];
        $codigo = $dados['codigo'];
        $stmt->execute();
        header("location:alistarturma.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from turma WHERE codigo = :codigo');
        $stmt->bindParam(':codigo', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistarturma.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM turma WHERE codigo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['codigo'] = $linha['codigo'];
            $dados['nome'] = $linha['nome'];
            $dados['numeroAlunos'] = $linha['numeroAlunos'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['codigo'] = $_POST['codigo'];
        $dados['nome'] = $_POST['nome'];
        $dados['numeroAlunos'] = $_POST['numeroAlunos'];
        return $dados;
    }

?>