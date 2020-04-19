<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

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
