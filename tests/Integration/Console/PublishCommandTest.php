<?php
declare(strict_types=1);

namespace Headsnet\LivingDocumentationBundle\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class PublishCommandTest extends KernelTestCase
{
    #[Test]
    public function will_execute(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('headsnet:livedoc:publish');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--output' => 'var/tests/output/',
            'namespace' => 'Headsnet\\LivingDocumentationBundle\\Tests\\Util\\Entity',
        ]);

        $commandTester->assertCommandIsSuccessful();

        // the output of the command in the console
        //$output = $commandTester->getDisplay();
        //$this->assertStringContainsString('Username: Wouter', $output);

        // ...
    }
}
