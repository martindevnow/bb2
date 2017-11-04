<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\InputArgument;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database {--email=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['email',  null, InputArgument::REQUIRED, 'Set 1 to email the backup', '0'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('email'))
        {
            $date = Carbon::now();
            $file = base_path() . '/database/backups/'. env('DB_DATABASE') .'_db_'
                . $date->format('Y-m-d') .'_'. $date->format('H:i') .'.sql';
        }

        $this->line('Generating SQL backup of table martioo7_itcdash:');
        $command = 'mysqldump -u '. escapeshellarg(env('DB_USERNAME'))
            .' -p'. escapeshellarg(env('DB_PASSWORD'))
            .' '. escapeshellarg(env('DB_DATABASE'))
            .' > "'. base_path() .'/database/backups/'. env('DB_DATABASE') .'_db_`TZ=America\/Toronto date +\%Y-\%m-\%d_\%H:\%M`.sql"';

        shell_exec($command);

        if ($this->option('email'))
        {
            $this->line('File being sent:');
            $this->line($file);

            if (file_exists($file))
            {
                Mail::send('emails.console.databaseBackup.attached', compact('date'), function($message) use ($file, $date) {
                    $message->to('the.one.martin@gmail.com', "B. Martin")
                        ->subject('DB Backup - '. env('DB_DATABASE') .' - '. Carbon::now()->format('Y-m-d'));
                    $message->from('backup@barfbento.com', 'DB Backups');
                    $message->attach($file);
                });
            }
            else{
                Mail::send('emails.console.databaseBackup.notFound', compact('date'), function($message) use ($file, $date) {
                    $message->to('the.one.martin@gmail.com', "B. Martin")
                        ->subject('DB Backup - File Not Found');
                    $message->from('errors@barfbento.com', 'Errors');
                });
            }
        }
    }
}
