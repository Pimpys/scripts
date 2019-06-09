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

class EditDbConfigProd extends EditDbConfig
{
    protected static $defaultName = 'db-edit-prod';

    protected function configure()
    {
        $this->file = 'config/db.php';
        $this->setDescription('Редактирует файл настроек для боевого сервера.')
            ->setHelp('Эта команда позволяет изменить файл настроек для боевого сервера.');
        parent::configure();
    }
}