CREATE TABLE `tab_plan_tratamiento_det` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_plantratam_cab` int(11) DEFAULT '0',
  `fk_prestacion` int(11) DEFAULT '0',
  `fk_diente` int(11) DEFAULT '0',
  `json_caras` varchar(300) DEFAULT NULL,
  `sub_total` double DEFAULT '0',
  `desc_convenio` double DEFAULT '0',
  `desc_adicional` double DEFAULT '0',
  `total` double DEFAULT '0',
  `estadodet` varchar(5) DEFAULT 'A',
  `abono` double DEFAULT '0',
  `cantidad` double DEFAULT '1',
  `detencion` varchar(25) DEFAULT NULL,
  `fk_usuario` int(11) DEFAULT '0',
  `realizada_fk_dentista` int(11) DEFAULT '0',
  `evolucion_escrita` varchar(2500) DEFAULT NULL,
  `fk_estado_odontograma` int(11) DEFAULT '0',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

-- CAMPO AGREGADO ESTADO DE PAGO PLAN DE TRATAMIENTO DETALLE - ESTADO DE PAGO X PRESTACION
ALTER TABLE `tab_plan_tratamiento_det` 
ADD COLUMN `estado_pay` VARCHAR(3) NULL DEFAULT 'PE' AFTER `fk_estado_odontograma`
;