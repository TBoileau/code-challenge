<?php

namespace TBoileau\CodeChallenge\Domain\Tests\Security;

use Generator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use TBoileau\CodeChallenge\Domain\Security\Entity\Participant;
use TBoileau\CodeChallenge\Domain\Security\Gateway\ParticipantGateway;
use TBoileau\CodeChallenge\Domain\Security\Presenter\UpdateProfilePresenterInterface;
use TBoileau\CodeChallenge\Domain\Security\Provider\UploaderProviderInterface;
use TBoileau\CodeChallenge\Domain\Security\Request\UpdateProfileRequest;
use TBoileau\CodeChallenge\Domain\Security\Response\UpdateProfileResponse;
use TBoileau\CodeChallenge\Domain\Security\Uploader\Uploader;
use TBoileau\CodeChallenge\Domain\Security\UseCase\UpdateProfile;
use TBoileau\CodeChallenge\Domain\Tests\Fixtures\Adapter\ParticipantRepository;

class UpdateProfileTest extends TestCase
{

    private ParticipantRepository $participantGateway;

    private UpdateProfilePresenterInterface $presenter;

    private UploaderProviderInterface $uploaderProvider;

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
        $this->uploaderProvider = new class implements UploaderProviderInterface {
            public function upload(Uploader $uploader): string
            {
                return $uploader->getOriginalName();
            }
        };
    }

    public function testUpdateSuccessful(): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uploaderProvider);

        $request = new UpdateProfileRequest(Uuid::uuid4(), 'user@email.com', 'user');

        $useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(UpdateProfileResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());
        $this->assertEquals('user_update', $this->presenter->response->getParticipant()->getPseudo());
        $this->assertEquals('user_update@email.com', $this->presenter->response->getParticipant()->getEmail());
    }

    public function testUploadAvatarValid(): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uploaderProvider);

        $request = new UpdateProfileRequest(
            Uuid::uuid4(),
            'user@email.com',
            'user',
            new Uploader(dirname(__DIR__) . '/Fixtures/avatars/avatar.jpg', 'avatar.jpg')
        );

        $useCase->execute($request, $this->presenter);

        $this->assertEquals('avatar.jpg', $this->presenter->response->getParticipant()->getAvatar());
    }

    /**
     * @dataProvider providerFailedAvatar
     */
    public function testUploadAvatarFailed(string $avatarPath): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uploaderProvider);

        $request = new UpdateProfileRequest(
            Uuid::uuid4(),
            'user@email.com',
            'user',
            new Uploader('/path', $avatarPath)
        );

        $useCase->execute($request, $this->presenter);

        $this->assertTrue($this->presenter->response->hasErrors());
    }

    /**
     * @dataProvider provideFailedRequestData
     */
    public function testUpdateWithValidationError(string $email, string $pseudo): void
    {
        $useCase = new UpdateProfile($this->participantGateway, $this->uploaderProvider);

        $request = new UpdateProfileRequest(Uuid::uuid4(), $email, $pseudo);

        $useCase->execute($request, $this->presenter);

        $this->assertTrue($this->presenter->response->hasErrors());
    }

    /**
     * Check that the validation of emails and pseudo are not activated if the data in the request are the same
     * as retrieved in database (data has not been edited)
     */
    public function testNonValidationErrorIfNotEditData(): void
    {
        $participantGateway = new class implements ParticipantGateway {
            public function getParticipantByEmail(string $email): ?Participant
            {
                return null;
            }

            public function getParticipantById(string $id): ?Participant
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

        $useCase = new UpdateProfile($participantGateway, $this->uploaderProvider);

        $request = new UpdateProfileRequest(Uuid::uuid4(), 'foo@email.com', 'foo_pseudo');

        $useCase->execute($request, $this->presenter);

        $this->assertInstanceOf(UpdateProfileResponse::class, $this->presenter->response);
        $this->assertInstanceOf(Participant::class, $this->presenter->response->getParticipant());
        $this->assertEquals('foo_pseudo', $this->presenter->response->getParticipant()->getPseudo());
        $this->assertEquals('foo@email.com', $this->presenter->response->getParticipant()->getEmail());
    }

    public function providerFailedAvatar(): Generator
    {
        yield [''];
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
