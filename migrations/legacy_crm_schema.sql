SET FOREIGN_KEY_CHECKS=0;
drop table  if exists claims;
drop table  if exists drivers;
drop table  if exists license;
drop table  if exists owneraddress;
drop table  if exists quotationowner;
drop table  if exists notes;
drop table  if exists transaction;
drop table  if exists quotationvehicle;
drop table  if exists vehicle;
drop table  if exists coveragesinpolicy;
drop table  if exists coveragesinquotation;
drop table  if exists chargesinquotation;
drop table  if exists owner;
drop table  if exists sale;
drop table  if exists employersliability;
drop table  if exists endorsement;
drop table  if exists medical;
drop table  if exists medicalinsuredperson;
drop table  if exists propertyfire;
drop table  if exists statistics;
drop table  if exists reasonswecannotprovideonlinequote;
drop table  if exists discount;
drop table  if exists systemuser;
drop table  if exists quotation;
drop table  if exists emailPreferences;

SET FOREIGN_KEY_CHECKS=1;

create table systemuser(
	username varchar(40) NOT NULL,
	stateId varchar(20),
	title varchar(10),
	producer varchar(20),
	gender varchar(10),
	firstName varchar(70),
	lastName varchar(70),
	telephone varchar(20),
	cellphone varchar(20),
	profession varchar(20),
	email varchar(50) NOT NULL,
	birthDate datetime,
	licenseIssueDate datetime,
	clientName varchar(40),
	PRIMARY KEY(username)
	)ENGINE=InnoDB;
	
create table quotation(
	quoteId int(10) NOT NULL AUTO_INCREMENT,
	canProvideOnlineQuote VARCHAR(5),
	entryDate datetime NOT NULL,
	quoteAmount int(6) NOT NULL,
	insuranceCompanyOfferingQuote varchar(50),
	offerSelected varchar(20),
	coverageType varchar(50),
	username varchar(40),
	userInfo varchar(255),
	UNIQUE(quoteId)
	)ENGINE=InnoDB;
		
create table owner(
	stateId varchar(20) NOT NULL,
	firstName varchar(70),
	lastName varchar(70),
	type varchar(50),
	proposerType varchar(30),
	gender varchar(10),
	countryOfBirth varchar(30),
	countryOfResidence varchar(30),
	birthDate datetime,
	profession varchar(30),
	company varchar(50),
	telephone varchar(20),
	cellphone varchar(20),
	email varchar(50),
	unwantedCustomer varchar(5),
	reasonForUnwanted varchar(50),
	UNIQUE(stateId)
	)ENGINE=InnoDB;
	
