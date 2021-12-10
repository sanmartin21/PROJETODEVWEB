<?php
	header('Content-Type: text/html; charset=UTF-8');
	include 'connect/connect.php';
	include 'conf/Conexao.php';
	
	$acao = '';
	if (isset($_GET["acao"]))
		  $acao = $_GET["acao"];

	if ($acao == "excluirAluno"){
		$turma = $_GET['turma'];
		$aluno = $_GET['aluno'];
		excluirAluno($turma,$aluno);
	}else if ($acao == "excluir"){
		$codigo = 0;
		if (isset($_GET["codigo"])){
		  	$codigo = $_GET["codigo"];
			excluir($codigo);
		}
	}else if (isset($_POST["acao"])){
			$acao = $_POST["acao"];
			if ($acao == "salvar"){
				$codigo = 0;
				if (isset($_POST["codigo"])){
					$codigo = $_POST["codigo"];
					if ($codigo == 0)
					inserir();
					else
					alterar($codigo);
				}
			}
			else if($acao == "addAluno"){
				$aluno = $_POST['aluno'];
				$codigo = $_POST['codigo'];
				adicionarAluno($codigo,$aluno);
			}
	}

	function excluirAluno($turma,$aluno){
		$sql = "
			DELETE 
			  FROM {$GLOBALS['tb_aluno_has_turma']}
	         WHERE aluno_codigo = :aluno
		       AND turma_codigo = :turma;
		";

		$pdo = Conexao::getInstance();
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(':aluno', $aluno, PDO::PARAM_INT);
		$stmt->bindParam(':turma', $turma, PDO::PARAM_INT);
		$stmt->execute();

		header('location:cadturmamaster.php?acao=editar&codigo='.$turma);
	}
	
	function adicionarAluno($codigo,$aluno){
		$sql = 'INSERT INTO '.$GLOBALS['tb_aluno_has_turma'].
		       ' (turma_codigo, aluno_codigo)'. 
		       ' VALUES ('.$codigo.','.$aluno.')';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:cadturmamaster.php?msg="si"&acao=editar&codigo='.$codigo);
		else
			header('location:cadturmamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function excluir($codigo){
		$sql = 'DELETE FROM '.$GLOBALS['tb_aluno_has_turma'].
		       ' WHERE turma_codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$sql = 'DELETE FROM '.$GLOBALS['tb_turma'].
		       ' WHERE codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:alistarturmamaster.php');
		else
			header('location:alistarturmamaster.php');
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_turma'].
		       ' SET nome = "'.$vet['nome'].
			   ' SET numeroAlunos = "'.$vet['numeroAlunos'].
		       '" WHERE codigo = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:cadturmamaster.php?msg="sa"&acao=editar&codigo='.$codigo);
		else
			header('location:cadturmamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();		
		$sql = 'INSERT INTO '.$GLOBALS['tb_turma'].
		       ' (nome, numeroAlunos)'. 
		       ' VALUES ("'.$vet['nome'].
		       '","'.$vet['numeroAlunos'].'")';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$codigo = mysqli_insert_id($GLOBALS['conexao']);
		if ($result == 1)
			header('location:cadturmamaster.php?msg="si"&acao=editar&codigo='.$codigo);
		else
			header('location:cadturmamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function carregarTelaParaVetor(){
		include 'util/util.php';
		$vet = array();
		$vet['nome'] = $_POST["nome"];
		$vet['numeroAlunos'] = $_POST["numeroAlunos"];
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_turma'].
		       ' WHERE codigo = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['codigo'] = $row['codigo'];
			$dados['nome'] = $row['nome'];
			$dados['numeroAlunos'] = $row['numeroAlunos'];
		}   
		return $dados;    		
	}
?>	