CREATE TABLE `tab_plan_tratamiento_cab` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(100) DEFAULT NULL,
  `fk_doc` int(11) DEFAULT '0',
  `fk_sucursal` int(11) DEFAULT '0',
  `fk_convenio` int(11) DEFAULT '0',
  `fk_paciente` int(11) DEFAULT '0',
  `abonos` double DEFAULT '0',
  `estados_tratamiento` varchar(11) DEFAULT 'A',
  `evoluciones_porct` int(11) DEFAULT '0',
  `ultima_cita` varchar(45) DEFAULT NULL,
  `fk_cita` int(11) DEFAULT '0',
  `detencion` varchar(45) DEFAULT NULL,
  `situacion` varchar(45) DEFAULT NULL,
  `observacion` varchar(700) DEFAULT NULL,
  `edit_name` varchar(600) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;