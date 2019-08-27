<?php


namespace BOK\Teacher\Repositories;


use BOK\Teacher\Teacher;
use Jsdecena\Baserepo\BaseRepository;
use Illuminate\Database\QueryException;
use BOK\Teacher\Exceptions\CreateTeacherErrorException;
use BOK\Teacher\Exceptions\UpdateTeacherErrorException;
use BOK\Teacher\Exceptions\DeleteTeacherErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BOK\Teacher\Exceptions\TeacherNotFoundErrorException;

class TeacherRepository extends BaseRepository
{
    /**
     * TeacherRepository constructor.
     * @param  Teacher  $teacher
     */
    public function __construct(Teacher $teacher)
    {
        parent::__construct($teacher);
        $this->model = $teacher;
    }

    public function findTeacherByEmail(string $email): Teacher
    {
        try {
            return $this->model->where(compact('email'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new TeacherNotFoundErrorException($e);
        }
    }

    /**
     * @param $id
     * @return Teacher
     * @throws TeacherNotFoundErrorException
     */
    public function findTeacherById($id): Teacher
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new TeacherNotFoundErrorException ($e);
        }
    }

    /**
     * @return bool
     * @throws DeleteTeacherErrorException
     */
    public function deleteTeacher(): bool
    {
        try {
            return $this->model->delete();
            } catch (\Exception $e) {
            throw new DeleteTeacherErrorException ($e);
        }
    }

    /**
     * @param  array  $data
     * @return bool
     * @throws UpdateTeacherErrorException
     */
    public function updateTeacher(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateTeacherErrorException ($e);
        }
    }

    /**
     * @param  array  $data
     * @return Teacher
     * @throws CreateTeacherErrorException
     */
    public function createTeacher(array $data): Teacher
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateTeacherErrorException ($e);
        }
    }
}
