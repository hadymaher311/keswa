<?php

use App\User;
use App\Models\Tag;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Review;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\warehouse;
use App\Models\SubCategory;
use App\Models\UserAddress;
use App\Models\GeneralSetting;
use App\Models\SubSubCategory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{

    public $permissions = array(
        array('id' => '1','name' => 'create permissions','guard_name' => 'admin','created_at' => '2019-06-16 18:06:21','updated_at' => '2019-06-16 18:06:21'),
        array('id' => '2','name' => 'update permissions','guard_name' => 'admin','created_at' => '2019-06-16 18:06:25','updated_at' => '2019-06-16 18:06:25'),
        array('id' => '3','name' => 'delete permissions','guard_name' => 'admin','created_at' => '2019-06-16 18:06:33','updated_at' => '2019-06-16 18:06:33'),
        array('id' => '4','name' => 'view permissions','guard_name' => 'admin','created_at' => '2019-06-16 18:06:41','updated_at' => '2019-06-16 18:06:41'),
        array('id' => '5','name' => 'create roles','guard_name' => 'admin','created_at' => '2019-06-16 18:06:52','updated_at' => '2019-06-16 18:06:52'),
        array('id' => '6','name' => 'update roles','guard_name' => 'admin','created_at' => '2019-06-16 18:06:57','updated_at' => '2019-06-16 18:06:57'),
        array('id' => '7','name' => 'delete roles','guard_name' => 'admin','created_at' => '2019-06-16 18:07:02','updated_at' => '2019-06-16 18:07:02'),
        array('id' => '8','name' => 'view roles','guard_name' => 'admin','created_at' => '2019-06-16 18:07:08','updated_at' => '2019-06-16 18:07:08'),
        array('id' => '9','name' => 'create brands','guard_name' => 'admin','created_at' => '2019-06-16 18:39:43','updated_at' => '2019-06-16 18:39:43'),
        array('id' => '10','name' => 'create admins','guard_name' => 'admin','created_at' => '2019-06-16 20:27:11','updated_at' => '2019-06-16 20:27:11'),
        array('id' => '11','name' => 'update admins','guard_name' => 'admin','created_at' => '2019-06-16 20:27:16','updated_at' => '2019-06-16 20:27:16'),
        array('id' => '12','name' => 'delete admins','guard_name' => 'admin','created_at' => '2019-06-16 20:27:21','updated_at' => '2019-06-16 20:27:21'),
        array('id' => '13','name' => 'view admins','guard_name' => 'admin','created_at' => '2019-06-16 20:27:33','updated_at' => '2019-06-16 20:27:33'),
        array('id' => '14','name' => 'update brands','guard_name' => 'admin','created_at' => '2019-06-16 20:27:49','updated_at' => '2019-06-16 20:27:49'),
        array('id' => '15','name' => 'delete brands','guard_name' => 'admin','created_at' => '2019-06-16 20:27:59','updated_at' => '2019-06-16 20:27:59'),
        array('id' => '16','name' => 'view brands','guard_name' => 'admin','created_at' => '2019-06-16 20:28:04','updated_at' => '2019-06-16 20:28:04'),
        array('id' => '17','name' => 'create categories','guard_name' => 'admin','created_at' => '2019-06-16 20:28:32','updated_at' => '2019-06-16 20:28:32'),
        array('id' => '18','name' => 'update categories','guard_name' => 'admin','created_at' => '2019-06-16 20:28:35','updated_at' => '2019-06-16 20:28:35'),
        array('id' => '19','name' => 'delete categories','guard_name' => 'admin','created_at' => '2019-06-16 20:28:38','updated_at' => '2019-06-16 20:28:38'),
        array('id' => '20','name' => 'view categories','guard_name' => 'admin','created_at' => '2019-06-16 20:28:43','updated_at' => '2019-06-16 20:28:43'),
        array('id' => '21','name' => 'create sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:29:01','updated_at' => '2019-06-16 20:29:01'),
        array('id' => '22','name' => 'update sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:29:04','updated_at' => '2019-06-16 20:29:04'),
        array('id' => '23','name' => 'delete sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:29:07','updated_at' => '2019-06-16 20:29:07'),
        array('id' => '24','name' => 'view sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:29:12','updated_at' => '2019-06-16 20:29:12'),
        array('id' => '25','name' => 'create users','guard_name' => 'admin','created_at' => '2019-06-16 20:29:19','updated_at' => '2019-06-16 20:29:19'),
        array('id' => '26','name' => 'update users','guard_name' => 'admin','created_at' => '2019-06-16 20:29:22','updated_at' => '2019-06-16 20:29:22'),
        array('id' => '27','name' => 'delete users','guard_name' => 'admin','created_at' => '2019-06-16 20:29:25','updated_at' => '2019-06-16 20:29:25'),
        array('id' => '28','name' => 'view users','guard_name' => 'admin','created_at' => '2019-06-16 20:29:28','updated_at' => '2019-06-16 20:29:28'),
        array('id' => '29','name' => 'create warehouses','guard_name' => 'admin','created_at' => '2019-06-16 20:29:45','updated_at' => '2019-06-16 20:29:45'),
        array('id' => '30','name' => 'update warehouses','guard_name' => 'admin','created_at' => '2019-06-16 20:29:48','updated_at' => '2019-06-16 20:29:48'),
        array('id' => '31','name' => 'delete warehouses','guard_name' => 'admin','created_at' => '2019-06-16 20:29:51','updated_at' => '2019-06-16 20:29:51'),
        array('id' => '32','name' => 'view warehouses','guard_name' => 'admin','created_at' => '2019-06-16 20:29:56','updated_at' => '2019-06-16 20:29:56'),
        array('id' => '33','name' => 'create products','guard_name' => 'admin','created_at' => '2019-06-16 20:31:10','updated_at' => '2019-06-16 20:31:10'),
        array('id' => '34','name' => 'update products','guard_name' => 'admin','created_at' => '2019-06-16 20:31:13','updated_at' => '2019-06-16 20:31:13'),
        array('id' => '35','name' => 'delete products','guard_name' => 'admin','created_at' => '2019-06-16 20:31:15','updated_at' => '2019-06-16 20:31:15'),
        array('id' => '36','name' => 'view products','guard_name' => 'admin','created_at' => '2019-06-16 20:31:18','updated_at' => '2019-06-16 20:31:18'),
        array('id' => '37','name' => 'create orders','guard_name' => 'admin','created_at' => '2019-06-16 20:31:24','updated_at' => '2019-06-16 20:31:24'),
        array('id' => '38','name' => 'update orders','guard_name' => 'admin','created_at' => '2019-06-16 20:31:26','updated_at' => '2019-06-16 20:31:26'),
        array('id' => '39','name' => 'delete orders','guard_name' => 'admin','created_at' => '2019-06-16 20:31:30','updated_at' => '2019-06-16 20:31:30'),
        array('id' => '40','name' => 'view orders','guard_name' => 'admin','created_at' => '2019-06-16 20:31:33','updated_at' => '2019-06-16 20:31:33'),
        array('id' => '37','name' => 'create sub_sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:31:24','updated_at' => '2019-06-16 20:31:24'),
        array('id' => '38','name' => 'update sub_sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:31:26','updated_at' => '2019-06-16 20:31:26'),
        array('id' => '39','name' => 'delete sub_sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:31:30','updated_at' => '2019-06-16 20:31:30'),
        array('id' => '40','name' => 'view sub_sub_categories','guard_name' => 'admin','created_at' => '2019-06-16 20:31:33','updated_at' => '2019-06-16 20:31:33'),
        array('id' => '40','name' => 'general settings','guard_name' => 'admin','created_at' => '2019-06-16 20:31:33','updated_at' => '2019-06-16 20:31:33'),
    );

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        error_log('Admins start ...');
        $admin = new Admin;
        $admin->first_name = "Hady";
        $admin->last_name = "Maher";
        $admin->email = "hadymaher311@gmail.com";
        $admin->password = Hash::make('123456789');
        $admin->save();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        foreach ($this->permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'guard_name' => $permission['guard_name'],
            ]);
        }

        $role = Role::create(['name' => 'super', 'guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());
        $admin->syncRoles($role);
        $role = Role::create(['name' => 'delivery', 'guard_name' => 'admin']);
        factory(Admin::class, 10)->create();
        $admins = Admin::all();
        foreach ($admins as $admin) {
            if ($admin->email != "hadymaher311@gmail.com") {
                $admin->syncRoles($role);
            }
        }
        error_log('Admins done ...');

        error_log('Features start ...');
        factory(Feature::class, 20)->create();
        error_log('Features done ...');

        error_log('Brands start ...');
        factory(Brand::class, 30)->create();
        error_log('Brands done ...');

        error_log('Categories start ...');
        factory(Category::class, 10)->create();
        error_log('Categories done ...');
        
        error_log('Sub Categories start ...');
        factory(SubCategory::class, 15)->create();
        error_log('Sub Categories done ...');
        
        error_log('Sub sub categories start ...');
        factory(SubSubCategory::class, 50)->create();
        error_log('Sub sub categories done ...');
        
        error_log('Products start ...');
        factory(Product::class, 100)->create();
        error_log('Products done ...');
        
        error_log('Tags start ...');
        factory(Tag::class, 1000)->create();
        error_log('Tags done ...');
        
        error_log('Discounts start ...');
        factory(Discount::class, 50)->create();
        error_log('Discounts done ...');
        
        error_log('Warehouses start ...');
        factory(warehouse::class, 30)->create();
        error_log('Warehouses done ...');
        
        error_log('Users start ...');
        factory(User::class, 20)->create();
        error_log('Users done ...');
        
        error_log('Users addresses start ...');
        factory(UserAddress::class, 50)->create();
        error_log('Users addresses done ...');
        
        error_log('Reviews start ...');
        factory(Review::class, 300)->create();
        error_log('Reviews done ...');
        
        error_log('Some relations start ...');
        $products = Product::all();
        foreach ($products as $product) {
            $product->total_quantity = ($product->quantities->count()) ? $product->quantities->sum(function($quantity) {
                return $quantity->reduced_quantity;
            }) : 0;
            $product->save();
        }
        
        $users = User::all();
        foreach ($users as $user) {
            $user->main_location = ($user->addresses->count()) ? $user->addresses->first()->id : null;
            $user->save();
        }

        GeneralSetting::createMany([
            [
                'name' => 'price_tax',
                'value' => '14'
            ],
            [
                'name' => 'points_value',
                'value' => '10'
            ],
        ]);

        error_log('Orders start ...');
        factory(Order::class, 50)->create();
        error_log('Orders done ...');

        error_log('All done ...');
    }
}
