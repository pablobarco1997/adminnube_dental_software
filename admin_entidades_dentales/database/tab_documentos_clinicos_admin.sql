CREATE TABLE `tab_documentos_clinicos_admin` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(75) DEFAULT NULL,
  `fk_document_clinico` int(11) DEFAULT 0,
  `fk_usuario_logeado` int(11) DEFAULT 0,
  `fk_document_det` varchar(45) DEFAULT '0',
  `tms` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fk_paciente` int(11) DEFAULT 0,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;
