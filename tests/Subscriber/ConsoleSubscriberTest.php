<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Subscriber;

use MF\ConsoleSubscriber\AbstractTestCase;
use MF\ConsoleSubscriber\Event\MessageEvent;
use MF\ConsoleSubscriber\Event\NoteEvent;
use MF\ConsoleSubscriber\Event\ProgressAdvanceEvent;
use MF\ConsoleSubscriber\Event\ProgressFinishedEvent;
use MF\ConsoleSubscriber\Event\ProgressStartEvent;
use MF\ConsoleSubscriber\Event\SectionEvent;
use MF\ConsoleSubscriber\Event\TableEvent;
use Mockery as m;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleSubscriberTest extends AbstractTestCase
{
    private ConsoleSubscriber $consoleSubscriber;

    /** @var SymfonyStyle|m\MockInterface */
    private $io;

    protected function setUp(): void
    {
        $this->consoleSubscriber = new ConsoleSubscriber();

        $this->io = m::spy(SymfonyStyle::class);
    }

    public function testShouldSubscribeToSymfonyConsoleEvents(): void
    {
        $expected = [
            ProgressStartEvent::class => ['onProgressStart'],
            ProgressAdvanceEvent::class => ['onProgressAdvance'],
            ProgressFinishedEvent::class => ['onProgressFinished'],
            SectionEvent::class => ['onSection'],
            NoteEvent::class => ['onNote'],
            TableEvent::class => ['onTable'],
            MessageEvent::class => ['onMessage'],
        ];

        $events = ConsoleSubscriber::getSubscribedEvents();

        $this->assertCount(count($expected), $events);
        $this->assertEquals($expected, $events);
    }

    public function testShouldWorkWithoutSymfonyConsole(): void
    {
        $sectionEvent = new SectionEvent('section');

        $this->consoleSubscriber->onSection($sectionEvent);

        $this->assertTrue(true);
    }

    public function testShouldStartProgress(): void
    {
        $count = 5;
        $event = new ProgressStartEvent($count);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressStart($event);

        $this->io->shouldHaveReceived('progressStart')
            ->with($count)
            ->once();
    }

    public function testShouldAdvanceProgress(): void
    {
        $event = new ProgressAdvanceEvent();

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressAdvance($event);

        $this->io->shouldHaveReceived('progressAdvance')
            ->once();
    }

    public function testShouldFinishProgressWithoutMessage(): void
    {
        $event = new ProgressFinishedEvent();

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onProgressFinished($event);

        $this->io->shouldHaveReceived('progressFinish')
            ->once();
    }

    public function testShouldFinishProgressWithMessage(): void
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

    public function testShouldShowSection(): void
    {
        $message = 'Section';
        $event = new SectionEvent($message);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onSection($event);

        $this->io->shouldHaveReceived('section')
            ->with($message)
            ->once();
    }

    public function testShouldShowNote(): void
    {
        $message = 'Note';
        $event = new NoteEvent($message);

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onNote($event);

        $this->io->shouldHaveReceived('note')
            ->with($message)
            ->once();
    }

    public function testShouldShowTable(): void
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

    public function testShouldShowMessage(): void
    {
        $message = 'message %s';
        $event = new MessageEvent($message, 'args');
        $expectedMessage = 'message args';

        $this->consoleSubscriber->setIo($this->io);
        $this->consoleSubscriber->onMessage($event);

        $this->io->shouldHaveReceived('writeln')
            ->with($expectedMessage)
            ->once();
    }
}
