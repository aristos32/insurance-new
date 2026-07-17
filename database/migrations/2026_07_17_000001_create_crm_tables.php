<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CRM schema matching legacy table/column conventions for data migration.
 * Merges global + client systemuser into a single systemuser table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('systemuser', function (Blueprint $table) {
            $table->string('username', 40)->primary();
            $table->string('password', 255);
            $table->string('role', 20);
            $table->string('status', 20)->default('ACTIVE');
            $table->string('productType', 20)->nullable();
            $table->string('subProductType', 20)->nullable();
            $table->string('clientName', 40)->nullable();
            $table->unsignedTinyInteger('consecutiveFailLoginAttempts')->default(0);
            $table->string('stateId', 20)->nullable();
            $table->string('title', 10)->nullable();
            $table->string('producer', 20)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('firstName', 70)->nullable();
            $table->string('lastName', 70)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('cellphone', 20)->nullable();
            $table->string('profession', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->dateTime('birthDate')->nullable();
            $table->dateTime('licenseIssueDate')->nullable();
            $table->rememberToken();
        });

        Schema::create('owner', function (Blueprint $table) {
            $table->string('stateId', 20)->primary();
            $table->string('firstName', 70)->nullable();
            $table->string('lastName', 70)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('proposerType', 30)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('countryOfBirth', 30)->nullable();
            $table->string('countryOfResidence', 30)->nullable();
            $table->dateTime('birthDate')->nullable();
            $table->string('profession', 30)->nullable();
            $table->string('company', 50)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('cellphone', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('unwantedCustomer', 5)->nullable();
            $table->string('reasonForUnwanted', 50)->nullable();
        });

        Schema::create('owneraddress', function (Blueprint $table) {
            $table->increments('addressId');
            $table->string('addressType', 30)->nullable();
            $table->string('street', 60)->nullable();
            $table->string('areaCode', 10)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('stateId', 20);
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('license', function (Blueprint $table) {
            $table->id();
            $table->string('stateId', 20);
            $table->string('licenseType', 30)->nullable();
            $table->dateTime('licenseDate')->nullable();
            $table->string('licenseCountry', 50)->nullable();
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('drivingexperience', function (Blueprint $table) {
            $table->id();
            $table->string('stateId', 20);
            $table->string('hasPreviousInsurance', 5)->nullable();
            $table->string('countryOfInsurance', 50)->nullable();
            $table->string('insuranceCompany', 50)->nullable();
            $table->string('yearsOfExperience', 5)->nullable();
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('emailPreferences', function (Blueprint $table) {
            $table->id();
            $table->string('stateId', 20);
            $table->string('preferenceCode', 50)->nullable();
            $table->string('preferenceFrequency', 50)->nullable();
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('sale', function (Blueprint $table) {
            $table->string('saleId', 20)->primary();
            $table->string('company', 50)->nullable();
            $table->string('insuranceType', 50)->nullable();
            $table->string('coverageType', 50)->nullable();
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->string('associate', 50)->nullable();
            $table->string('producer', 70)->nullable();
            $table->string('status', 20)->nullable();
            $table->string('stateId', 20);
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('vehicle', function (Blueprint $table) {
            $table->string('regNumber', 10);
            $table->string('saleId', 20);
            $table->string('vehicleType', 40);
            $table->string('make', 20)->nullable();
            $table->string('model', 70)->nullable();
            $table->string('submodel', 20)->nullable();
            $table->integer('cubicCapacity');
            $table->integer('engineKw')->nullable();
            $table->integer('manufacturedYear');
            $table->integer('seatsNo')->nullable();
            $table->integer('sumInsured')->nullable();
            $table->string('vehicleDesign', 15);
            $table->string('steeringWheelSide', 10)->nullable();
            $table->string('isTaxFree', 10)->nullable();
            $table->string('isUsedForDeliveries', 10)->nullable();
            $table->string('hasVisitorPlates', 10)->nullable();
            $table->primary(['regNumber', 'saleId']);
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('driverId');
            $table->string('saleId', 20);
            $table->string('stateId', 20);
            $table->string('firstName', 70)->nullable();
            $table->string('lastName', 70)->nullable();
            $table->string('countryOfBirth', 30)->nullable();
            $table->dateTime('birthDate')->nullable();
            $table->string('licenseCountry', 50)->nullable();
            $table->dateTime('licenseDate')->nullable();
            $table->string('licenseType', 30)->nullable();
            $table->string('profession', 30)->nullable();
            $table->string('telephone', 12)->nullable();
            $table->string('unwantedCustomer', 5)->nullable();
            $table->string('reasonForUnwanted', 50)->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('propertyfire', function (Blueprint $table) {
            $table->string('saleId', 20)->primary();
            $table->string('description', 100)->nullable();
            $table->string('typeOfPremises', 50)->nullable();
            $table->integer('buildingValue')->nullable();
            $table->integer('outsideFixturesValue')->nullable();
            $table->integer('contentsValue')->nullable();
            $table->integer('valuableObjectsValue')->nullable();
            $table->integer('yearBuilt')->nullable();
            $table->integer('areaSqMt')->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('employersliability', function (Blueprint $table) {
            $table->string('saleId', 20)->primary();
            $table->string('employersSocialInsuranceNumber', 20)->nullable();
            $table->integer('limitPerEmployee')->nullable();
            $table->integer('limitPerEventOrSeriesOfEvents')->nullable();
            $table->integer('limitDuringPeriodOfInsurance')->nullable();
            $table->integer('employeesNumber')->nullable();
            $table->integer('estimatedTotalGrossEarnings')->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('medical', function (Blueprint $table) {
            $table->string('saleId', 20)->primary();
            $table->string('frequencyOfPayment', 20)->nullable();
            $table->double('premium', 10, 2)->nullable();
            $table->string('planName', 20)->nullable();
            $table->integer('planMaximumLimit')->nullable();
            $table->integer('deductible')->nullable();
            $table->integer('excess')->nullable();
            $table->integer('coInsurancePercentage')->nullable();
            $table->string('roomType', 30)->nullable();
            $table->integer('outpatientAmount')->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('medicalinsuredperson', function (Blueprint $table) {
            $table->increments('personId');
            $table->string('saleId', 20);
            $table->string('firstName', 70)->nullable();
            $table->string('lastName', 70)->nullable();
            $table->dateTime('birthDate')->nullable();
            $table->string('stateId', 50)->nullable();
            $table->string('telephone', 50)->nullable();
            $table->string('gender', 10)->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('lifeins', function (Blueprint $table) {
            $table->string('saleId', 20)->primary();
            $table->string('insuredFirstName', 70)->nullable();
            $table->string('insuredLastName', 70)->nullable();
            $table->string('frequencyOfPayment', 20)->nullable();
            $table->double('annualPremium', 10, 2)->nullable();
            $table->double('monthlyPremium', 10, 2)->nullable();
            $table->string('planName', 20)->nullable();
            $table->double('basicPlanAmount', 10, 2)->nullable();
            $table->double('totalPermanentDisabilityAmount', 10, 2)->nullable();
            $table->double('premiumProtectionAmount', 10, 2)->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('endorsement', function (Blueprint $table) {
            $table->id();
            $table->string('saleId', 20);
            $table->string('code', 30)->nullable();
            $table->string('description', 50)->nullable();
            $table->string('parameter', 50)->nullable();
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('coveragesinpolicy', function (Blueprint $table) {
            $table->string('saleId', 20);
            $table->string('code', 50);
            $table->string('param1', 50)->nullable();
            $table->string('param2', 50)->nullable();
            $table->string('param3', 50)->nullable();
            $table->string('description', 100)->nullable();
            $table->double('charge', 10, 2)->nullable();
            $table->primary(['saleId', 'code']);
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('transId');
            $table->string('producer', 20)->nullable();
            $table->string('receiptNo', 30)->nullable();
            $table->dateTime('transDate')->nullable();
            $table->string('details', 30)->nullable();
            $table->double('debit', 10, 2)->nullable();
            $table->double('credit', 10, 2)->nullable();
            $table->double('remainder', 10, 2)->nullable();
            $table->string('saleId', 20);
            $table->foreign('saleId')->references('saleId')->on('sale')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('claims', function (Blueprint $table) {
            $table->increments('claimId');
            $table->integer('quoteId')->nullable();
            $table->string('stateId', 20)->nullable();
            $table->integer('amount');
            $table->dateTime('claimDate')->nullable();
            $table->string('description', 50)->nullable();
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('notes', function (Blueprint $table) {
            $table->increments('notesId');
            $table->string('type', 20)->nullable();
            $table->string('description', 50)->nullable();
            $table->dateTime('entryDate')->nullable();
            $table->string('parameterName', 20)->nullable();
            $table->string('parameterValue', 20)->nullable();
        });

        Schema::create('history', function (Blueprint $table) {
            $table->increments('historyId');
            $table->dateTime('transDate')->nullable();
            $table->string('username', 40)->nullable();
            $table->string('type', 30)->nullable();
            $table->string('subType', 30)->nullable();
            $table->string('parameterName', 20)->nullable();
            $table->string('parameterValue', 20)->nullable();
            $table->string('note', 200)->nullable();
        });

        Schema::create('quotation', function (Blueprint $table) {
            $table->increments('quoteId');
            $table->string('canProvideOnlineQuote', 5)->nullable();
            $table->dateTime('entryDate');
            $table->integer('quoteAmount');
            $table->string('insuranceCompanyOfferingQuote', 50)->nullable();
            $table->string('offerSelected', 20)->nullable();
            $table->string('coverageType', 50)->nullable();
            $table->string('username', 40)->nullable();
            $table->string('userInfo', 255)->nullable();
        });

        Schema::create('quotationowner', function (Blueprint $table) {
            $table->id();
            $table->string('stateId', 20)->nullable();
            $table->unsignedInteger('quoteId')->nullable();
            $table->foreign('stateId')->references('stateId')->on('owner')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('quotationvehicle', function (Blueprint $table) {
            $table->id();
            $table->string('regNumber', 10)->nullable();
            $table->unsignedInteger('quoteId')->nullable();
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('coveragesinquotation', function (Blueprint $table) {
            $table->unsignedInteger('quoteId');
            $table->string('code', 50);
            $table->string('param1', 50)->nullable();
            $table->string('param2', 50)->nullable();
            $table->string('param3', 50)->nullable();
            $table->string('description', 100)->nullable();
            $table->string('decision', 30)->nullable();
            $table->double('charge', 10, 2)->nullable();
            $table->primary(['quoteId', 'code']);
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('chargesinquotation', function (Blueprint $table) {
            $table->unsignedInteger('quoteId');
            $table->string('code', 50);
            $table->string('param1', 50)->nullable();
            $table->string('param2', 50)->nullable();
            $table->string('param3', 50)->nullable();
            $table->string('description', 100)->nullable();
            $table->double('charge', 10, 2)->nullable();
            $table->primary(['quoteId', 'code']);
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('quotation_discounts', function (Blueprint $table) {
            $table->unsignedInteger('quoteId');
            $table->string('code', 50);
            $table->string('param1', 50)->nullable();
            $table->string('param2', 50)->nullable();
            $table->string('param3', 50)->nullable();
            $table->string('description', 100)->nullable();
            $table->double('charge', 10, 2)->nullable();
            $table->primary(['quoteId', 'code']);
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('reasonswecannotprovideonlinequote', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quoteId')->nullable();
            $table->string('reason', 100);
            $table->foreign('quoteId')->references('quoteId')->on('quotation')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('statistics', function (Blueprint $table) {
            $table->unsignedTinyInteger('code')->primary();
            $table->string('value', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
        Schema::dropIfExists('reasonswecannotprovideonlinequote');
        Schema::dropIfExists('quotation_discounts');
        Schema::dropIfExists('chargesinquotation');
        Schema::dropIfExists('coveragesinquotation');
        Schema::dropIfExists('quotationvehicle');
        Schema::dropIfExists('quotationowner');
        Schema::dropIfExists('quotation');
        Schema::dropIfExists('history');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('claims');
        Schema::dropIfExists('transaction');
        Schema::dropIfExists('coveragesinpolicy');
        Schema::dropIfExists('endorsement');
        Schema::dropIfExists('lifeins');
        Schema::dropIfExists('medicalinsuredperson');
        Schema::dropIfExists('medical');
        Schema::dropIfExists('employersliability');
        Schema::dropIfExists('propertyfire');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicle');
        Schema::dropIfExists('sale');
        Schema::dropIfExists('emailPreferences');
        Schema::dropIfExists('drivingexperience');
        Schema::dropIfExists('license');
        Schema::dropIfExists('owneraddress');
        Schema::dropIfExists('owner');
        Schema::dropIfExists('systemuser');
    }
};
