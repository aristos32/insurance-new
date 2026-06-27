<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260627101206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE claims (claimId INT AUTO_INCREMENT NOT NULL, quoteId INT DEFAULT NULL, amount INT NOT NULL, claimDate DATETIME DEFAULT NULL, description VARCHAR(50) DEFAULT NULL, stateId VARCHAR(20) DEFAULT NULL, INDEX IDX_BEA313BEB5286BEF (stateId), PRIMARY KEY (claimId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE coveragesinpolicy (saleId VARCHAR(20) NOT NULL, code VARCHAR(50) NOT NULL, param1 VARCHAR(50) DEFAULT NULL, param2 VARCHAR(50) DEFAULT NULL, param3 VARCHAR(50) DEFAULT NULL, description VARCHAR(100) DEFAULT NULL, charge DOUBLE PRECISION DEFAULT NULL, INDEX IDX_C9218A3ACCAE904C (saleId), PRIMARY KEY (saleId, code)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE drivers (driverId INT AUTO_INCREMENT NOT NULL, stateId VARCHAR(20) NOT NULL, firstName VARCHAR(70) DEFAULT NULL, lastName VARCHAR(70) DEFAULT NULL, countryOfBirth VARCHAR(30) DEFAULT NULL, birthDate DATETIME DEFAULT NULL, licenseCountry VARCHAR(50) DEFAULT NULL, licenseDate DATETIME DEFAULT NULL, licenseType VARCHAR(30) DEFAULT NULL, profession VARCHAR(30) DEFAULT NULL, telephone VARCHAR(12) DEFAULT NULL, saleId VARCHAR(20) NOT NULL, INDEX IDX_E410C307CCAE904C (saleId), PRIMARY KEY (driverId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE drivingexperience (id INT AUTO_INCREMENT NOT NULL, hasPreviousInsurance VARCHAR(5) DEFAULT NULL, countryOfInsurance VARCHAR(50) DEFAULT NULL, insuranceCompany VARCHAR(50) DEFAULT NULL, yearsOfExperience VARCHAR(5) DEFAULT NULL, stateId VARCHAR(20) NOT NULL, INDEX IDX_60D5F817B5286BEF (stateId), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE employersliability (saleId VARCHAR(20) NOT NULL, employersSocialInsuranceNumber VARCHAR(20) DEFAULT NULL, employeesNumber INT DEFAULT NULL, PRIMARY KEY (saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE endorsement (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(30) DEFAULT NULL, description VARCHAR(50) DEFAULT NULL, parameter VARCHAR(50) DEFAULT NULL, saleId VARCHAR(20) NOT NULL, INDEX IDX_1BB4EA3CCAE904C (saleId), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE history (historyId INT AUTO_INCREMENT NOT NULL, transDate DATETIME DEFAULT NULL, username VARCHAR(40) DEFAULT NULL, type VARCHAR(30) DEFAULT NULL, subType VARCHAR(30) DEFAULT NULL, parameterName VARCHAR(20) DEFAULT NULL, parameterValue VARCHAR(20) DEFAULT NULL, note VARCHAR(200) DEFAULT NULL, PRIMARY KEY (historyId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE license (id INT AUTO_INCREMENT NOT NULL, licenseType VARCHAR(30) DEFAULT NULL, licenseDate DATETIME DEFAULT NULL, licenseCountry VARCHAR(50) DEFAULT NULL, stateId VARCHAR(20) NOT NULL, INDEX IDX_5768F419B5286BEF (stateId), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lifeins (saleId VARCHAR(20) NOT NULL, insuredFirstName VARCHAR(70) DEFAULT NULL, insuredLastName VARCHAR(70) DEFAULT NULL, frequencyOfPayment VARCHAR(20) DEFAULT NULL, annualPremium DOUBLE PRECISION DEFAULT NULL, planName VARCHAR(20) DEFAULT NULL, PRIMARY KEY (saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE medical (saleId VARCHAR(20) NOT NULL, frequencyOfPayment VARCHAR(20) DEFAULT NULL, premium DOUBLE PRECISION DEFAULT NULL, planName VARCHAR(20) DEFAULT NULL, PRIMARY KEY (saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE notes (notesId INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) DEFAULT NULL, description VARCHAR(50) DEFAULT NULL, entryDate DATETIME DEFAULT NULL, parameterName VARCHAR(20) DEFAULT NULL, parameterValue VARCHAR(20) DEFAULT NULL, PRIMARY KEY (notesId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE owner (stateId VARCHAR(20) NOT NULL, firstName VARCHAR(70) DEFAULT NULL, lastName VARCHAR(70) DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, proposerType VARCHAR(30) DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, countryOfBirth VARCHAR(30) DEFAULT NULL, countryOfResidence VARCHAR(30) DEFAULT NULL, birthDate DATETIME DEFAULT NULL, profession VARCHAR(30) DEFAULT NULL, company VARCHAR(50) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, cellphone VARCHAR(20) DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, unwantedCustomer VARCHAR(5) DEFAULT NULL, reasonForUnwanted VARCHAR(50) DEFAULT NULL, PRIMARY KEY (stateId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE owneraddress (addressId INT AUTO_INCREMENT NOT NULL, addressType VARCHAR(30) DEFAULT NULL, street VARCHAR(60) DEFAULT NULL, areaCode VARCHAR(10) DEFAULT NULL, city VARCHAR(20) DEFAULT NULL, state VARCHAR(20) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, stateId VARCHAR(20) NOT NULL, INDEX IDX_5187A45CB5286BEF (stateId), PRIMARY KEY (addressId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE propertyfire (saleId VARCHAR(20) NOT NULL, description VARCHAR(100) DEFAULT NULL, typeOfPremises VARCHAR(50) DEFAULT NULL, buildingValue INT DEFAULT NULL, PRIMARY KEY (saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE quotation (quoteId INT AUTO_INCREMENT NOT NULL, canProvideOnlineQuote VARCHAR(5) DEFAULT NULL, entryDate DATETIME NOT NULL, quoteAmount INT NOT NULL, insuranceCompanyOfferingQuote VARCHAR(50) DEFAULT NULL, coverageType VARCHAR(50) DEFAULT NULL, username VARCHAR(40) DEFAULT NULL, PRIMARY KEY (quoteId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sale (saleId VARCHAR(20) NOT NULL, company VARCHAR(50) DEFAULT NULL, insuranceType VARCHAR(50) DEFAULT NULL, coverageType VARCHAR(50) DEFAULT NULL, startDate DATETIME DEFAULT NULL, endDate DATETIME DEFAULT NULL, associate VARCHAR(50) DEFAULT NULL, producer VARCHAR(70) DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, stateId VARCHAR(20) NOT NULL, INDEX IDX_E54BC005B5286BEF (stateId), PRIMARY KEY (saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE statistics (code INT NOT NULL, value VARCHAR(50) NOT NULL, PRIMARY KEY (code)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE systemuser (username VARCHAR(40) NOT NULL, stateId VARCHAR(20) DEFAULT NULL, title VARCHAR(10) DEFAULT NULL, producer VARCHAR(20) DEFAULT NULL, gender VARCHAR(10) DEFAULT NULL, firstName VARCHAR(70) DEFAULT NULL, lastName VARCHAR(70) DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, cellphone VARCHAR(20) DEFAULT NULL, profession VARCHAR(20) DEFAULT NULL, email VARCHAR(50) NOT NULL, birthDate DATETIME DEFAULT NULL, licenseIssueDate DATETIME DEFAULT NULL, clientName VARCHAR(40) DEFAULT NULL, PRIMARY KEY (username)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE transaction (transId INT AUTO_INCREMENT NOT NULL, producer VARCHAR(20) DEFAULT NULL, receiptNo VARCHAR(30) DEFAULT NULL, transDate DATETIME DEFAULT NULL, details VARCHAR(30) DEFAULT NULL, debit DOUBLE PRECISION DEFAULT NULL, credit DOUBLE PRECISION DEFAULT NULL, remainder DOUBLE PRECISION DEFAULT NULL, saleId VARCHAR(20) NOT NULL, INDEX IDX_723705D1CCAE904C (saleId), PRIMARY KEY (transId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vehicle (regNumber VARCHAR(10) NOT NULL, saleId VARCHAR(20) NOT NULL, vehicleType VARCHAR(40) NOT NULL, make VARCHAR(20) DEFAULT NULL, model VARCHAR(70) DEFAULT NULL, submodel VARCHAR(20) DEFAULT NULL, cubicCapacity INT NOT NULL, engineKw INT DEFAULT NULL, manufacturedYear INT NOT NULL, seatsNo INT DEFAULT NULL, sumInsured INT DEFAULT NULL, vehicleDesign VARCHAR(15) NOT NULL, steeringWheelSide VARCHAR(10) DEFAULT NULL, isTaxFree VARCHAR(10) DEFAULT NULL, isUsedForDeliveries VARCHAR(10) DEFAULT NULL, hasVisitorPlates VARCHAR(10) DEFAULT NULL, INDEX IDX_1B80E486CCAE904C (saleId), PRIMARY KEY (regNumber, saleId)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE claims ADD CONSTRAINT FK_BEA313BEB5286BEF FOREIGN KEY (stateId) REFERENCES owner (stateId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coveragesinpolicy ADD CONSTRAINT FK_C9218A3ACCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drivers ADD CONSTRAINT FK_E410C307CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drivingexperience ADD CONSTRAINT FK_60D5F817B5286BEF FOREIGN KEY (stateId) REFERENCES owner (stateId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employersliability ADD CONSTRAINT FK_EC65B698CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE endorsement ADD CONSTRAINT FK_1BB4EA3CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F419B5286BEF FOREIGN KEY (stateId) REFERENCES owner (stateId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lifeins ADD CONSTRAINT FK_917FB4A1CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075ACCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE owneraddress ADD CONSTRAINT FK_5187A45CB5286BEF FOREIGN KEY (stateId) REFERENCES owner (stateId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE propertyfire ADD CONSTRAINT FK_D78944E6CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC005B5286BEF FOREIGN KEY (stateId) REFERENCES owner (stateId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486CCAE904C FOREIGN KEY (saleId) REFERENCES sale (saleId) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE claims DROP FOREIGN KEY FK_BEA313BEB5286BEF');
        $this->addSql('ALTER TABLE coveragesinpolicy DROP FOREIGN KEY FK_C9218A3ACCAE904C');
        $this->addSql('ALTER TABLE drivers DROP FOREIGN KEY FK_E410C307CCAE904C');
        $this->addSql('ALTER TABLE drivingexperience DROP FOREIGN KEY FK_60D5F817B5286BEF');
        $this->addSql('ALTER TABLE employersliability DROP FOREIGN KEY FK_EC65B698CCAE904C');
        $this->addSql('ALTER TABLE endorsement DROP FOREIGN KEY FK_1BB4EA3CCAE904C');
        $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_5768F419B5286BEF');
        $this->addSql('ALTER TABLE lifeins DROP FOREIGN KEY FK_917FB4A1CCAE904C');
        $this->addSql('ALTER TABLE medical DROP FOREIGN KEY FK_77DB075ACCAE904C');
        $this->addSql('ALTER TABLE owneraddress DROP FOREIGN KEY FK_5187A45CB5286BEF');
        $this->addSql('ALTER TABLE propertyfire DROP FOREIGN KEY FK_D78944E6CCAE904C');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC005B5286BEF');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CCAE904C');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486CCAE904C');
        $this->addSql('DROP TABLE claims');
        $this->addSql('DROP TABLE coveragesinpolicy');
        $this->addSql('DROP TABLE drivers');
        $this->addSql('DROP TABLE drivingexperience');
        $this->addSql('DROP TABLE employersliability');
        $this->addSql('DROP TABLE endorsement');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE license');
        $this->addSql('DROP TABLE lifeins');
        $this->addSql('DROP TABLE medical');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE owneraddress');
        $this->addSql('DROP TABLE propertyfire');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE statistics');
        $this->addSql('DROP TABLE systemuser');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE vehicle');
    }
}
