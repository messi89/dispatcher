<?php
/**
 * @author Ben Kuhl <bkuhl@indatus.com>
 */

use Mockery as m;
use Indatus\Dispatcher\Scheduler;
use Indatus\Dispatcher\ConfigResolver;

class TestConfigResolver extends TestCase
{

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testLoadingPackagedDriver()
    {
        $resolver = new ConfigResolver();
        $this->assertInstanceOf(
            'Indatus\Dispatcher\Drivers\Cron\Scheduler',
            $resolver->resolveDriverClass('Scheduler')
        );
    }

    public function testLoadingPackagedDriverWithArguments()
    {
        $args = array('testArgument');
        $resolver = new ConfigResolver();

        /** @var \Indatus\Dispatcher\Scheduling\Schedulable $scheduler */
        $scheduler = $resolver->resolveDriverClass('Scheduler', $args);
        $this->assertEquals(
            $args,
            $scheduler->getArguments()
        );
    }

    public function testLoadingCustomDriver()
    {
        Config::shouldReceive('get')->andReturn('Indatus\Dispatcher\Drivers\Cron');
        $resolver = new ConfigResolver();
        $this->assertInstanceOf(
            'Indatus\Dispatcher\Scheduling\Schedulable',
            $resolver->resolveDriverClass('Scheduler')
        );
    }

}