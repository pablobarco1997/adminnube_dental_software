CREATE TABLE `tab_pagos_independ_pacientes_det` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `feche_create` datetime DEFAULT NULL,
  `fk_paciente` int(11) DEFAULT '0',
  `fk_usuario` int(11) DEFAULT '0',
  `fecha_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fk_plantram_cab` int(11) DEFAULT '0',
  `fk_plantram_det` int(11) DEFAULT '0',
  `fk_prestacion` int(11) DEFAULT '0',
  `fk_tipopago` int(11) DEFAULT '0',
  `amount` double DEFAULT '0',
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

ALTER TABLE `tab_pagos_independ_pacientes_det`
ADD COLUMN `fk_pago_cab` INT(11) NULL DEFAULT 0 AFTER `amount`
;
