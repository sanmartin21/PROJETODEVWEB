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
        $nome = $dados['nome'];
        $idade = $dados['idade'];
        $cidade = $dados['cidade'];
        $bairro = $dados['bairro'];
        $rua = $dados['rua'];
        
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('INSERT INTO aluno (nome, idade) VALUES(:nome, :idade)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->execute();
        $codigo =$pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO endereco (cidade, bairro, rua, codigo) VALUES(:cidade, :bairro, :rua, :codigo)');
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:cadaluno1p1.php");
        
    }
    function editar($codigo){
        $dados = dadosForm();
        var_dump($dados);
        $nome = $dados['nome'];
        $idade = $dados['idade'];
        $cidade = $dados['cidade'];
        $bairro = $dados['bairro'];
        $rua = $dados['rua'];
        $codigo = $dados['codigo'];
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('UPDATE aluno SET nome = :nome, idade = :idade WHERE codigo = :codigo');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $pdo->prepare('UPDATE endereco SET cidade = :cidade, bairro = :bairro, rua = :rua WHERE codigo = :codigo');
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':rua', $rua, PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $stmt->execute();
        header("location:alistaraluno1p1.php");
    }

    function excluir($codigo){
        $pdo = Conexao::getInstance();
        $stmt = $pdo->prepare('DELETE from aluno WHERE codigo = :codigo');
        $stmt->bindParam(':codigo', $codigoD, PDO::PARAM_INT);
        $codigoD = $codigo;
        $stmt->execute();
        header("location:alistaraluno1p1.php");
        
        //echo "Excluir".$codigo;

    }


    // Busca um item pelo código no BD
    function buscarDados($codigo){
        $pdo = Conexao::getInstance();
        $consulta = $pdo->query("SELECT aluno.codigo, aluno.nome, aluno.idade, endereco.cidade, endereco.bairro, endereco.rua FROM aluno LEFT JOIN endereco ON endereco.codigo = aluno.codigo WHERE aluno.codigo = $codigo");
        $dados = array();
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            $dados['codigo'] = $linha['codigo'];
            $dados['nome'] = $linha['nome'];
            $dados['idade'] = $linha['idade'];
            $dados['cidade'] = $linha['cidade'];
            $dados['bairro'] = $linha['bairro'];
            $dados['rua'] = $linha['rua'];
        }
        return $dados;
    }

    // Busca as informações digitadas no form
    function dadosForm(){
        $dados = array();
        $dados['codigo'] = $_POST['codigo'];
        $dados['nome'] = $_POST['nome'];
        $dados['idade'] = $_POST['idade'];
        $dados['cidade'] = $_POST['cidade'];
        $dados['bairro'] = $_POST['bairro'];
        $dados['rua'] = $_POST['rua'];
        return $dados;
    }

?>