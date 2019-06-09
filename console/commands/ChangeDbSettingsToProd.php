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
 * Time: 14:54
 */

namespace console\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeDbSettingsToProd extends Command
{
    protected static $defaultName = 'db-prod';
    private $config = 'config/web.php';


    protected function configure()
    {
        $this->setDescription('Подключает файл настроек для рабочего окружения.')
            ->setHelp('Эта команда подключит файл настроек для боевого сервера...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists('config/db.php')){
            throw new \RuntimeException('Файла config/db.php, нет!');
        }

        $output->writeln([
            'Подключаю файл настроек для разработки config/db.php',
            '============',
            '',
        ]);

        $output->writeln($this->change($this->config));

        $output->writeln('Настроенно <info>рабочее</info> окружение!');
    }

    private function change($config): string
    {
        if (is_file($config)) {
            $content = preg_replace('/\/db-dev.php/', "\\1/db.php", file_get_contents($config), -1, $count);
            if ($count > 0) {
                file_put_contents($config, $content);
                copy('./vendor/maxsuccess/console-scripts/web/index-prod.php', 'web/index.php');
                return '<info>Успех! Файл обработан!</info>';
            }
        }
        return '<error>Ошибка! Совпадения не найдены...</error>';
    }
}