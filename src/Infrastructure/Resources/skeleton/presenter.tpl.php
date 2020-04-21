<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use <?= str_replace("Presenter", "Response", $namespace); ?>\<?= $responseClassName ?>;

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
