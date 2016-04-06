#
# Table structure for table 'tx_projectregistration_domain_model_project'
#
CREATE TABLE tx_projectregistration_domain_model_project (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	date_of_request datetime DEFAULT '0000-00-00 00:00:00',
	date_of_expiry datetime DEFAULT '0000-00-00 00:00:00',
	application varchar(255) DEFAULT '' NOT NULL,
	quantity varchar(255) DEFAULT '' NOT NULL,
	estimated_purchase_date date DEFAULT '0000-00-00',
	registration_notes text NOT NULL,
	internal_note text NOT NULL,
	denial_note text NOT NULL,
	addressee int(11) unsigned DEFAULT '0',
	approved tinyint(1) unsigned DEFAULT '0' NOT NULL,
	won tinyint(1) unsigned DEFAULT '0' NOT NULL,
	lost tinyint(1) unsigned DEFAULT '0' NOT NULL,
	registrant int(11) unsigned DEFAULT '0',
	end_user int(11) unsigned DEFAULT '0',
	product int(11) unsigned DEFAULT '0',
	property_values varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_projectregistration_domain_model_product'
#
CREATE TABLE tx_projectregistration_domain_model_product (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	properties int(11) unsigned DEFAULT '0' NOT NULL,

	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_projectregistration_domain_model_productproperty'
#
CREATE TABLE tx_projectregistration_domain_model_productproperty (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	form_element_type int(11) unsigned DEFAULT '0' NOT NULL,
	property_values int(11) unsigned DEFAULT '0' NOT NULL,

	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_projectregistration_domain_model_productpropertyvalue'
#
CREATE TABLE tx_projectregistration_domain_model_productpropertyvalue (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	property int(11) unsigned DEFAULT '0',

	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_projectregistration_domain_model_person'
#
CREATE TABLE tx_projectregistration_domain_model_person (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	username varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	first_name varchar(50) DEFAULT '' NOT NULL,
	middle_name varchar(50) DEFAULT '' NOT NULL,
	last_name varchar(50) DEFAULT '' NOT NULL,
	company varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	zip varchar(10) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	site varchar(255) DEFAULT '' NOT NULL,
	country int(11) unsigned DEFAULT '0',
	state int(11) unsigned DEFAULT '0',
	email varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	fax varchar(20) DEFAULT '' NOT NULL,
	title varchar(40) DEFAULT '' NOT NULL,
	www varchar(80) DEFAULT '' NOT NULL,
	fe_user int(11) unsigned DEFAULT '0',

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_projectregistration_product_property_mm'
#
CREATE TABLE tx_projectregistration_product_property_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);