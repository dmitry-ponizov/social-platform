\    <?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Components\Admin\Models\User::class, function (Faker $faker) {
    static $password;
    return [
        'name' => $faker->firstName,
        'uuid' => Str::uuid(),
        'surname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'avatar' => '/uploads/avatars/no_avatar.jpeg',
        'types' => 'volunteer',
        'password' => $password ?: $password = Hash::make('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Components\Main\Models\Statement::class, function (Faker $faker) {
    $uuid1 = Uuid::uuid1();
    return [
        'user_id' => rand(1, 10),
        'uuid' => $uuid1 = $uuid1->toString(),
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'category_id' => rand(1, 7),
        'status' => 'sent',
        'published' => true,
        'organization_id' => 2,
        'parent_id' => 0,
        'repeat' => true,
//        'sum'=>rand(5000,30000)
    ];
});

$factory->define(App\Components\Admin\Models\Profile::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\Components\Admin\Models\User')->create()->id;
        },
        'rule_id' => 5,
        'data' => rand(1006511718, 9006511718),
        'changed_at' => Carbon::now()

    ];
});

$factory->define(App\Components\Admin\Models\SocialService::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'house' => $faker->buildingNumber,
        'office' => $faker->buildingNumber,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email

    ];
});
$factory->define(App\Components\Admin\Models\Organization::class, function (Faker $faker) {
    $name = $faker->company;
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'code' => $faker->bankAccountNumber,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'house' => $faker->buildingNumber,
        'office' => $faker->buildingNumber,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email

    ];
});