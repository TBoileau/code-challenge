<?php

namespace App\Infrastructure\Doctrine\DataFixtures;

use App\Infrastructure\Doctrine\Entity\DoctrineParticipant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class UserFixtures
 * @package App\Infrastructure\Doctrine\DataFixtures
 */
class UserFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new DoctrineParticipant();
        $user->setId(Uuid::uuid4());
        $user->setPseudo("used_pseudo");
        $user->setEmail("used@email.com");
        $user->setPassword(password_hash("password", PASSWORD_ARGON2I));
        // $user->setPasswordResetToken('bb4b5730-6057-4fa1-a27b-692b9ba8c14a');
        // $user->setPasswordResetRequestedAt(new \DateTimeImmutable());
        $manager->persist($user);
        $manager->flush();
    }
}
