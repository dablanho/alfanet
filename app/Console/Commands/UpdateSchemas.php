<?php

namespace App\Console\Commands;

use App\Models\Firma;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSchemas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateschemas {showSchemaNames?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Şemalar Güncelleniyor';

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
     * @return mixed
     */
    public function handle()
    {
        $showSchemaNames = $this->argument('showSchemaNames');

        $sema=[];
        $firmalar=Firma::where("durum",1)->get();

        foreach ($firmalar as $firma)
        {
            $sema[$firma->getSchemaName()]=1;
        }


        $excludes = ["information_schema", "pg_catalog"];

        $dbs = DB::connection('pgsql')->select("SELECT schema_name FROM information_schema.schemata;");
        $dbname = env("DB_CONNECTION", "pgsql");
        foreach ($dbs as $db) {
            $name = $db->schema_name;
            if(isset($sema[$name]))
                $sema[$name]=0;
        }

        foreach ($sema as $index=>$value)
        {
            $name=trim($index);
            if($value==1 && strlen($name)>0)
            {
                DB::connection('pgsql')->select("CREATE schema ".$name.";");
            }

        }
        $dbs = DB::connection('pgsql')->select("SELECT schema_name FROM information_schema.schemata;");
        foreach ($dbs as $db) {
            $name = $db->schema_name;
            if (!in_array($name, $excludes) && (strpos($name,"pg_")===false)) {
                if(empty($showSchemaNames))
                    echo $name."\n";
                config(["database.connections.".$dbname.".schema" => $name]);
                $this->getLaravel()['db']->purge();
                $this->call('migrate', ['--force' => true]);
            }
        }
    }
}
