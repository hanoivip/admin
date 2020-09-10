<?php

namespace Hanoivip\Admin\Commands;

use Illuminate\Console\Command;
use Hanoivip\Admin\Services\AdminService;

class AdminSupporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add-gm {uid} {display_name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to supporter gropu by Id';
    
    private $service;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AdminService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uid = $this->argument('uid');
        $name = $this->argument('display_name');
        $this->service->addRole($uid, $name, 'supporter');
        $this->info("done");
    }
}
