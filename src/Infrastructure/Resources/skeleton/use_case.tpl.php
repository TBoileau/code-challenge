<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use <?= str_replace("UseCase", "Request", $namespace); ?>\<?= $requestClassName ?>;
use <?= str_replace("UseCase", "Response", $namespace); ?>\<?= $responseClassName ?>;
use <?= str_replace("UseCase", "Presenter", $namespace); ?>\<?= $presenterInterfaceName ?>;

/**
 * Class <?= $className; ?><?= "\n" ?>
 * @package <?= $namespace; ?><?= "\n" ?>
 */
class <?= $className; ?><?= "\n" ?>
{
    /**
     * @param <?= $requestClassName ?> $request
     * @param <?= $presenterInterfaceName ?> $presenter
     */
    public function execute(<?= $requestClassName ?> $request, <?= $presenterInterfaceName ?> $presenter)
    {
        $presenter->present(new <?= $responseClassName ?>());
    }
}
