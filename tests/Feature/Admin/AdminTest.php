<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use BOK\Admin\Admin;
use Tests\DataProviders\UserDataProvider;


class AdminTest extends TestCase
{
    use UserDataProvider;

    /**
     * @test
     * @param $data
     * @dataProvider userProvider
     */
    public function it_should_update_the_admin($data): void
    {
        $admin = factory(Admin::class)->create();

        $this->put(route('admins.update', $admin->id), $data)
            ->assertStatus(200)
            ->assertJsonFragment(collect($data)->except('password', 'created_at', 'updated_at')->all());
    }
    /**
     * @test
     */
    public function it_should_show_the_admin(): void
    {
        $admin = factory(Admin::class)->create();

        $this->get(route('admins.show', $admin->id))
            ->assertStatus(200)
            ->assertJsonFragment(collect($admin)->except('password', 'created_at', 'updated_at')->all());
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     */
    public function it_should_create_the_admin($data): void
    {
        $this->post(route('admins.store'), $data)
             ->assertStatus(201)
             ->assertJsonFragment(collect($data)->except('password')->all());
    }
}
