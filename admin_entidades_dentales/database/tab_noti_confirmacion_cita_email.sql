CREATE TABLE `tab_noti_confirmacion_cita_email` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_paciente` int(11) DEFAULT '0',
  `fk_cita` int(11) DEFAULT '0',
  `date_confirm` datetime DEFAULT NULL,
  `estado` varchar(55) DEFAULT NULL,
  `key` varchar(13) DEFAULT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `comment` varchar(2500) DEFAULT NULL,
  `action` varchar(30) DEFAULT NULL,
  `noti_aceptar` int(11) DEFAULT '0' COMMENT 'este campo sirve para notificar al doctor que un paciente esta ya confirmo su email enviado si asistira o no - el campo en 0 significa que la notificacion esta Activa  y  1 significa que la notificacion esta desactivada',
  `fk_noti_email` int(11) DEFAULT '0' COMMENT 'este campo sirve para relacionar el campo notificaciones de email y confirmar notificaciones email',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;