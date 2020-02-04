CREATE TABLE `tab_login_users` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(55) DEFAULT NULL,
  `passwords` blob,
  `fk_doc` int(11) DEFAULT NULL,
  `permisos` varchar(150) DEFAULT NULL,
  `tipo_usuario` varchar(45) DEFAULT '2',
  `passwor_abc` varchar(1000) DEFAULT NULL,
  `estado` varchar(5) DEFAULT 'A',
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;