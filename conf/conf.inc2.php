<?php
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('America/Sao_Paulo');
	
	// Banco de Dados para configuração
	$url = "127.0.0.1";     // IP do host
	$dbname="projetopoo";          // Nome do database
	$usuario="root";        // Usuário do database
	$password="848682";           // Senha do database
	
	// Tabelas do Banco de Dados
	$tb_aluno = "aluno";
	$tb_turma = "turma";
	$tb_professor = "professor";
    $tb_endereco = "endereco";
    $tb_disciplina = "disciplina";
	$tb_aluno_has_disciplina = "aluno_has_disciplina";
    $tb_aluno_has_turma = "aluno_has_turma";
?>
