<?php

namespace Kumamidori\ExampleAuraDiLazyNew;

use Aura\Di\Injection\Factory;
use Aura\Di\Injection\LazyNew;
use Aura\Di\Resolver\Blueprint;
use Aura\Di\Resolver\Reflector;
use Aura\Di\Resolver\Resolver;
use PHPUnit\Framework\TestCase;

class LazyNewTest extends TestCase
{
    public function testNewLazyNewReturnsLazyNew()
    {
        $object = new LazyNew(new Resolver(new Reflector()), new Blueprint(FakeFoo::class));
        $this->assertInstanceOf(LazyNew::class, $object);
    }

    public function testLazyNewInvokeReturnsInstanceCaseNormalInvoke()
    {
        $object = new LazyNew(new Resolver(new Reflector()), new Blueprint(FakeFoo::class));
        $invoked = $object();

        $this->assertInstanceOf(FakeFoo::class, $invoked);
    }

    public function testLazyNewReflectionClassReturnsFactory()
    {
        $object = new LazyNew(new Resolver(new Reflector()), new Blueprint(FakeFoo::class));
        $method = '__invoke';

        // reflect on the object method
        $reflect = new \ReflectionMethod($object, $method);

        $this->assertNotSame(LazyNew::class, $reflect->class);
        $this->assertSame(Factory::class, $reflect->class);

        $invoked = $reflect->invokeArgs($object, []);

        $this->assertInstanceOf(FakeFoo::class, $invoked);
    }
}
