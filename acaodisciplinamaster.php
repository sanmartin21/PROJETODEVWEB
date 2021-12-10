<?php
	header('Content-Type: text/html; charset=UTF-8');
	include 'connect/connect.php';
	include 'conf/Conexao.php';
	
	$acao = '';
	if (isset($_GET["acao"]))
		  $acao = $_GET["acao"];

	if ($acao == "excluirAluno"){
		$disciplina = $_GET['disciplina'];
		$aluno = $_GET['aluno'];
		excluirAluno($disciplina,$aluno);
	}else if ($acao == "excluir"){
		$codigo = 0;
		if (isset($_GET["codigo"])){
		  	$codigo = $_GET["codigo"];
			excluir($codigo);
		}
	}else if (isset($_POST["acao"])){
			$acao = $_POST["acao"];
			echo $acao;
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

	function excluirAluno($disciplina,$aluno){
		$sql = "
			DELETE 
			  FROM {$GLOBALS['tb_aluno_has_disciplina']}
	         WHERE aluno_codigo = :aluno
		       AND disciplina_codigo = :disciplina;
		";

		$pdo = Conexao::getInstance();
		$stmt = $pdo->prepare($sql);
        $stmt->bindParam(':aluno', $aluno, PDO::PARAM_INT);
		$stmt->bindParam(':disciplina', $disciplina, PDO::PARAM_INT);
		$stmt->execute();

		header('location:caddisciplinamaster.php?acao=editar&codigo='.$disciplina);
	}

	function adicionarAluno($codigo,$aluno){
		$sql = 'INSERT INTO '.$GLOBALS['tb_aluno_has_disciplina'].
		       ' (disciplina_codigo, aluno_codigo)'. 
		       ' VALUES ('.$codigo.','.$aluno.')';
			//    echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$codigo = mysqli_insert_id($GLOBALS['conexao']);
		if ($result == 1)
			header('location:caddisciplinamaster.php?msg="si"&acao=editar&codigo='.$codigo);
		else
			header('location:caddisciplinamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function excluir($codigo){
		$sql = 'DELETE FROM '.$GLOBALS['tb_aluno_has_disciplina'].
		       ' WHERE disciplina_codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$sql = 'DELETE FROM '.$GLOBALS['tb_disciplina'].
		       ' WHERE codigo =  '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:alistardisciplinamaster.php');
		else
			header('location:alistardisciplinamaster.php');
	}

	function alterar($codigo){
		$vet = carregarTelaParaVetor();
		$sql = 'UPDATE '.$GLOBALS['tb_disciplina'].
		       ' SET nome = "'.$vet['nome'].
			   '", WHERE codigo = '.$codigo;
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		if ($result == 1)
			header('location:caddisciplinamaster.php?msg="sa"&acao=editar&codigo='.$codigo);
		else
			header('location:caddisciplinamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function inserir(){	
		$vet = carregarTelaParaVetor();		
		$sql = 'INSERT INTO '.$GLOBALS['tb_disciplina'].
		       ' (nome, professor_codigo, turma_codigo)'. 
		       ' VALUES ("'.$vet['nome'].
		       ','.$vet['professor'].'
               ,'.$vet['turma'].');';
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$codigo = mysqli_insert_id($GLOBALS['conexao']);
		if ($result == 1)
			header('location:caddisciplinamaster.php?msg="si"&acao=editar&codigo='.$codigo);
		else
			header('location:caddisciplinamaster.php?msg="er"&acao=editar&codigo='.$codigo);
	}
	
	function carregarTelaParaVetor(){
		include 'util/util.php';
		$vet = array();
		$vet['nome'] = $_POST["nome"];
		$vet['professor'] = $_POST["professor"];
        $vet['turma'] = $_POST["turma"];
		return $vet;		
	}	
		
	function carregaBDParaVetor($codigo){
		$sql = 'SELECT * FROM '.$GLOBALS['tb_disciplina'];
		$result = mysqli_query($GLOBALS['conexao'],$sql);
		$dados = array();
		while ($row = mysqli_fetch_array($result)){
			$dados['codigo'] = $row['codigo'];
			$dados['nome'] = $row['nome'];
			$dados['professor'] = $row['professor_codigo'];
            $dados['turma'] = $row['turma_codigo'];
		}   
		return $dados;    		
	}
?>	