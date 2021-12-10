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
        $stmt = $pdo->prepare('INSERT INTO professor (nome, materia) VALUES(:nome, :materia)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':materia', $materia, PDO::PARAM_STR);
        $nome = $dados['nome'];
        $materia = $dados['materia'];
        $stmt->execute();
        header("location:cadprofessor.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE professor SET nome = :nome,materia = :materia WHERE codigo = :codigo');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':materia', $materia, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $nome = $dados['nome'];
        $materia = $dados['materia'];
        $codigo = $dados['codigo'];
        $stmt->execute();
        header("location:alistarprofessor.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from professor WHERE codigo = :codigo');
        $stmt->bindParam(':codigo', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistarprofessor.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM professor WHERE codigo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['codigo'] = $linha['codigo'];
            $dados['nome'] = $linha['nome'];
            $dados['materia'] = $linha['materia'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['codigo'] = $_POST['codigo'];
        $dados['nome'] = $_POST['nome'];
        $dados['materia'] = $_POST['materia'];
        return $dados;
    }

?>