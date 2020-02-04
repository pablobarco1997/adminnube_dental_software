CREATE TABLE `tab_conf_prestaciones` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) DEFAULT NULL,
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_user` int(11) DEFAULT '0',
  `fk_convenio` int(11) DEFAULT '0',
  `fk_categoria` int(11) DEFAULT '0',
  `fk_laboratorio` int(11) DEFAULT '0',
  `valor` double DEFAULT '0',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;