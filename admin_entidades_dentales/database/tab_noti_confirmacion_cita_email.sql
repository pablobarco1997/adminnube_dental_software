CREATE TABLE `tab_noti_confirmacion_cita_email` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_paciente` int(11) DEFAULT '0',
  `fk_cita` int(11) DEFAULT '0',
  `date_confirm` datetime DEFAULT NULL,
  `estado` varchar(55) DEFAULT NULL,
  `key` varchar(13) NOT NULL,
  `fecha_cita` datetime NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
;