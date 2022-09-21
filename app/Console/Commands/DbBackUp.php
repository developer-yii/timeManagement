<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will backup the MySQL database and store it as a sql file 2 times a day';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d-H-i') . ".sql";
        \Log::info($filename);

        $file_path = storage_path() . "/app/public/db-backup/" . $filename;
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " .$file_path;

        \Log::info($command);

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        Storage::disk('s3')->put("db-backup/".$filename, Storage::disk('public')->get('db-backup/' . $filename));

        if(file_exists($file_path)) {
            unlink($file_path);
        }
        return 0;
    }
}
