CREATE TABLE `tab_conf_convenio_desc` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_conv` varchar(200) DEFAULT NULL,
  `descrip` varchar(500) DEFAULT NULL,
  `valor` double DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;
