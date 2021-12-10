-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema projetopoo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema projetopoo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `projetopoo` DEFAULT CHARACTER SET utf8 ;
USE `projetopoo` ;

-- -----------------------------------------------------
-- Table `projetopoo`.`aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`aluno` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `idade` INT NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
AUTO_INCREMENT = 32
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`professor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`professor` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `materia` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`turma` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `numeroAlunos` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB
AUTO_INCREMENT = 28
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`disciplina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`disciplina` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL DEFAULT NULL,
  `professor_codigo` INT NOT NULL,
  `turma_codigo` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_disciplina_professor_idx` (`professor_codigo` ASC),
  INDEX `fk_disciplina_turma1_idx` (`turma_codigo` ASC),
  CONSTRAINT `fk_disciplina_professor`
    FOREIGN KEY (`professor_codigo`)
    REFERENCES `projetopoo`.`professor` (`codigo`),
  CONSTRAINT `fk_disciplina_turma1`
    FOREIGN KEY (`turma_codigo`)
    REFERENCES `projetopoo`.`turma` (`codigo`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`aluno_has_disciplina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`aluno_has_disciplina` (
  `aluno_codigo` INT NOT NULL,
  `disciplina_codigo` INT NOT NULL,
  PRIMARY KEY (`aluno_codigo`, `disciplina_codigo`),
  INDEX `fk_aluno_has_disciplina_disciplina1_idx` (`disciplina_codigo` ASC),
  INDEX `fk_aluno_has_disciplina_aluno1_idx` (`aluno_codigo` ASC),
  CONSTRAINT `fk_aluno_has_disciplina_aluno1`
    FOREIGN KEY (`aluno_codigo`)
    REFERENCES `projetopoo`.`aluno` (`codigo`),
  CONSTRAINT `fk_aluno_has_disciplina_disciplina1`
    FOREIGN KEY (`disciplina_codigo`)
    REFERENCES `projetopoo`.`disciplina` (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`aluno_has_turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`aluno_has_turma` (
  `aluno_codigo` INT NOT NULL,
  `turma_codigo` INT NOT NULL,
  PRIMARY KEY (`aluno_codigo`, `turma_codigo`),
  INDEX `fk_aluno_has_turma_turma1_idx` (`turma_codigo` ASC),
  INDEX `fk_aluno_has_turma_aluno1_idx` (`aluno_codigo` ASC),
  CONSTRAINT `fk_aluno_has_turma_aluno1`
    FOREIGN KEY (`aluno_codigo`)
    REFERENCES `projetopoo`.`aluno` (`codigo`),
  CONSTRAINT `fk_aluno_has_turma_turma1`
    FOREIGN KEY (`turma_codigo`)
    REFERENCES `projetopoo`.`turma` (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


-- -----------------------------------------------------
-- Table `projetopoo`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetopoo`.`endereco` (
  `cidade` VARCHAR(45) NULL DEFAULT NULL,
  `bairro` VARCHAR(45) NULL DEFAULT NULL,
  `rua` VARCHAR(45) NULL DEFAULT NULL,
  `codigo` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `codigo_idx` (`codigo` ASC),
  CONSTRAINT `codigo`
    FOREIGN KEY (`codigo`)
    REFERENCES `projetopoo`.`aluno` (`codigo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb3;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
