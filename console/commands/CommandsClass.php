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
 * Date: 09.06.2019
 * Time: 16:58
 */

namespace console\commands;


class CommandsClass
{
    public static function getClasses()
    {
        return [
            EditDbConfigDev::class,
            EditDbConfigProd::class,
            ChangeDbSettingsToDev::class,
            ChangeDbSettingsToProd::class
        ];
    }
}