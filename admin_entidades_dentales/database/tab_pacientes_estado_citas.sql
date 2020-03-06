CREATE TABLE `tab_pacientes_estado_citas` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(75) DEFAULT NULL,
  `color` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;
INSERT INTO `tab_pacientes_estado_citas` VALUES (1,'Notificar por email','#F9EBEA'),(2,'No confimado','#F5EEF8'),(3,'Confirmado por telefono','#EAF2F8'),(4,'En sala de espera','#E8F8F5'),(5,'Atendiéndose','#E8F8F5'),(6,'Atendido','#FEF9E7'),(7,'No asiste','#FAE5D3'),(8,'Confirmar por whatsapp','#EDBB99'),(9,'Cancelada','#EAECEE')
;
INSERT INTO `tab_pacientes_estado_citas` (`text`, `color`) VALUES ('confirmado e-mail x paciente', '#CCFF99')
;
