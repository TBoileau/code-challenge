<?php

namespace App\Infrastructure\Security\Provider;

use App\Infrastructure\Security\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;

/**
 * Class UserProvider
 * @package App\Infrastructure\Security\Provider
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var ParticipantGateway
     */
    private ParticipantGateway $participantGateway;

    /**
     * UserProvider constructor.
     * @param ParticipantGateway $participantGateway
     */
    public function __construct(ParticipantGateway $participantGateway)
    {
        $this->participantGateway = $participantGateway;
    }

    /**
     * @inheritDoc
     */
    public function loadUserByUsername(string $username)
    {
        return $this->getUserByUsername($username);
    }

    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->getUserByUsername($user->getUsername());
    }

    /**
     * @param string $username
     * @return User
     */
    private function getUserByUsername(string $username): User
    {
        $participant = $this->participantGateway->getParticipantByEmail($username);
        if ($participant === null) {
            throw new UsernameNotFoundException();
        }

        return new User($participant);
    }

    /**
     * @inheritDoc
     */
    public function supportsClass(string $class)
    {
        return $class === User::class;
    }
}
