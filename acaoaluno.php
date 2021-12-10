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
        $stmt = $pdo->prepare('INSERT INTO aluno (nome, idade) VALUES(:nome, :idade)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $nome = $dados['nome'];
        $idade = $dados['idade'];
        $stmt->execute();
        header("location:cadaluno.php");
        
    }

    function editar($codigo){
        $dados = dadosForm();
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE aluno SET nome = :nome,idade = :idade WHERE codigo = :codigo');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $nome = $dados['nome'];
        $idade = $dados['idade'];
        $codigo = $dados['codigo'];
        $stmt->execute();
        header("location:alistaraluno.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from aluno WHERE codigo = :codigo');
        $stmt->bindParam(':codigo', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistaraluno.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT * FROM aluno WHERE codigo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['codigo'] = $linha['codigo'];
            $dados['nome'] = $linha['nome'];
            $dados['idade'] = $linha['idade'];
        }
        //var_dump($dados);
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['codigo'] = $_POST['codigo'];
        $dados['nome'] = $_POST['nome'];
        $dados['idade'] = $_POST['idade'];
        return $dados;
    }

?>