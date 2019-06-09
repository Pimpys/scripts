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
 * Time: 0:08
 */

namespace console\commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class EditDbConfig extends Command
{
    protected $file;

    protected function configure()
    {
        $this->addArgument('username', InputArgument::OPTIONAL, 'Имя пользователя базы данных:', 'root')
            ->addArgument('password', InputArgument::OPTIONAL, 'Пароль от базы данных:', 'password')
            ->addArgument('dbname', InputArgument::OPTIONAL, 'Название базы:', 'default');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists($this->file) or empty($this->file)){
            throw new \RuntimeException('Файл: ' . $this->file . ' не найден!');
        }
        $helper = $this->getHelper('question');

        $output->writeln([
            '<info>Редактирование файла настроек: ' . $this->file,
            '============',
            '</info>',
        ]);

        $question = new Question('<comment>Имя пользователя базы данных: </comment>', $input->getArgument('username'));
        $username = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Пароль от базы данных: </comment>', $input->getArgument('password'));
        $password = $helper->ask($input, $output, $question);

        $question = new Question('<comment>Название базы: </comment>', $input->getArgument('dbname'));
        $dbname = $helper->ask($input, $output, $question);

        $output->writeln('Username: ' . $username);
        $output->writeln('Password: ' . $password);
        $output->writeln('Data Base: ' . $dbname);
        $question = new ConfirmationQuestion('<question>Сохранить?(y/Enter). Отмена: n</question> ', true);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln('Прерываю...');
            return;
        }
        $params = [
            'username' => $username,
            'password' => $password,
            'dbname' => $dbname,
        ];

        foreach ($params as $key => $value):
            $output->writeln($this->save($this->file, $key, $value));
        endforeach;

        $output->writeln('<info>Редактирование файла настроек: ' . $this->file . ' успешно завершенно. </info>');
    }

    private function save($config, $key, $value): string
    {
        if (false !== strpos($key, "dbname")){
            return $this->changeDb($config, $key, $value);
        }
        return $this->change("/((\"|')$key(\"|')\s*=>\s*)(\"\"|''|\"[\w-]+\"|'[\w-]+')/", $config, $key, $value);
    }

    private function changeDb($config, $key, $value): string
    {
        return $this->change("/'mysql:host=localhost;$key=[\w-]+'/", $config, $key, 'mysql:host=localhost;' . $key . '=' . $value);
    }

    private function change($pattern, $config, $key, $value): string
    {
        if (is_file($config)) {
            $content = preg_replace($pattern, "\\1'{$value}'", file_get_contents($config), -1, $count);
            if ($count > 0) {
                file_put_contents($config, $content);
                return 'Успех! Обработан: ' . $key . ' новое значение: ' . $value . ' записанно';
            }
        }
        return '<error>Ошибка! Совпадения для: "' . $key . '" не найдены...</error>';
    }
}