<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AddressData;
use AppBundle\Entity\City;
use AppBundle\Entity\Parcel;
use AppBundle\Entity\ParcelOrder;
use AppBundle\Entity\Postman;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests. Execute this command to load the data:
 *
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 */
class LoadFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadDictionaries($manager);
        $this->loadUsers($manager);
        $this->loadAddresses($manager);
        $this->loadParcelsAndTasks($manager);
        $manager->flush();
    }

    private function loadDictionaries(ObjectManager $manager)
    {
        $city = new City();
        $city->setName('Szczecin');
        $manager->persist($city);

        $this->addReference('city', $city);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $annaAdmin = new User();
        $annaAdmin->setUsername('anna_admin');
        $annaAdmin->setEmail('anna_admin@symfony.com');
        $annaAdmin->addRole('ROLE_ADMIN');
        $encodedPassword = $passwordEncoder->encodePassword($annaAdmin, 'kitten');
        $annaAdmin->setPassword($encodedPassword);
        $annaAdmin->setEnabled(true);
        $manager->persist($annaAdmin);

        $this->addReference('admin', $annaAdmin);

        $johnPostman = new Postman();
        $johnPostman->setUsername('john_user');
        $johnPostman->setEmail('john_user@symfony.com');
        $encodedPassword = $passwordEncoder->encodePassword($johnPostman, 'kitten');
        $johnPostman->setPassword($encodedPassword);
        $johnPostman->setEnabled(true);
        $johnPostman->setName('John Postman');
        $johnPostman->setCity($this->getReference('city'));
        $manager->persist($johnPostman);

        $this->addReference('postman', $johnPostman);
    }

    private function loadAddresses(ObjectManager $manager)
    {
        $addressData = new AddressData();
        $addressData->setFirstName("Adam");
        $addressData->setLastName("Nowak");
        $addressData->setCity($this->getReference('city'));
        $addressData->setStreet("Wernychory");
        $addressData->setPostalCode("12-345");
        $addressData->setPhone('99-999-999');
        // TODO: Home nr
        $manager->persist($addressData);

        $this->addReference('address-data', $addressData);

        $addressData = new AddressData();
        $addressData->setFirstName("Janina");
        $addressData->setLastName("Kowalska");
        $addressData->setCity($this->getReference('city'));
        $addressData->setStreet("Sikorskiego");
        $addressData->setPostalCode("54-321");
        $addressData->setPhone('88-888-888');
        // TODO: Home nr
        $manager->persist($addressData);

        $this->addReference('address-data2', $addressData);
    }

    private function loadParcelsAndTasks(ObjectManager $manager)
    {
        $parcel = new Parcel();
        $parcel->setParcelHash("AAAA-BBBB-CCCC-DDDD"); // TODO: Generate
        $parcel->setNotes('Miejsce na uwagi');
        $manager->persist($parcel);

        $parcelOrder = new ParcelOrder();
        $parcelOrder->setSender($this->getReference('address-data'));
        $parcelOrder->setReceiver($this->getReference('address-data2'));
        $parcelOrder->setParcel($parcel);
        $parcelOrder->setStatus("?");
        $parcelOrder->setTracking(true);
        $manager->persist($parcelOrder);

        $task = new Task();
        $task->setPostman($this->getReference('postman'));
        $task->setParcelOrder($parcelOrder);
        $manager->persist($task);
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
