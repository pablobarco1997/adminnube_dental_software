CREATE TABLE `tab_odontograma_estados_piezas` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) DEFAULT NULL,
  `image_status` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;
INSERT INTO `tab_odontograma_estados_piezas` VALUES (1,'lesion de caries',NULL),(2,'infeccion de caries',NULL),(3,'fractura',NULL),(4,'indicacion de extraccion',NULL),(5,'ausente',NULL),(6,'restauracion',NULL),(7,'endodoncia',NULL),(8,'corona',NULL),(9,'implante',NULL),(10,'perno muñon',NULL)
;
