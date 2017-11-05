<?php

namespace MF\Tests\Subscriber;

use MF\ConsoleSubscriber\Event\NoteEvent;
use MF\ConsoleSubscriber\Event\ProgressAdvanceEvent;
use MF\ConsoleSubscriber\Event\ProgressFinishedEvent;
use MF\ConsoleSubscriber\Event\ProgressStartEvent;
use MF\ConsoleSubscriber\Event\SectionEvent;
use MF\ConsoleSubscriber\Event\TableEvent;
use MF\ConsoleSubscriber\Subscriber\ConsoleSubscriber;
use MF\Tests\AbstractTestCase;
use Mockery as m;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleSubscriberTest extends AbstractTestCase
{
    /** @var ConsoleSubscriber */
    private $consoleSubscriber;

    /** @var SymfonyStyle|m\MockInterface */
    private $io;

    public function setUp()
    {
        $this->consoleSubscriber = new ConsoleSubscriber();

        $this->io = m::spy(SymfonyStyle::class);
    }

    public function testShouldSubscribeToSymfonyConsoleEvents()
    {
        $expected = [
            ProgressStartEvent::class => ['onProgressStart'],
            ProgressAdvanceEvent::class => ['onProgressAdvance'],
            ProgressFinishedEvent::class => ['onProgressFinished'],
            SectionEvent::class => ['onSection'],
            NoteEvent::class => ['onNote'],
        ];

        $events = ConsoleSubscriber::getSubscribedEvents();

        $this->assertEquals($expected, $events);
    }

    public function testShouldWorkWithoutSymfonyConsole()
    {
        $sectionEvent = new SectionEvent('section');

        $this->consoleSubscriber->onSection($sectionEvent);

        $this->assertTrue(true);
    }

    public function testShouldStartProgress()
    {
        $count = 5;
        $event = new ProgressStartEvent($count);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressStart($event);

        $this->io->shouldHaveReceived('progressStart')
            ->with($count)
            ->once();
    }

    public function testShouldAdvanceProgress()
    {
        $event = new ProgressAdvanceEvent();

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressAdvance($event);

        $this->io->shouldHaveReceived('progressAdvance')
            ->once();
    }

    public function testShouldFinishProgressWithoutMessage()
    {
        $event = new ProgressFinishedEvent();

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressFinished($event);

        $this->io->shouldHaveReceived('progressFinish')
            ->once();
    }

    public function testShouldFinishProgressWithMessage()
    {
        $message = 'And it\'s done!';
        $event = new ProgressFinishedEvent($message);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressFinished($event);

        $this->io->shouldHaveReceived('progressFinish')
            ->once();
        $this->io->shouldHaveReceived('success')
            ->with($message)
            ->once();
    }

    public function testShouldShowSection()
    {
        $message = 'Section';
        $event = new SectionEvent($message);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onSection($event);

        $this->io->shouldHaveReceived('section')
            ->with($message)
            ->once();
    }

    public function testShouldShowNote()
    {
        $message = 'Note';
        $event = new NoteEvent($message);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onNote($event);

        $this->io->shouldHaveReceived('note')
            ->with($message)
            ->once();
    }

    public function testShouldShowTable()
    {
        $headers = ['id', 'name'];
        $rows = [
            [1, 'name 1'],
            [2, 'name 2'],
        ];
        $event = new TableEvent($headers, $rows);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onTable($event);

        $this->io->shouldHaveReceived('table')
            ->with($headers, $rows)
            ->once();
    }
}
