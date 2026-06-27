<?php

namespace App\DataFixtures;

use App\Entity\Crm\Claim;
use App\Entity\Crm\Note;
use App\Entity\Crm\Owner;
use App\Entity\Crm\OwnerAddress;
use App\Entity\Crm\Sale;
use App\Entity\Crm\StaffProfile;
use App\Entity\Crm\Vehicle;
use App\Entity\Global\GlobalUser;
use App\Enum\HistoryType;
use App\Enum\InsuranceType;
use App\Enum\NoteType;
use App\Enum\OwnerType;
use App\Enum\SaleStatus;
use App\Enum\TransactionDetail;
use App\Enum\UserRole;
use App\Enum\UserStatus;
use App\Service\HistoryService;
use App\Service\TransactionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private ObjectManager $globalEntityManager;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TransactionService $transactionService,
        private readonly HistoryService $historyService,
        ManagerRegistry $registry,
    ) {
        $this->globalEntityManager = $registry->getManager('global');
    }

    public function load(ObjectManager $manager): void
    {
        $this->seedGlobalUsers();
        $this->seedCrm($manager);
        $manager->flush();
        $this->globalEntityManager->flush();
    }

    private function seedGlobalUsers(): void
    {
        $admin = (new GlobalUser())
            ->setUsername('admin')
            ->setRole((string) UserRole::Administrator->value)
            ->setStatus(UserStatus::Active->value)
            ->setProductType('OFFICE')
            ->setConsecutiveFailLoginAttempts(0);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $this->globalEntityManager->persist($admin);

        $employee = (new GlobalUser())
            ->setUsername('employee')
            ->setRole((string) UserRole::Employee->value)
            ->setStatus(UserStatus::Active->value)
            ->setProductType('OFFICE')
            ->setConsecutiveFailLoginAttempts(0);
        $employee->setPassword($this->passwordHasher->hashPassword($employee, 'employee123'));
        $this->globalEntityManager->persist($employee);
    }

    private function seedCrm(ObjectManager $manager): void
    {
        $staff = (new StaffProfile())
            ->setUsername('admin')
            ->setFirstName('System')
            ->setLastName('Administrator')
            ->setEmail('admin@example.com')
            ->setProducer('admin');
        $manager->persist($staff);

        $owner = (new Owner())
            ->setStateId('100001')
            ->setFirstName('Maria')
            ->setLastName('Georgiou')
            ->setType(OwnerType::Account)
            ->setEmail('maria@example.com')
            ->setTelephone('22123456')
            ->setCountryOfResidence('CYPRUS');
        $owner->addAddress(
            (new OwnerAddress())
                ->setAddressType('CORRESPONDENCEADDRESS')
                ->setStreet('12 Makarios Ave')
                ->setCity('Nicosia')
                ->setCountry('CYPRUS'),
        );
        $manager->persist($owner);

        $lead = (new Owner())
            ->setStateId('100002')
            ->setFirstName('Andreas')
            ->setLastName('Christou')
            ->setType(OwnerType::Lead)
            ->setEmail('andreas@example.com')
            ->setTelephone('99123456');
        $manager->persist($lead);

        $sale = (new Sale())
            ->setSaleId('200001')
            ->setOwner($owner)
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
            ->setOwner($owner)
            ->setAmount(500)
            ->setClaimDate(new \DateTime('-1 month'))
            ->setDescription('Minor accident');
        $manager->persist($claim);

        $note = (new Note())
            ->setType(NoteType::Client)
            ->setDescription('Preferred contact by email')
            ->setEntryDate(new \DateTime())
            ->setParameterName('stateId')
            ->setParameterValue('100001');
        $manager->persist($note);

        $this->historyService->log(HistoryType::Client, 'SEED', 'stateId', '100001', 'Demo data loaded');
    }
}
