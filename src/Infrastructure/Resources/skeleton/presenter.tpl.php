<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

/**
 * Interface <?= $className; ?><?= "\n" ?>
 * @package <?= $namespace; ?><?= "\n" ?>
 */
interface <?= $className; ?><?= "\n" ?>
{
    /**
     * @param <?= $responseClassName ?> $response
     */
    public function present(<?= $responseClassName ?> $response): void;
}
