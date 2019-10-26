<?php


namespace Tests\Feature\Teacher;


use Tests\TestCase;
use BOK\Teacher\Teacher;
use Tests\DataProviders\UserDataProvider;

class TeacherTest extends TestCase
{
    use UserDataProvider;

    /**
     * @test
     * @dataProvider userProvider
     */
    public function it_should_error_when_updating_non_existent_teacher($data)
    {
        $this->put(route('teachers.update', 100), $data)
            ->assertStatus(404)
            ->assertJson(__('errors.show'));
    }
    /**
     * @test
     */
    public function it_should_error_when_showing_non_existent_teacher()
    {
        factory(Teacher::class)->create();
        $this->get(route('teachers.show', 100))
            ->assertStatus(404)
            ->assertJson(__('errors.show'));
    }
    /**
     * @test
     */
    public function it_should_soft_delete_the_teacher(): void
    {
        $teacher = factory(Teacher::class)->create();
        $this->delete(route('teachers.destroy', $teacher->id))
            ->assertStatus(202)
            ->assertJsonFragment(__('success.delete'));
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     */
    public function it_should_update_the_teacher($data): void
    {
        $data['subject'] = $this->faker->randomElement(Teacher::SUBJECTS);
        $teacher = factory(Teacher::class)->create();

        $this->put(route('teachers.update', $teacher->id), $data)
            ->assertStatus(200)
            ->assertJsonFragment(collect($data)->except('password')->all());
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     */
    public function it_should_show_the_teacher($data): void
    {
        $data['subject'] = $this->faker->randomElement(Teacher::SUBJECTS);
        $teacher = factory(Teacher::class)->create($data);

        $this->get(route('teachers.show', $teacher->id))
            ->assertStatus(200)
            ->assertJsonFragment(collect($data)->except('password')->all());

    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     */
    public function it_should_create_teacher($data): void
    {
        $data['subject'] = $this->faker->randomElement(Teacher::SUBJECTS);
        $this->post(route('teachers.store'), $data)
            ->assertStatus(201)
            ->assertJsonFragment(collect($data)->except('password')->all());
    }
}
