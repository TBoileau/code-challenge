<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use <?= $presenterNamespace ?>;
use <?= $requestNamespace ?>;
use <?= $responseNamespace ?>;
use <?= $useCaseNamespace ?>;
use PHPUnit\Framework\TestCase;

/**
 * Class <?= $className; ?><?= "\n" ?>
 * @package <?= $namespace; ?><?= "\n" ?>
 */
class <?= $className; ?> extends TestCase
{
    public function test(): void
    {
        $request = new <?= $requestClassName; ?>();

        $presenter = new class() implements <?= $presenterInterfaceName; ?> {
            public <?= $responseClassName ?> $response;

            public function present(<?= $responseClassName ?> $response): void
            {
                $this->response = $response;
            }
        };

        $useCase = new <?= $useCaseClassName; ?>();

        $useCase->execute($request, $presenter);

        $this->assertInstanceOf(<?= $responseClassName ?>::class, $presenter->response);
    }
}
