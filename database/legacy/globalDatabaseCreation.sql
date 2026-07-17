create database cyprusInsurancesGlobaldatabase;

show databases;

use cyprusInsurancesGlobaldatabase;

show tables;

drop table if exists systemuser;

create table systemuser(
	username varchar(40) NOT NULL,
	password varchar(60) NOT NULL,
	role varchar(20) NOT NULL,
	status varchar(20) NOT NULL, 
	productType varchar(20),
	subProductType varchar(20),
	clientName varchar(40),
	consecutiveFailLoginAttempts int(3),
	PRIMARY KEY(username)
	)ENGINE=InnoDB;
	
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("thios", md5("thios"), "5", "ACTIVE", "cyprus-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("kat", md5("kat"), "2", "ACTIVE", "cyprus-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("aristos33", md5("aristos33"), "5", "ACTIVE", "cyprus-insurances", 'ALL', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("demo", md5("demo"), "2", "ACTIVE", "demo-insurances", 'ALL', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("test", md5("test"), "5", "ACTIVE", "test-insurances", 'ALL', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("ivi", md5("ivi"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("umbrella", md5("umbrella"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("kazakhstan", md5("kazakhstan"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("commercial", md5("commercial"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("progressive", md5("progressive"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("vournaris", md5("vournaris"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("antoniou", md5("antoniou"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);
insert into systemuser(username, password, role, status, clientName, productType, consecutiveFailLoginAttempts) values ("sica", md5("sica"), "5", "ACTIVE", "demo-insurances", 'OFFICE', 0);