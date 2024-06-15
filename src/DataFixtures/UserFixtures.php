<?php

            namespace App\DataFixtures;

            use App\Entity\User;
            use Doctrine\Bundle\FixturesBundle\Fixture;
            use Doctrine\ORM\EntityManagerInterface;
            use Doctrine\Persistence\ObjectManager;
            use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

            class UserFixtures extends Fixture
            {
                private $passwordEncoder;
                public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordEncoderInterface)
                {
                    $this->passwordEncoder = $userPasswordEncoderInterface;
                }

                public function load(ObjectManager $manager): void
                {
                    // $product = new Product();
                    // $manager->persist($product);
                    $userAdmin = new User();
                    $userAdmin->setUsername('admin');
                    $userAdmin->setPassword($this->passwordEncoder->hashPassword($userAdmin, 'admin'));
                    $userAdmin->setRoles(array('ROLE_ADMIN'));
                    $manager->persist($userAdmin);

                    $manager->flush();
                }
            }