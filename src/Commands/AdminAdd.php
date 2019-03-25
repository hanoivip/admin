<?php

namespace Hanoivip\Admin\Commands;

use Illuminate\Console\Command;
use Hanoivip\Admin\UserRole;

class AdminAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:add {uid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to admin by Id';

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
        $uid = $this->argument('uid');
        $role = new UserRole();
        $role->user_id = $uid;
        $role->role = 'admin';
        $role->save();
    }
}
