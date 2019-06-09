<?php
/**
 *Copyright (c)
 *http://maxsuccess.ru/
 *https://vk.com/pimpys
 *https://www.facebook.com/the.web.lessons/
 * Кодируй так, как будто человек,
 * поддерживающий твой код, - буйный психопат,
 * знающий, где ты живешь.
 * User: Max
 * Date: 08.06.2019
 * Time: 19:59
 */

namespace console\commands;

class EditDbConfigDev extends EditDbConfig
{
    protected static $defaultName = 'db-edit-dev';

    protected function configure()
    {
        $this->file = 'config/db-dev.php';
        $this->setDescription('Редактирует файл настроек для разработки.')
            ->setHelp('Эта команда позволяет изменить файл настроек для разработки со стандартными значениями...');
        parent::configure();
    }
}