<?php echo "<?php\n" ?>

namespace <?php echo $namespace; ?>;

use <?php echo $presenterNamespace ?>;
use <?php echo $requestNamespace ?>;
use <?php echo $responseNamespace ?>;
use <?php echo $useCaseNamespace ?>;
use PHPUnit\Framework\TestCase;

/**
 * Class <?php echo $className; ?><?php echo "\n" ?>
 * @package <?php echo $namespace; ?><?php echo "\n" ?>
 */
class <?php echo $className; ?> extends TestCase
{
    public function test(): void
    {
        $request = new <?php echo $requestClassName; ?>();

        $presenter = new class() implements <?php echo $presenterInterfaceName; ?> {
            public <?php echo $responseClassName ?> $response;

            public function present(<?php echo $responseClassName ?> $response): void
            {
                $this->response = $response;
            }
        };

        $useCase = new <?php echo $useCaseClassName; ?>();

        $useCase->execute($request, $presenter);

        $this->assertInstanceOf(<?php echo $responseClassName ?>::class, $presenter->response);
    }
}
