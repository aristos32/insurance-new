<?php

namespace App\DataFixtures;

use App\Entity\Crm\Claim;
use App\Entity\Crm\Customer;
use App\Entity\Crm\CustomerAddress;
use App\Entity\Crm\Note;
use App\Entity\Crm\Sale;
use App\Entity\Crm\User;
use App\Entity\Crm\Vehicle;
use App\Enum\CustomerType;
use App\Enum\HistoryType;
use App\Enum\InsuranceType;
use App\Enum\NoteType;
use App\Enum\SaleStatus;
use App\Enum\TransactionDetail;
use App\Enum\UserRole;
use App\Enum\UserStatus;
use App\Service\HistoryService;
use App\Service\TransactionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TransactionService $transactionService,
        private readonly HistoryService $historyService,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = (new User())
            ->setUsername('admin')
            ->setRole((string) UserRole::Administrator->value)
            ->setStatus(UserStatus::Active->value)
            ->setProductType('OFFICE')
            ->setFirstName('System')
            ->setLastName('Administrator')
            ->setEmail('admin@example.com')
            ->setProducer('admin')
            ->setConsecutiveFailLoginAttempts(0);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $employee = (new User())
            ->setUsername('employee')
            ->setRole((string) UserRole::Employee->value)
            ->setStatus(UserStatus::Active->value)
            ->setProductType('OFFICE')
            ->setFirstName('Demo')
            ->setLastName('Employee')
            ->setEmail('employee@example.com')
            ->setProducer('employee')
            ->setConsecutiveFailLoginAttempts(0);
        $employee->setPassword($this->passwordHasher->hashPassword($employee, 'employee123'));
        $manager->persist($employee);

        $customer = (new Customer())
            ->setStateId('100001')
            ->setFirstName('Maria')
            ->setLastName('Georgiou')
            ->setType(CustomerType::Customer)
            ->setEmail('maria@example.com')
            ->setTelephone('22123456')
            ->setCountryOfResidence('CYPRUS');
        $customer->addAddress(
            (new CustomerAddress())
                ->setAddressType('CORRESPONDENCEADDRESS')
                ->setStreet('12 Makarios Ave')
                ->setCity('Nicosia')
                ->setCountry('CYPRUS'),
        );
        $manager->persist($customer);

        $customerUser = (new User())
            ->setUsername('maria')
            ->setRole((string) UserRole::Customer->value)
            ->setStatus(UserStatus::Active->value)
            ->setStateId('100001')
            ->setFirstName('Maria')
            ->setLastName('Georgiou')
            ->setEmail('maria@example.com')
            ->setConsecutiveFailLoginAttempts(0);
        $customerUser->setPassword($this->passwordHasher->hashPassword($customerUser, 'customer123'));
        $manager->persist($customerUser);

        $lead = (new Customer())
            ->setStateId('100002')
            ->setFirstName('Andreas')
            ->setLastName('Christou')
            ->setType(CustomerType::Lead)
            ->setEmail('andreas@example.com')
            ->setTelephone('99123456');
        $manager->persist($lead);

        $sale = (new Sale())
            ->setSaleId('200001')
            ->setCustomer($customer)
            ->setCompany('Demo Insurance Co')
            ->setInsuranceType(InsuranceType::Motor)
            ->setCoverageType('COMPREHENSIVE')
            ->setStartDate(new \DateTime('-6 months'))
            ->setEndDate(new \DateTime('+6 months'))
            ->setProducer('admin')
            ->setStatus(SaleStatus::Active);
        $manager->persist($sale);

        $vehicle = (new Vehicle())
            ->setRegNumber('ABC123')
            ->setSaleId($sale->getSaleId())
            ->setVehicleType('SALOON')
            ->setMake('Toyota')
            ->setModel('Corolla')
            ->setCubicCapacity(1600)
            ->setManufacturedYear(2019)
            ->setVehicleDesign('REGULAR')
            ->setSale($sale);
        $manager->persist($vehicle);

        $this->transactionService->addTransaction($sale, TransactionDetail::New, 450.00, null, 'R-001');
        $this->transactionService->addTransaction($sale, TransactionDetail::Cash, null, 200.00, 'R-002');

        $claim = (new Claim())
            ->setCustomer($customer)
            ->setAmount(500)
            ->setClaimDate(new \DateTime('-1 month'))
            ->setDescription('Minor accident');
        $manager->persist($claim);

        $note = (new Note())
            ->setType(NoteType::Customer)
            ->setDescription('Preferred contact by email')
            ->setEntryDate(new \DateTime())
            ->setParameterName('stateId')
            ->setParameterValue('100001');
        $manager->persist($note);

        $this->historyService->log(HistoryType::Customer, 'SEED', 'stateId', '100001', 'Demo data loaded');

        $manager->flush();
    }
}
