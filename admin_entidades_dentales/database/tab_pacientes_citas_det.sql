CREATE TABLE `tab_pacientes_citas_det` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `fk_pacient_cita_cab` int(11) DEFAULT '0',
  `fk_estado_paciente_cita` int(11) DEFAULT '0',
  `fk_especialidad` int(11) DEFAULT '0',
  `fk_doc` int(11) DEFAULT '0',
  `recurso` varchar(55) DEFAULT '0',
  `duracion` int(11) DEFAULT '0',
  `fecha_cita` datetime DEFAULT NULL,
  `hora_cita` time DEFAULT '00:00:00',
  `type` varchar(45) DEFAULT NULL,
  `hora_inicio` time DEFAULT '00:00:00',
  `hora_fin` time DEFAULT '00:00:00',
  `tms` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` varchar(45) DEFAULT 'A',
  `comentario_adicional` varchar(700) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

ALTER TABLE `tab_pacientes_citas_det`
ADD COLUMN `fk_cita_email_noti` INT(11) NULL DEFAULT 0 AFTER `comentario_adicional`
;
