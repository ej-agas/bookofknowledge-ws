<?php


namespace Tests\Feature\Admin;


use Tests\TestCase;
use BOK\Admin\Admin;
use Tests\DataProviders\UserDataProvider;

class AdminAuthenticationTest extends TestCase
{
    use UserDataProvider;

    public function it_should_throw_an_error_with_the_wrong_login_credentials(): void
    {
        $admin = factory(Admin::class)->create();

        $payload = [
            'email' => $admin->email,
            'password' => $this->faker->word,
            'subject' => Admin::RESOURCE_KEY
        ];

        $this->post(route('auth.store'), $payload)
            ->assertStatus(401)
            ->assertJson(trans('errors.login'));
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     */
    public function it_should_return_the_admin_details_and_token($data): void
    {
        $admin = factory(Admin::class)->create($data);

        $payload = [
            'email' => $admin->email,
            'password' => 'secret',
            'subject' => Admin::RESOURCE_KEY
        ];

        $this->post(route('auth.store'), $payload)
            ->assertStatus(200)
            ->assertJsonFragment(collect($data)->except('password')->all());
    }
}
