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

ALTER TABLE `tab_noti_confirmacion_cita_email`
ADD COLUMN `comment` VARCHAR(2500) NULL DEFAULT NULL AFTER `fecha_cita`
;

ALTER TABLE `tab_noti_confirmacion_cita_email`
ADD COLUMN `action` VARCHAR(30) NULL DEFAULT NULL AFTER `comment`
;

ALTER TABLE `tab_noti_confirmacion_cita_email`
ADD COLUMN `noti_aceptar` INT(11) NULL DEFAULT 0 COMMENT 'este campo sirve para notificar al doctor que un paciente esta ya confirmo su email enviado si asistira o no - el campo en 0 significa que la notificacion esta Activa  y  1 significa que la notificacion esta desactivada' AFTER `action`
;


