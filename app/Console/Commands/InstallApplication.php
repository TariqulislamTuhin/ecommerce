<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Enum\Role as UserPermission;
use App\Enum\Role as EnumRole;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InstallApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        try {

            $this->call('migrate:fresh');

            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            $this->createAllPermission();

            $this->info('Provide admin credentials info to create an admin user for you.');
            $name = $this->ask('Enter admin name');
            $email = $this->ask('Enter admin email');
            $password = $this->secret('Enter your admin password');
            $confirmPassword = $this->secret('Enter your password again');

            $this->info('Please wait, Creating an admin profile for you...');
            $validator = Validator::make(
                [
                    'name' =>  $name,
                    'email' =>  $email,
                    'password' =>  $password,
                    'confirmPassword' =>  $confirmPassword,
                ],
                [
                    'name'     => 'required|string',
                    'email'    => 'required|email|unique:users,email',
                    'password' => 'required',
                    'confirmPassword' => 'required|same:password',
                ]
            );
            if ($validator->fails()) {
                $this->info('User not created. See error messages below:');
                foreach ($validator->errors()->all() as $error) {
                    $this->error($error);
                }
                return;
            }
            $user = User::create([
                'name' =>  $name,
                'email' =>  $email,
                'password' =>  Hash::make($password),
                'registration_method' => 'local',
            ]);
            $user->email_verified_at = now()->timestamp;
            $user->save();
            $profile = Profile::create(['user_id' => $user->id]);
            $user->profile()->save($profile);
            $permissions = Permission::all();
            $user->givePermissionTo($permissions);
            Role::findByName(EnumRole::SUPER_ADMIN->value)->givePermissionTo($permissions);
            $user->assignRole(EnumRole::SUPER_ADMIN->value);
            $this->info('User Creation Successful!');
            $this->call('optimize:clear');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function createAllPermission()
    {
        Permission::firstOrCreate(['name' => 'category view']);
        Permission::firstOrCreate(['name' => 'category add']);
        Permission::firstOrCreate(['name' => 'category edit']);
        Permission::firstOrCreate(['name' => 'category delete']);
        Permission::firstOrCreate(['name' => 'subcategory view']);
        Permission::firstOrCreate(['name' => 'subcategory add']);
        Permission::firstOrCreate(['name' => 'subcategory edit']);
        Permission::firstOrCreate(['name' => 'subcategory delete']);
        Permission::firstOrCreate(['name' => 'product view']);
        Permission::firstOrCreate(['name' => 'product add']);
        Permission::firstOrCreate(['name' => 'product edit']);
        Permission::firstOrCreate(['name' => 'product delete']);
        Permission::firstOrCreate(['name' => 'size view']);
        Permission::firstOrCreate(['name' => 'size add']);
        Permission::firstOrCreate(['name' => 'size edit']);
        Permission::firstOrCreate(['name' => 'size delete']);
        Permission::firstOrCreate(['name' => 'color view']);
        Permission::firstOrCreate(['name' => 'color add']);
        Permission::firstOrCreate(['name' => 'color edit']);
        Permission::firstOrCreate(['name' => 'color delete']);
        Permission::firstOrCreate(['name' => 'coupon view']);
        Permission::firstOrCreate(['name' => 'coupon add']);
        Permission::firstOrCreate(['name' => 'coupon edit']);
        Permission::firstOrCreate(['name' => 'coupon delete']);
        Permission::firstOrCreate(['name' => 'assign user']);
        Permission::firstOrCreate(['name' => 'customer dashboard access']);

        Role::findOrCreate(EnumRole::SUPER_ADMIN->value);
        Role::findOrCreate(EnumRole::ADMIN->value);
        Role::findOrCreate(EnumRole::TEACHER->value);
        Role::findOrCreate(EnumRole::STUDENT->value);
    }
}
