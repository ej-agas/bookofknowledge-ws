<?php

namespace Tests\Unit\Admin;

use Tests\TestCase;
use BOK\Admin\Admin;
use Illuminate\Support\Facades\Hash;
use Tests\DataProviders\UserDataProvider;
use BOK\Admin\Repositories\AdminRepository;
use BOK\Admin\Exceptions\CreateAdminErrorException;
use BOK\Admin\Exceptions\UpdateAdminErrorException;
use BOK\Admin\Exceptions\AdminNotFoundErrorException;

class AdminUnitTest extends TestCase
{
    use UserDataProvider;

    /**
     * @test
     */
    public function it_can_show_admin_email(): void
    {
        $admin = factory(Admin::class)->create();
        $this->assertEquals($admin->email, $admin->getEmail());
    }
    /**
     * @test
     */
    public function it_can_show_admin_id()
    {
        $admin = factory(Admin::class)->create();
        $this->assertEquals($admin->id, $admin->getUserId());
    }
    /**
     * @test
     * @param $data
     * @dataProvider userProvider
     */
    public function it_can_show_class_instance($data): void
    {
        $admin = new Admin($data);
        $admin = $admin->getClassInstance();

        $this->assertInstanceOf(Admin::class, $admin);
    }
    /**
     * @test
     * @throws UpdateAdminErrorException
     */
    public function it_can_throw_exception_when_updating_admin(): void
    {
        $this->expectException(UpdateAdminErrorException::class);

        $admin = factory(Admin::class)->create();

        $payload = [
            'first_name' => null
        ];

        $adminRepo = new AdminRepository($admin);
        $adminRepo->updateAdmin($payload);
    }
    /**
     * @test
     * @throws CreateAdminErrorException
     */
    public function it_can_throw_exception_when_creating_admin(): void
    {
        $this->expectException(CreateAdminErrorException::class);

        $payload = [
            'first_name' => null,
        ];

        $adminRepo = new AdminRepository(new Admin);
        $adminRepo->createAdmin($payload);
    }
    /**
     * @test
     * @throws AdminNotFoundErrorException
     */
    public function it_can_throw_exception_when_finding_non_existing_email(): void
    {
        $this->expectException(AdminNotFoundErrorException::class);

        $admin = factory(Admin::class)->create();

        $adminRepo = new AdminRepository(new $admin);
        $adminRepo->findAdminByEmail('example@email.com');
    }

    /**
     * @test
     * @dataProvider userProvider
     * @param $data
     * @throws AdminNotFoundErrorException
     * @throws UpdateAdminErrorException
     */
    public function it_can_update_the_admin($data): void
    {
        $factory = factory(Admin::class)->create();
        $adminRepo = new AdminRepository($factory);
        $update = $adminRepo->updateAdmin($data);

        $this->assertTrue($update);

        $admin = $adminRepo->findAdminById($factory->id);

        $this->assertEquals($data['first_name'], $admin->first_name);
        $this->assertEquals($data['middle_name'], $admin->middle_name);
        $this->assertEquals($data['last_name'], $admin->last_name);
        $this->assertEquals($data['email'], $admin->email);
    }
    /**
     * @dataProvider userProvider
     * @test
     * @param $data
     * @throws AdminNotFoundErrorException
     */
    public function it_can_show_the_admin($data): void
    {
        $factory = factory(Admin::class)->create($data);

        $adminRepo = new AdminRepository(new Admin);
        $admin = $adminRepo->findAdminById($factory->id);

        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertEquals($data['first_name'], $admin->first_name);
        $this->assertEquals($data['middle_name'], $admin->middle_name);
        $this->assertEquals($data['last_name'], $admin->last_name);
        $this->assertEquals($data['email'], $admin->email);
        $this->assertTrue(Hash::check('secret', $admin->password));
    }
    /**
     * @dataProvider userProvider
     * @test
     * @param $data
     * @throws CreateAdminErrorException
     */
    public function it_can_create_the_admin($data): void
    {
        $adminRepo =  new AdminRepository(new Admin);
        $admin = $adminRepo->createAdmin($data);

        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertEquals($data['first_name'], $admin->first_name);
        $this->assertEquals($data['middle_name'], $admin->middle_name);
        $this->assertEquals($data['last_name'], $admin->last_name);
        $this->assertEquals($data['email'], $admin->email);
        $this->assertTrue(Hash::check('secret', $admin->password));
    }
}
