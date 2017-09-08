zf-queue
========

[![Latest Stable Version](https://poser.pugx.org/bupy7/zf-queue/v/stable)](https://packagist.org/packages/bupy7/zf-queue)
[![Total Downloads](https://poser.pugx.org/bupy7/zf-queue/downloads)](https://packagist.org/packages/bupy7/zf-queue)
[![Latest Unstable Version](https://poser.pugx.org/bupy7/zf-queue/v/unstable)](https://packagist.org/packages/bupy7/zf-queue)
[![License](https://poser.pugx.org/bupy7/zf-queue/license)](https://packagist.org/packages/bupy7/zf-queue)
[![Build Status](https://travis-ci.org/bupy7/zf-queue.svg?branch=master)](https://travis-ci.org/bupy7/zf-queue)
[![Coverage Status](https://coveralls.io/repos/github/bupy7/zf-queue/badge.svg?branch=master)](https://coveralls.io/github/bupy7/zf-queue?branch=master)

Abstract queue module for Zend Framework 3. Module contains **only** abstract layers to create
their own integrations using this module.

Installation
------------

The preferred way to install this extension is through composer.

Either run

```
$ php composer.phar require bupy7/zf-queue "*"
```

or add

```
"bupy7/zf-queue": "*"
```

to the require section of your composer.json file.

Integration
-----------

### Ready integrations

- [Doctrine 2 ORM](example/QueueDoctrine)

### Create their own integration

TODO

Usage
-----

### Create task

**Let's create our first an example task for queue:**

```php
// YourModule/src/task/ExampleTask.php

namespace YourModule\Task;

use Bupy7\Queue\Task\TaskInterface;
use Zend\Stdlib\ParametersInterface;
use Chat\Service\ChatService;

class SendAccountTask implements TaskInterface
{
    /**
     * @var ChatService
     */
    protected $chatService;

    public function __construct(ChatService $chatService) {
        $this->chatService = $chatService;
    }

    /**
     * @param ParametersInterface $params
     * - message (string)
     * @return bool
     */
    public function execute(ParametersInterface $params): bool
    {
        $this->chatService->send($params->get('message'));
        return true;
    }
}
```

### Run task

**After you need to register task to queue manager**:

```php
// YouModule/config/queue.config.php

namespace YourModule;

return [
    'queue_manager' => [
        'factories' => [
            Task\ExampleTask::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
    ],
];
```

**Now, add `queue.config.php` to your config list:**

```php
// YourModule/src/YourModule.php

class Module
{
    public function getConfig(): array
    {
        return array_merge(
            
            // another config files
            
            require __DIR__ . '/../config/queue.config.php'
        );
    }
}
```

**Add the task to queue**

```php
$container->get('Bupy7\Queue\Service\QueueService')->add('YourModule\Task\ExampleTask');
```

**Run queue**

```php
$container->get('Bupy7\Queue\Service\QueueService')->run();
```

License
-------

zf-queue is released under the BSD 3-Clause License.