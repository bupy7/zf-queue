zf-queue
========

2.0.0 [2020-11-28]
------------------

- Enh: Migrated Zend-packages to Laminas-packages.

1.0.3 [2020-02-11]
------------------

- Enh: Support PHP 7.3, 7.4.

1.0.2 [2017-11-23]
------------------

- Enh: Stability.

1.0.1 [2017-11-22]
------------------

- Fix: Skiped the param in the `Bupy7\Queue\Manager\EntityManagerInterface::flush()` method.
- Enh: Small enhancements.
- Add: `executed` event in the `Bupy7\Queue\Service\QueueService`. 

1.0.0 [2017-09-13]
------------------

- First stable version.

1.0.0-alpha.2 [2017-09-09]
--------------------------

- Enh: Drop `Bupy7\Queue\Service\TaskService` and
moved `Bupy7\Queue\Service\TaskService::add()` method
to `Bupy7\Queue\Service\QueueService::add()`.
- Fix: Small bugs.
- Enh: Tests.

1.0.0-alpha [2017-09-08]
------------------------

- First release.
