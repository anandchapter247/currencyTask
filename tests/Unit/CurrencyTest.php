<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class CurrencyTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * check user without eamil and password.
     *
     * @return void
     */
    public function testloginWithParameter()
    {
        $response = $this->call('POST', '/api/login', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /**
     * check user exist or not.
     *
     * @return void
     */
    public function testlogin()
    {
        $faker = \Faker\Factory::create();
        $data = [
            'name' => $faker->name,
            'email' =>  $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
        $user = User::create($data);

        $response = $this->call('POST', '/api/login', [
            'email' =>    $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);
    }

}
