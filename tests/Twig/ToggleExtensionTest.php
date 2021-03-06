<?php

namespace Flagception\Tests\FlagceptionBundle\Twig;

use Flagception\Manager\FeatureManagerInterface;
use Flagception\Model\Context;
use Flagception\Bundle\FlagceptionBundle\Twig\ToggleExtension;
use PHPUnit\Framework\TestCase;

/**
 * Class ToggleExtensionTest
 *
 * @author Michel Chowanski <michel.chowanski@bestit-online.de>
 * @package Flagception\Tests\FlagceptionBundle\Twig
 */
class ToggleExtensionTest extends TestCase
{
    /**
     * Test functions
     *
     * @return void
     */
    public function testFunctions()
    {
        $extension = new ToggleExtension($this->createMock(FeatureManagerInterface::class));

        static::assertEquals('feature', $extension->getFunctions()[0]->getName());
        static::assertEquals('active feature', $extension->getTests()[0]->getName());
    }

    /**
     * Test is active
     *
     * @return void
     */
    public function testIsActive()
    {
        $extension = new ToggleExtension($manager = $this->createMock(FeatureManagerInterface::class));

        $manager
            ->method('isActive')
            ->with('feature_foo')
            ->willReturn(true);

        static::assertEquals(true, $extension->isActive('feature_foo'));
    }

    /**
     * Test is active with context
     *
     * @return void
     */
    public function testIsActiveWithContext()
    {
        $extension = new ToggleExtension($manager = $this->createMock(FeatureManagerInterface::class));

        $context = new Context();
        $context->add('role', 'ROLE_ADMIN');

        $manager
            ->method('isActive')
            ->with('feature_foo', $context)
            ->willReturn(true);

        static::assertEquals(true, $extension->isActive('feature_foo', ['role' => 'ROLE_ADMIN']));
    }

    /**
     * Test get name
     *
     * @return void
     */
    public function testGetName()
    {
        $extension = new ToggleExtension($this->createMock(FeatureManagerInterface::class));
        static::assertEquals('flagception', $extension->getName());
    }
}
