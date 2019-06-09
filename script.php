#!/usr/bin/env php
<?php
/**
 *Copyright (c)
 *http://maxsuccess.ru/
 *https://vk.com/maxkyivua
 * Кодируй так, как будто человек,
 * поддерживающий твой код, - буйный психопат,
 * знающий, где ты живешь.
 * User: maxsuccess
 * Date: 07.06.19
 * Time: 14:52
 */

require __DIR__.'/vendor/autoload.php';

use console\commands\CommandsClass;
use Symfony\Component\Console\Application;

$application = new Application();

foreach (CommandsClass::getClasses() as $command){
    $application->add(new $command());
}

$application->run();
