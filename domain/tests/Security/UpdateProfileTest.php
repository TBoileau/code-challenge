<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Assert\AssertionFailedException;
use Generator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Presenter\UpdateProfilePresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\UploaderProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\UpdateProfileRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;
use TBoileau\CodeChallenge\Domain\Security\UseCase\UpdateProfile;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

class UpdateProfileTest extends TestCase
{

    private ParticipantRepository $participantGateway;

    private UpdateProfilePresenterInterface $presenter;

    private UploaderProviderInterface $uplaoder;

    protected function setUp()
    {
        parent::setUp();

        $this->participantGateway = new ParticipantRepository();
        $this->presenter = new class implements UpdateProfilePresenterInterface {
            public ?UpdateProfileResponse $response = null;
            public function present(UpdateProfileResponse $response): void
            {
                $this->response = $response;
            }
        };
        $this->uplaoder = new class implements UploaderProviderInterface {
            public function upload(string $path): string
            {
                return 'avatar.jpg';
            }
        };
    }

    public function testUpdateSuccessful(): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uplaoder);

        $request = new UpdateProfileRequest(1, 'user@email.com', 'user');

        $useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(UpdateProfileResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());
        $this->assertEquals('user_update', $this->presenter->response->getParticipant()->getPseudo());
        $this->assertEquals('user_update@email.com', $this->presenter->response->getParticipant()->getEmail());
    }

    public function testUploadAvatarValid(): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uplaoder);

        $request = new UpdateProfileRequest(
            1,
            'user@email.com',
            'user',
            dirname(__DIR__) . '/Fixtures/avatars/avatar.jpg'
        );

        $useCase->execute($request, $this->presenter);

        $this->assertEquals('avatar.jpg', $this->presenter->response->getParticipant()->getAvatar());
    }

    /**
     * @dataProvider providerFailedAvatar
     * @throws AssertionFailedException
     */
    public function testUploadAvatarFailed(string $avatarPath): void
    {
        $this->expectException(AssertionFailedException::class);

        $useCase = new UpdateProfile($this->participantGateway, $this->uplaoder);

        $request = new UpdateProfileRequest(1, 'user@email.com', 'user', $avatarPath);

        $useCase->execute($request, $this->presenter);
    }

    /**
     * @dataProvider provideFailedRequestData
     * @throws AssertionFailedException
     */
    public function testUpdateWithValidationError(string $email, string $pseudo): void
    {
        $this->expectException(AssertionFailedException::class);

        $useCase = new UpdateProfile($this->participantGateway, $this->uplaoder);

        $request = new UpdateProfileRequest(1, $email, $pseudo);

        $useCase->execute($request, $this->presenter);
    }

    /**
     * Check that the validation of emails and pseudo are not activated if the data in the request are the same
     * as retrieved in database (data has not been edited)
     *
     * @throws AssertionFailedException
     */
    public function testNonValidationErrorIfNotEditData(): void
    {
        $participantGateway = new class implements ParticipantGateway {
            public function getParticipantByEmail(string $email): ?Participant
            {
            }

            public function getParticipantById(int $id): ?Participant
            {
                return new Participant(
                    Uuid::uuid4(),
                    'foo@email.com',
                    'foo_pseudo',
                    'password'
                );
            }

            public function isEmailUnique(?string $email): bool
            {
                return true;
            }

            public function isPseudoUnique(?string $pseudo): bool
            {
                return true;
            }

            public function register(Participant $participant): void
            {
            }

            public function update(Participant $participant): void
            {
            }
        };

        $useCase = new UpdateProfile($participantGateway, $this->uplaoder);

        $request = new UpdateProfileRequest(1, 'foo@email.com', 'foo_pseudo');

        $useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(UpdateProfileResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());
        $this->assertEquals('foo_pseudo', $this->presenter->response->getParticipant()->getPseudo());
        $this->assertEquals('foo@email.com', $this->presenter->response->getParticipant()->getEmail());
    }

    public function providerFailedAvatar(): Generator
    {
        yield [''];
        yield ['/fail/path/avatar.jpg'];
        yield ['/fail/path/avatar.gif'];
        yield ['/fail/path/avatar.pdf'];
        yield ['/fail/path/avatar.php'];
        yield ['/fail/path/avatar.'];
    }

    /**
     * @return Generator
     */
    public function provideFailedRequestData(): Generator
    {
        yield ["", "pseudo"];
        yield ["email", "pseudo"];
        yield ["email@email.com", ""];
    }
}
