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

class ChangeDbSettingsToDev extends Command
{

    protected static $defaultName = 'db-dev';
    private $file = 'config/db-dev.php';
    private $config = 'config/web.php';

    protected function configure()
    {
        $this->setDescription('Создает файл настроек для разработки.')
            ->setHelp('Эта команда создаст файл настроек для разработки со стандартными значениями...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists($this->file)){
            $this->createFile($this->file);
        }

        $output->writeln([
            'Подключаю файл настроек для разработки ' . $this->file,
            '============',
            '',
        ]);

        $output->writeln($this->Change($this->config));

        $output->writeln('Настроенно окружение <info>разработки!</info>');
    }

    private function change($config): string
    {
        if (is_file($config)) {
            $content = preg_replace('/\/db.php/', "\\1/db-dev.php", file_get_contents($config), -1, $count);
            if ($count > 0) {
                file_put_contents($config, $content);
                copy('./vendor/maxsuccess/console-scripts/web/index-dev.php', 'web/index.php');
                return '<info>Успех! Файл обработан!</info>';
            }
        }
        return '<error>Ошибка! Совпадения не найдены...</error>';
    }

    private function createFile($file)
    {
        if (!copy('config/db.php', $file)){
            throw new \RuntimeException('Не удалось создать файл ' . $file . '! Возмножно, что не существует config/db.php или нет прав на запись.');
        }
    }
}