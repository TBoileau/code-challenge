<?php echo "<?php\n" ?>

namespace <?php echo $namespace; ?>;

use <?php echo str_replace("UseCase", "Request", $namespace); ?>\<?php echo $requestClassName ?>;
use <?php echo str_replace("UseCase", "Response", $namespace); ?>\<?php echo $responseClassName ?>;
use <?php echo str_replace("UseCase", "Presenter", $namespace); ?>\<?php echo $presenterInterfaceName ?>;

/**
 * Class <?php echo $className; ?><?php echo "\n" ?>
 * @package <?php echo $namespace; ?><?php echo "\n" ?>
 */
class <?php echo $className; ?><?php echo "\n" ?>
{
    /**
     * @param <?php echo $requestClassName ?> $request
     * @param <?php echo $presenterInterfaceName ?> $presenter
     */
    public function execute(<?php echo $requestClassName ?> $request, <?php echo $presenterInterfaceName ?> $presenter)
    {
        $presenter->present(new <?php echo $responseClassName ?>());
    }
}
