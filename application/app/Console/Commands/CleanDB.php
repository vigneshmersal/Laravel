<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use InvalidArgumentException;
use DB;

class CleanDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try{

            $tables = array_map('reset', DB::select('SHOW TABLES'));
            if(!empty($tables)){
                DB::beginTransaction();
                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                foreach ($tables as $table) {
                    if($table !== env('DB_TABLE_PREFIX',FALSE) . 'postal_codes'){
                        $res = DB::statement('DROP TABLE '.$table);
                        echo '"' . $table .'" deleted from database'.PHP_EOL;
                    }

                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                DB::commit();

            }else{
                throw new InvalidArgumentException('Database clean failed');
            }
        } catch (\Exception $e){
            throw new InvalidArgumentException('Database clean failed : ' . $e->getMessage());
        }
    }
}
