CREATE TABLE `tab_notificacion_email` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `asunto` varchar(500) DEFAULT NULL,
  `from` varchar(70) DEFAULT NULL,
  `to` varchar(70) DEFAULT NULL,
  `subject` varchar(70) DEFAULT NULL,
  `message` varchar(70) DEFAULT NULL,
  `estado` varchar(5) DEFAULT NULL,
  `fk_paciente` int(11) DEFAULT '0',
  `fk_cita` int(11) DEFAULT '0',
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;