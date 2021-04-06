<?php declare(strict_types=1);

namespace MF\ConsoleSubscriber\Subscriber;

use MF\ConsoleSubscriber\Event\MessageEvent;
use MF\ConsoleSubscriber\Event\NoteEvent;
use MF\ConsoleSubscriber\Event\ProgressAdvanceEvent;
use MF\ConsoleSubscriber\Event\ProgressFinishedEvent;
use MF\ConsoleSubscriber\Event\ProgressStartEvent;
use MF\ConsoleSubscriber\Event\SectionEvent;
use MF\ConsoleSubscriber\Event\TableEvent;
use MF\ConsoleSubscriber\Service\MessageFormatter;
use MF\ConsoleSubscriber\Service\TableFormatter;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleSubscriber implements EventSubscriberInterface
{
    private ?SymfonyStyle $io = null;

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProgressStartEvent::class => ['onProgressStart'],
            ProgressAdvanceEvent::class => ['onProgressAdvance'],
            ProgressFinishedEvent::class => ['onProgressFinished'],
            SectionEvent::class => ['onSection'],
            NoteEvent::class => ['onNote'],
            TableEvent::class => ['onTable'],
            MessageEvent::class => ['onMessage'],
        ];
    }

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }

    public function onProgressStart(ProgressStartEvent $event): void
    {
        if ($this->io) {
            $this->io->progressStart($event->getCount());
        }
    }

    public function onProgressAdvance(ProgressAdvanceEvent $event): void
    {
        if ($this->io) {
            $this->io->progressAdvance();
        }
    }

    public function onProgressFinished(ProgressFinishedEvent $event): void
    {
        if ($this->io) {
            $this->io->progressFinish();

            $message = $event->getMessage();
            if (!empty($message)) {
                $this->io->success($message);
            }
        }
    }

    public function onSection(SectionEvent $event): void
    {
        if ($this->io) {
            $this->io->section($event->getSection());
        }
    }

    public function onNote(NoteEvent $event): void
    {
        if ($this->io) {
            $this->io->note($event->getNote());
        }
    }

    public function onTable(TableEvent $event): void
    {
        if ($this->io) {
            $this->io->table($event->getHeaders(), TableFormatter::formatRows($event->getRows()));
        }
    }

    public function onMessage(MessageEvent $event): void
    {
        if ($this->io) {
            $this->io->writeln(MessageFormatter::formatMessage($event->getMessage()));
        }
    }
}
