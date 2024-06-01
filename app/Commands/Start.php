<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Start extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'App';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'start:oriel-web';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = "Start Server on Port ".SITE_PORT;

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {   
        $_SERVER['argv'][2] = '--port';
        $_SERVER['argv'][3] = SITE_PORT;
        $_SERVER['argc']    = 4;        

        // $name = CLI::prompt("What is your name?");
        // CLI::newLine(1);
        // $email = CLI::prompt("Please provide your email address?");
        // CLI::newLine(1);
        // CLI::write("User Informations - Name: " . $name . " & Email: " . $email);
        // CLI::write();

        $asciiText = file_get_contents(ROOTPATH.'start-msg.txt');
        CLI::write($asciiText);
        CLI::write(' Version 1.0 by Iryanda Syamputra');

        CLI::newLine(1);
        CLI::newLine(1);
        CLI::showProgress(1, 10);
        CLI::newLine(1);
        CLI::newLine(1);
        CLI::write("*** ".SITE_NAME." Already Running ***", 'white', 'blue');
        CLI::newLine(1);
        CLI::newLine(1);

        CLI::write('PHP Version: '. CLI::color(phpversion(), 'yellow'));
        CLI::write('CI Version: '. CLI::color(\CodeIgniter\CodeIgniter::CI_VERSION, 'yellow'));
        CLI::write('APPPATH: '. CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: '. CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: '. CLI::color(ROOTPATH, 'yellow'));
        CLI::write('Included files: '. CLI::color(count(get_included_files()), 'yellow'));

        CLI::newLine(1);
        CLI::newLine(1);

        CLI::init();
        $this->call('serve');
    }
}

/**
    Start/Run command [ php spark make:command Start ] in terminal/CMD
*/
