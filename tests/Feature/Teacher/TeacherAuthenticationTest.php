<?php


namespace Tests\Feature\Teacher;


use Tests\TestCase;
use BOK\Teacher\Teacher;
use Tests\DataProviders\UserDataProvider;

class TeacherAuthenticationTest extends TestCase
{
    use UserDataProvider;

    /**
     * @test
     */
    public function it_should_throw_an_error_with_wrong_login_credentials()
    {
        $teacher = factory(Teacher::class)->create();

        $payload = [
            'email' => $teacher->email,
            'password' => $this->faker->word,
            'type' => Teacher::RESOURCE_KEY
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
    public function it_should_return_the_teacher_details_and_token($data)
    {
        $teacher= factory(Teacher::class)->create($data);

        $payload = [
            'email' => $teacher->email,
            'password' => 'secret',
            'type' => Teacher::RESOURCE_KEY
        ];

        $this->post(route('auth.store'), $payload)

             ->assertStatus(200)
             ->assertJsonFragment(collect($data)->except('password')->all());
    }
}
