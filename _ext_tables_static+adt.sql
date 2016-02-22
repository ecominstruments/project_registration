DROP TABLE IF EXISTS tx_projectregistration_domain_model_product;
CREATE TABLE tx_projectregistration_domain_model_product (
  uid int(11) NOT NULL AUTO_INCREMENT,
  pid int(11) NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL DEFAULT '',
  properties int(11) unsigned NOT NULL DEFAULT '0',
  sorting int(11) unsigned NOT NULL DEFAULT '0',
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (uid),
  KEY parent (pid)
);
INSERT INTO tx_projectregistration_domain_model_product VALUES (1, 1, 'i.roc® Ci70 -Ex', 1, 512, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (2, 1, 'i.roc® Ci70 -Ex RFID LF', 1, 768, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (3, 1, 'i.roc® Ci70 -Ex RFID HF', 1, 1024, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (4, 1, 'i.roc® Ci70 -Ex RFID UHF US', 1, 1280, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (5, 1, 'i.roc® Ci70 -Ex RFID UHF', 1, 1536, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (6, 1, 'i.roc® Ci70 -Ex 1D Barcode', 1, 1792, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (7, 1, 'i.roc® Ci70 -Ex 2D EX25', 1, 2048, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (8, 1, 'i.roc® Ci70 -Ex Combi Reader LF/ 1D', 1, 2304, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (9, 1, 'i.roc® Ci70 -Ex Combi Reader HF/ 1D', 1, 2560, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (10, 1, 'Getac V100-Ex2, Standard', 0, 2816, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (11, 1, 'Getac V100-Ex2, Premium', 0, 3072, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (12, 1, 'Z710-Ex Basic', 0, 3328, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (13, 1, 'Z710-Ex Basic 1D/2D Barcode', 0, 3584, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (14, 1, 'Z710-Ex Basic HF RFID', 0, 3840, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (15, 1, 'Z710-Ex Basic 1D/2D + HF RFID', 0, 4096, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (16, 1, 'Z710-Ex Premium', 0, 4352, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (17, 1, 'Z710-Ex Premium 1D/2D', 0, 4608, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (18, 1, 'Z710-Ex Premium HF RFID', 0, 4864, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (19, 1, 'Z710-Ex Premium 1D/2D + HF RFID', 0, 5120, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (20, 1, 'CK70 ATEX', 0, 5376, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (21, 1, 'CK71 ATEX', 0, 5632, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (22, 1, 'CN70A ATEX', 0, 5888, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (23, 1, 'CN70E ATEX', 0, 6144, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (24, 1, 'Tab-Ex® Zone 1', 1, 6400, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (25, 1, 'Tab-Ex® Division 1', 1, 6656, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (26, 1, 'Tab-Ex® Zone 2', 1, 6912, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (27, 1, 'Tab-Ex® Division 2', 1, 7168, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (28, 1, 'Smart-Ex® 01 EU no camera', 0, 7424, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (29, 1, 'Smart-Ex® 01 EU camera', 0, 7680, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (30, 1, 'Smart-Ex® 01 US no camera', 0, 7936, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (31, 1, 'Smart-Ex® 01 US camera', 0, 8192, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (32, 1, 'Smart-Ex® 201 EU no camera', 0, 8448, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (33, 1, 'Smart-Ex® 201 EU camera', 0, 8704, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (34, 1, 'Smart-Ex® 201 US camera', 0, 8960, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (35, 1, 'Smart-Ex® 201 US no camera', 0, 9216, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (36, 1, 'Ex-Handy 09 Zone 1 EU', 0, 9472, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (37, 1, 'Ex-Handy 09 Div 1 US', 0, 9728, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (38, 1, 'Ex-Handy 209 EU', 0, 9984, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (39, 1, 'Ex-Handy 209 US', 0, 10240, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_product VALUES (40, 1, 'others', 0, 10496, 0, 0, 0);


DROP TABLE IF EXISTS tx_projectregistration_domain_model_productproperty;
CREATE TABLE tx_projectregistration_domain_model_productproperty (
  uid int(11) NOT NULL AUTO_INCREMENT,
  pid int(11) NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL DEFAULT '',
  form_element_type int(11) unsigned NOT NULL DEFAULT '0',
  sorting int(11) unsigned NOT NULL DEFAULT '0',
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (uid),
  KEY parent (pid)
);
INSERT INTO tx_projectregistration_domain_model_productproperty VALUES (1, 1, 'WWAN', 0, 0, 0, 0, 0);
INSERT INTO tx_projectregistration_domain_model_productproperty VALUES (2, 1, 'LTE', 0, 0, 0, 0, 0);


DROP TABLE IF EXISTS tx_projectregistration_domain_model_productpropertyvalue;
CREATE TABLE tx_projectregistration_domain_model_productpropertyvalue (
  uid int(11) NOT NULL AUTO_INCREMENT,
  pid int(11) NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL DEFAULT '',
  sorting int(11) unsigned NOT NULL DEFAULT '0',
  tstamp int(11) unsigned NOT NULL DEFAULT '0',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  cruser_id int(11) unsigned NOT NULL DEFAULT '0',
  property int(11) unsigned DEFAULT '0',
  PRIMARY KEY (uid),
  KEY parent (pid)
);
INSERT INTO tx_projectregistration_domain_model_productpropertyvalue VALUES (1, 1, 'Yes', 0, 0, 0, 0, 1);
INSERT INTO tx_projectregistration_domain_model_productpropertyvalue VALUES (2, 1, 'No', 0, 0, 0, 0, 1);
INSERT INTO tx_projectregistration_domain_model_productpropertyvalue VALUES (3, 1, 'Yes', 0, 0, 0, 0, 2);
INSERT INTO tx_projectregistration_domain_model_productpropertyvalue VALUES (4, 1, 'No', 0, 0, 0, 0, 2);


DROP TABLE IF EXISTS tx_projectregistration_product_property_mm;
CREATE TABLE tx_projectregistration_product_property_mm (
  uid_local int(11) unsigned NOT NULL DEFAULT '0',
  uid_foreign int(11) unsigned NOT NULL DEFAULT '0',
  sorting int(11) unsigned NOT NULL DEFAULT '0',
  sorting_foreign int(11) unsigned NOT NULL DEFAULT '0',
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);
INSERT INTO tx_projectregistration_product_property_mm VALUES (1, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (2, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (3, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (4, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (5, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (6, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (7, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (8, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (9, 1, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (24, 2, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (25, 2, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (26, 2, 1, 0);
INSERT INTO tx_projectregistration_product_property_mm VALUES (27, 2, 1, 0);