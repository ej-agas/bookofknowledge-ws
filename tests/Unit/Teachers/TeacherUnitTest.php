<?php


namespace Tests\Unit\Teachers;


use Tests\TestCase;
use BOK\Teacher\Teacher;
use Tests\DataProviders\UserDataProvider;
use BOK\Teacher\Repositories\TeacherRepository;
use BOK\Teacher\Exceptions\CreateTeacherErrorException;
use BOK\Teacher\Exceptions\UpdateTeacherErrorException;
use BOK\Teacher\Exceptions\DeleteTeacherErrorException;
use BOK\Teacher\Exceptions\TeacherNotFoundErrorException;

class TeacherUnitTest extends TestCase
{
    use UserDataProvider;

    /**
     * @test
     * @throws DeleteTeacherErrorException
     */
    public function it_can_soft_delete_teacher()
    {
        $factory = factory(Teacher::class)->create();
        $teacherRepo = new TeacherRepository($factory);
        $delete = $teacherRepo->deleteTeacher();

        $this->assertTrue($delete);
        $this->assertDatabaseHas('teachers', ['id' => $factory->id]);
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     * @throws UpdateTeacherErrorException
     * @throws TeacherNotFoundErrorException
     */
    public function it_can_update_teacher($data): void
    {
        $factory = factory(Teacher::class)->create();
        $teacherRepo = new TeacherRepository($factory);
        $update = $teacherRepo->updateTeacher($data);

        $this->assertTrue($update);
        $teacher = $teacherRepo->findTeacherById($factory->id);
        $this->assertEquals($data['first_name'], $teacher->first_name);
        $this->assertEquals($data['middle_name'], $teacher->middle_name);
        $this->assertEquals($data['last_name'], $teacher->last_name);
        $this->assertEquals($data['email'], $teacher->email);
        $this->assertEquals($factory->subject, $teacher->subject);
    }
    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     * @throws CreateTeacherErrorException
     */
    public function it_can_create_teacher($data): void
    {
        $data['subject'] = $this->faker->randomElement(Teacher::SUBJECTS);
        $teacherRepo = new TeacherRepository(new Teacher);
        $teacher = $teacherRepo->createTeacher($data);

        $this->assertInstanceOf(Teacher::class, $teacher);
        $this->assertEquals($data['first_name'], $teacher->first_name);
        $this->assertEquals($data['middle_name'], $teacher->middle_name);
        $this->assertEquals($data['last_name'], $teacher->last_name);
        $this->assertEquals($data['email'], $teacher->email);
        $this->assertEquals($data['subject'], $teacher->subject);
    }
}
