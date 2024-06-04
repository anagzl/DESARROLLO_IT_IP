-- MySQL Workbench Synchronization
-- Generated: 2022-05-02 09:12
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Administrador

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `bitacora_servicio_cliente_ip` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`Usuario` (
  `idUsuario` VARCHAR(15) NOT NULL,
  `primerNombre` VARCHAR(45) NULL DEFAULT NULL,
  `segundoNombre` VARCHAR(45) NULL DEFAULT NULL,
  `primerApellido` VARCHAR(45) NULL DEFAULT NULL,
  `segundoApellido` VARCHAR(45) NULL DEFAULT NULL,
  `numeroCelular` VARCHAR(45) NULL DEFAULT NULL,
  `numeroTelefonoFijo` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `Genero_idGenero` INT(11) NOT NULL,
  `TipoCliente_idTipoCliente` INT(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_Genero1_idx` (`Genero_idGenero` ASC) ,
  INDEX `fk_Usuario_TipoCliente1_idx` (`TipoCliente_idTipoCliente` ASC) ,
  CONSTRAINT `fk_Usuario_Genero1`
    FOREIGN KEY (`Genero_idGenero`)
    REFERENCES `bitacora_servicio_cliente_ip`.`Genero` (`idGenero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_TipoCliente1`
    FOREIGN KEY (`TipoCliente_idTipoCliente`)
    REFERENCES `bitacora_servicio_cliente_ip`.`TipoCliente` (`idTipoCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`TipoCliente` (
  `idTipoCliente` INT(11) NOT NULL,
  `nombreTipoClientecol` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idTipoCliente`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`Genero` (
  `idGenero` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `siglas` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idGenero`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`Tramite` (
  `idTramite` INT(11) NOT NULL,
  `nombreTramite` VARCHAR(45) NULL DEFAULT NULL,
  `descripcionTramite` VARCHAR(1000) NULL DEFAULT NULL,
  PRIMARY KEY (`idTramite`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`Bitacora` (
  `idBitacora` INT(11) NOT NULL,
  `Usuario_idUsuario` VARCHAR(15) NOT NULL,
  `Instituciones_idInstituciones` INT(11) NOT NULL,
  `Tramite_idTramite` INT(11) NOT NULL,
  `fecha` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `Observacion` VARCHAR(1000) NULL DEFAULT NULL,
  PRIMARY KEY (`idBitacora`),
  INDEX `fk_Bitacora_Usuario_idx` (`Usuario_idUsuario` ASC) ,
  INDEX `fk_Bitacora_Tramite1_idx` (`Tramite_idTramite` ASC) ,
  INDEX `fk_Bitacora_Instituciones1_idx` (`Instituciones_idInstituciones` ASC) ,
  CONSTRAINT `fk_Bitacora_Usuario`
    FOREIGN KEY (`Usuario_idUsuario`)
    REFERENCES `bitacora_servicio_cliente_ip`.`Usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bitacora_Tramite1`
    FOREIGN KEY (`Tramite_idTramite`)
    REFERENCES `bitacora_servicio_cliente_ip`.`Tramite` (`idTramite`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bitacora_Instituciones1`
    FOREIGN KEY (`Instituciones_idInstituciones`)
    REFERENCES `bitacora_servicio_cliente_ip`.`Institucion` (`idInstituciones`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`TipoInstitucion` (
  `idTipoInstitucion` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idTipoInstitucion`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `bitacora_servicio_cliente_ip`.`Institucion` (
  `idInstituciones` INT(11) NOT NULL,
  `nombreInstitucion` VARCHAR(45) NULL DEFAULT NULL,
  `siglas` VARCHAR(45) NULL DEFAULT NULL,
  `TipoInstitucion_idTipoInstitucion` INT(11) NOT NULL,
  PRIMARY KEY (`idInstituciones`),
  INDEX `fk_Instituciones_TipoInstitucion1_idx` (`TipoInstitucion_idTipoInstitucion` ASC) ,
  CONSTRAINT `fk_Instituciones_TipoInstitucion1`
    FOREIGN KEY (`TipoInstitucion_idTipoInstitucion`)
    REFERENCES `bitacora_servicio_cliente_ip`.`TipoInstitucion` (`idTipoInstitucion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
