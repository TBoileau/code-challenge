<?php

namespace App\Infrastructure\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IntegrationTestCase
 *
 * @package App\Infrastructure\Test
 */
abstract class IntegrationTestCase extends WebTestCase
{
    /**
     * @inheritDoc
     */
    protected static function createClient(array $options = [], array $server = [])
    {
        return parent::createClient(array_merge($options, ["environment" => "integration"]), $server);
    }
}
