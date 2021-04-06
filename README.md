Symfony Console Subscriber
==========================

[![Latest Stable Version](https://img.shields.io/packagist/v/mf/symfony-console-subscriber.svg)](https://packagist.org/packages/mf/symfony-console-subscriber)
[![Tests and linting](https://github.com/MortalFlesh/symfony-console-subscriber/actions/workflows/tests.yaml/badge.svg)](https://github.com/MortalFlesh/symfony-console-subscriber/actions/workflows/tests.yaml)
[![Coverage Status](https://coveralls.io/repos/github/MortalFlesh/symfony-console-subscriber/badge.svg?branch=master)](https://coveralls.io/github/MortalFlesh/symfony-console-subscriber?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/mf/symfony-console-subscriber.svg)](https://packagist.org/packages/mf/symfony-console-subscriber)
[![License](https://img.shields.io/packagist/l/mf/symfony-console-subscriber.svg)](https://packagist.org/packages/mf/symfony-console-subscriber)

Console Subscriber for Symfony Console.


## Installation
```bash
composer require mf/symfony-console-subscriber
```


## Usage

### Comparision
It is same as using `SymfonyStyle` directly, you just use `EventDispatcher` to handle your events.

`SymfonyStyle`
```php
$io->note('note');
    
// vs Dispatching
    
$eventDispatcher->dispatch(new NoteEvent('Some note.'));
```


### initialization
```php
$io = new SymfonyStyle();
$subscriber = new ConsoleSubscriber();

$subscriber->setIo($io);

$eventDispatcher->addSubscriber($subscriber);
```

### dispatch
Note
```php
$eventDispatcher->dispatch(new NoteEvent('Some note.'));
```

Progress
```php
$items = [1, 2, 3];
    
$eventDispatcher->dispatch(new ProgressStartEvent($items));

foreach($items as $i) {
    // do something
    
    $eventDispatcher->dispatch(new ProgressAdvanceEvent());
}

$eventDispatcher->dispatch(new ProgressFinishedEvent('All items were iterated!'));
```
