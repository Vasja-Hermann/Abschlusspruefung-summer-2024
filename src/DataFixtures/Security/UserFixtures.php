<?php

namespace App\DataFixtures\Security;


use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const USER_NAME = "administrator";
    private const USER_PASSWORD = "55555";

    private UserPasswordHasherInterface $userPasswordHasher;


    /**
     * UserFixtures constructor.
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setRoles([
            'ROLE_USER',
            'ROLE_ADMIN'
        ]);

        $user->setUsername(UserFixtures::USER_NAME);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, UserFixtures::USER_PASSWORD)
        );

        $manager->persist($user);
        $manager->flush();
    }
}