QueueDoctrine
=============

Example usage [zf-queue](https://github.com/bupy7/zf-queue) package for Doctrine 2 ORM.

Requirements
------------

- [Doctrine 2 ORM](https://github.com/doctrine/DoctrineORMModule)
- [Laminas MVC](https://github.com/laminas/laminas-mvc)

Install
-------

1: Copy `QueueDoctrine` to your `module` directory.

2: Add `QueueDoctrine` to your config of module list.

3: Run create scheme:

```
$ console orm:schema-tool:create
```

> You must have console application to run this command.

4: Profit.

Usage
-----

1: [Create a task](https://github.com/bupy7/zf-queue#create-task)

2: Add the task to queue:

```php
$container->get('Bupy7\Queue\Service\QueueService')->add('Some\Task\TaskNameClass', [
    'some' => 'param', 
]);
```

3: Run queue:

```php
$container->get('Bupy7\Queue\Service\QueueService')->run();
```