create table quotationowner(
	stateId varchar(20),
	quoteId int(10),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


create table license(
	stateId varchar(20),
	licenseType varchar(30),
	licenseDate datetime,
	licenseCountry varchar(50),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table drivingexperience(
	stateId varchar(20),
	hasPreviousInsurance varchar(5),
	countryOfInsurance varchar(50),
	insuranceCompany varchar(50),
	yearsOfExperience varchar(5),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table sale(
	saleId varchar(20) NOT NULL,
	company varchar(50),
	insuranceType varchar(50),
	coverageType varchar(50),
	startDate datetime,
	endDate datetime,
	associate varchar(50),
	producer varchar(70),
	status varchar(20),
	stateId varchar(20) NOT NULL,
	primary key(saleId),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

create table owneraddress(
	addressId int(10) NOT NULL AUTO_INCREMENT,
	addressType varchar(30),
	street varchar(60),
	areaCode varchar(10),
	city varchar(20),
	state varchar(20),
	country varchar(50),
	stateId varchar(20) NOT NULL,
	UNIQUE(addressId),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table statistics(
	code int(3) NOT NULL,
	value varchar(50) NOT NULL
	)ENGINE=InnoDB;
	
create table reasonswecannotprovideonlinequote(
	quoteId int(10),
	reason varchar(100) NOT NULL, 
	FOREIGN KEY(quoteId) REFERENCES quotation(quoteId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
	
create table vehicle(
	regNumber varchar(10) NOT NULL,
	vehicleType varchar(40) NOT NULL,
	make varchar(20),
	model varchar(70),
	submodel varchar(20),
	cubicCapacity int(5) NOT NULL,
	engineKw int(4),
	manufacturedYear int(5) NOT NULL,
	seatsNo int(3),
	sumInsured int(6),
	vehicleDesign varchar(15) NOT NULL, 
	steeringWheelSide varchar(10),
	isTaxFree varchar(10),
	isUsedForDeliveries varchar(10),
	hasVisitorPlates varchar(10),
	saleId varchar(20),
	primary key(regNumber,saleId)
	)ENGINE=InnoDB;

create table quotationvehicle(
	regNumber varchar(10),
	quoteId int(10),
	FOREIGN KEY(regNumber) REFERENCES vehicle(regNumber) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


create table drivers(
	driverId int(20) NOT NULL AUTO_INCREMENT,
	saleId varchar(20) NOT NULL,
	stateId varchar(20) NOT NULL,
	firstName varchar(70),
	lastName varchar(70),
	countryOfBirth varchar(30),
	birthDate datetime,
	licenseCountry varchar(50),
	licenseDate datetime,
	licenseType varchar(30),
	profession varchar(30),
	telephone varchar(12),
	unwantedCustomer varchar(5),
	reasonForUnwanted varchar(50),
	UNIQUE(driverId),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table propertyfire(
	saleId varchar(20) NOT NULL,
	description varchar(100),
	typeOfPremises varchar(50),
	buildingValue int(10),
	outsideFixturesValue int(10),
	contentsValue int(10),
	valuableObjectsValue int(10),
	yearBuilt int(6),
	areaSqMt int(7),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;

create table endorsement(
	saleId varchar(20) NOT NULL,
	code varchar(30),
	description varchar(50),
	parameter varchar(50),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
	
create table employersliability(
	saleId varchar(20) NOT NULL,
	employersSocialInsuranceNumber varchar(20),
	limitPerEmployee int(10),
	limitPerEventOrSeriesOfEvents int(12),
	limitDuringPeriodOfInsurance int(12),
	employeesNumber int(4),
	estimatedTotalGrossEarnings int(10),
	unique(saleId),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;

create table medical(
	saleId varchar(20) NOT NULL,
	frequencyOfPayment varchar(20),
	premium double(10,2),
	planName varchar(20),
	planMaximumLimit int(12),
	deductible int(8),
	excess int(8),
	coInsurancePercentage int(3),
	roomType varchar(30),
	outpatientAmount int(6),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;

create table lifeins(
	saleId varchar(20) NOT NULL,
	insuredFirstName varchar(70),
	insuredLastName varchar(70),
	frequencyOfPayment varchar(20),
	annualPremium double(10,2),
	monthlyPremium double(10,2),
	planName varchar(20),
	basicPlanAmount double(10,2),
	totalPermanentDisabilityAmount double(10,2),
	premiumProtectionAmount double(10,2),
	primary key(saleId),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table medicalinsuredperson(
	personId int(20) NOT NULL AUTO_INCREMENT,	
	saleId varchar(20) NOT NULL,
	firstName varchar(70),
	lastName varchar(70),
	birthDate datetime,
	stateId varchar(50),
	telephone varchar(50),
	gender varchar(10),
	primary key(personId),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB;
	
create table claims(
	claimId int(20) NOT NULL AUTO_INCREMENT,
	quoteId int(10),
	stateId varchar(20),
	amount int(6) NOT NULL,
	claimDate datetime,
	description varchar(50),
	unique(claimId),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;
	
	
create table notes(
	notesId int(20) NOT NULL AUTO_INCREMENT,
	type varchar(20),
	description varchar(50),
	entryDate datetime,
	parameterName varchar(20),
	parameterValue varchar(20),
	UNIQUE(notesId)
)ENGINE=InnoDB;

create table transaction(
	transId int(20) NOT NULL auto_increment,
	producer varchar(20),
	receiptNo varchar(30),
	transDate datetime,
	details varchar(30),
	debit double(10,2),
	credit double(10,2),
	remainder double(10,2),
	saleId varchar(20) NOT NULL,
	UNIQUE(transId),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


create table coveragesinpolicy(
	saleId varchar(20) NOT NULL,
	code varchar(50) NOT NULL,
	param1 varchar(50),
	param2 varchar(50),
	param3 varchar(50),
	description varchar(100),
	charge double(10,2),
	primary key(saleId,code),
	FOREIGN KEY(saleId) REFERENCES sale(saleId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;
	
	
create table coveragesinquotation(
	quoteId int(10) NOT NULL,
	code varchar(50) NOT NULL,
	param1 varchar(50),
	param2 varchar(50),
	param3 varchar(50),
	description varchar(100),
	decision varchar(30),
	charge double(10,2),
	primary key(quoteId,code),
	FOREIGN KEY(quoteId) REFERENCES quotation(quoteId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


create table chargesinquotation(
	quoteId int(10) NOT NULL,
	code varchar(50) NOT NULL,
	param1 varchar(50),
	param2 varchar(50),
	param3 varchar(50),
	description varchar(100),
	charge double(10,2),
	primary key(quoteId,code),
	FOREIGN KEY(quoteId) REFERENCES quotation(quoteId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;


create table quotation_discounts(
	quoteId int(10) NOT NULL,
	code varchar(50) NOT NULL,
	param1 varchar(50),
	param2 varchar(50),
	param3 varchar(50),
	description varchar(100),
	charge double(10,2),
	primary key(quoteId,code),
	FOREIGN KEY(quoteId) REFERENCES quotation(quoteId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

create table history(
	historyId int(20) NOT NULL auto_increment,
	transDate datetime,
	username varchar(40),
	type varchar(30),
	subType varchar(30),
	parameterName varchar(20),
	parameterValue varchar(20),
	note varchar(200),
	primary key (historyId)
)ENGINE=InnoDB;

create table emailPreferences(
	stateId varchar(20) NOT NULL,
	preferenceCode varchar(50),
	preferenceFrequency varchar(50),
	FOREIGN KEY(stateId) REFERENCES owner(stateId) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;