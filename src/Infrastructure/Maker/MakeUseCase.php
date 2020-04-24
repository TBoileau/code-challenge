<?php

namespace App\Infrastructure\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class MakeUseCase
 *
 * @package App\Infrastructure\Maker
 */
class MakeUseCase extends AbstractMaker
{
    /**
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'maker:use-case';
    }

    /**
     * @param Command            $command
     * @param InputConfiguration $inputConfig
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription("Create a new use case.")
            ->addArgument('domain', InputArgument::OPTIONAL, 'Select the domain name.')
            ->addArgument('name', InputArgument::OPTIONAL, 'Choose a name for your new use case.');
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $domainDir = sprintf(
            __DIR__ . '/../../../domain/src/%s',
            Str::asCamelCase($input->getArgument("domain"))
        );

        $domainTestDir = sprintf(
            __DIR__ . '/../../../domain/tests/%s',
            Str::asCamelCase($input->getArgument("domain"))
        );

        if (!is_dir($domainDir)) {
            mkdir($domainDir);
        }

        if (!is_dir($domainTestDir)) {
            mkdir($domainTestDir);
        }

        $testClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'TBoileau\\CodeChallenge\\Domain\\Tests',
            'Test'
        );

        $useCaseClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('TBoileau\\CodeChallenge\\Domain\\%s\\UseCase', Str::asCamelCase($input->getArgument("domain"))),
            ''
        );

        $requestClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('TBoileau\\CodeChallenge\\Domain\\%s\\Request', Str::asCamelCase($input->getArgument("domain"))),
            'Request'
        );

        $responseClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('TBoileau\\CodeChallenge\\Domain\\%s\\Response', Str::asCamelCase($input->getArgument("domain"))),
            'Response'
        );

        $presenterClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            sprintf('TBoileau\\CodeChallenge\\Domain\\%s\\Presenter', Str::asCamelCase($input->getArgument("domain"))),
            'PresenterInterface'
        );

        $generator->generateFile(
            sprintf(
                '%s/UseCase/%s.php',
                $domainDir,
                $useCaseClassNameDetails->getShortName()
            ),
            __DIR__ . '/../Resources/skeleton/use_case.tpl.php',
            [
                'className' => $useCaseClassNameDetails->getShortName(),
                "namespace" => sprintf(
                    'TBoileau\\CodeChallenge\\Domain\\%s\\UseCase',
                    Str::asCamelCase($input->getArgument("domain"))
                ),
                'requestClassName' => $requestClassNameDetails->getShortName(),
                'responseClassName' => $responseClassNameDetails->getShortName(),
                'presenterInterfaceName' => $presenterClassNameDetails->getShortName()
            ]
        );

        $generator->generateFile(
            sprintf(
                '%s/Request/%s.php',
                $domainDir,
                $requestClassNameDetails->getShortName()
            ),
            __DIR__ . '/../Resources/skeleton/request.tpl.php',
            [
                'className' => $requestClassNameDetails->getShortName(),
                "namespace" => sprintf(
                    'TBoileau\\CodeChallenge\\Domain\\%s\\Request',
                    Str::asCamelCase($input->getArgument("domain"))
                )
            ]
        );

        $generator->generateFile(
            sprintf(
                '%s/Response/%s.php',
                $domainDir,
                $responseClassNameDetails->getShortName()
            ),
            __DIR__ . '/../Resources/skeleton/response.tpl.php',
            [
                'className' => $responseClassNameDetails->getShortName(),
                "namespace" => sprintf(
                    'TBoileau\\CodeChallenge\\Domain\\%s\\Response',
                    Str::asCamelCase($input->getArgument("domain"))
                )
            ]
        );

        $generator->generateFile(
            sprintf(
                '%s/Presenter/%s.php',
                $domainDir,
                $presenterClassNameDetails->getShortName()
            ),
            __DIR__ . '/../Resources/skeleton/presenter.tpl.php',
            [
                'className' => $presenterClassNameDetails->getShortName(),
                "namespace" => sprintf(
                    'TBoileau\\CodeChallenge\\Domain\\%s\\Presenter',
                    Str::asCamelCase($input->getArgument("domain"))
                ),
                'responseClassName' => $responseClassNameDetails->getShortName()
            ]
        );

        $generator->generateFile(
            sprintf(
                '%s/%s.php',
                $domainTestDir,
                $testClassNameDetails->getShortName()
            ),
            __DIR__ . '/../Resources/skeleton/test.tpl.php',
            [
                'className' => $testClassNameDetails->getShortName(),
                "namespace" => sprintf(
                    'TBoileau\\CodeChallenge\\Domain\\Tests\\%s',
                    Str::asCamelCase($input->getArgument("domain"))
                ),
                'useCaseClassName' => $useCaseClassNameDetails->getShortName(),
                'useCaseNamespace' => str_replace('App\\', '', $useCaseClassNameDetails->getFullName()),
                'requestClassName' => $requestClassNameDetails->getShortName(),
                'requestNamespace' => str_replace('App\\', '', $requestClassNameDetails->getFullName()),
                'responseClassName' => $responseClassNameDetails->getShortName(),
                'responseNamespace' => str_replace('App\\', '', $responseClassNameDetails->getFullName()),
                'presenterInterfaceName' => $presenterClassNameDetails->getShortName(),
                'presenterNamespace' => str_replace('App\\', '', $presenterClassNameDetails->getFullName())
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
