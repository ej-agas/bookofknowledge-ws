<?php


namespace BOK\Http\Controllers\Teacher;


use BOK\Teacher\Teacher;
use Illuminate\Http\JsonResponse;
use BOK\Http\Controllers\Controller;
use BOK\Teacher\Requests\CreateTeacherRequest;
use BOK\Teacher\Requests\UpdateTeacherRequest;
use BOK\Teacher\Repositories\TeacherRepository;
use BOK\Teacher\Transformers\TeacherTransformer;
use BOK\Teacher\Exceptions\CreateTeacherErrorException;
use BOK\Teacher\Exceptions\UpdateTeacherErrorException;
use BOK\Teacher\Exceptions\DeleteTeacherErrorException;
use BOK\Teacher\Exceptions\TeacherNotFoundErrorException;

class TeacherApiController extends Controller
{
    /**
     * @var TeacherRepository
     */
    private $teacherRepo;

    /**
     * TeacherApiController constructor.
     * @param  TeacherRepository  $teacherRepo
     */
    public function __construct(TeacherRepository $teacherRepo)
    {
        $this->teacherRepo = $teacherRepo;
    }

    public function destroy($teacherId)
    {
        try {
            $teacher = $this->teacherRepo->findTeacherById($teacherId);
            $teacherRepository = new TeacherRepository($teacher);
            $teacherRepository->deleteTeacher();

            return response()->json(__('success.delete'), 202);
        } catch (TeacherNotFoundErrorException $e) {
            return response()->json(__('errors.show'),404);
        } catch (DeleteTeacherErrorException $e) {
            return response()->json(__('errors.delete'),400);
        }
    }
    /**
     * @param $teacherId
     * @param  UpdateTeacherRequest  $request
     * @return JsonResponse
     */
    public function update($teacherId, UpdateTeacherRequest $request): JsonResponse
    {
        try {
            $teacher = $this->teacherRepo->findTeacherById($teacherId);
            $teacherRepository = new TeacherRepository($teacher);

            $teacherData = $request->only(Teacher::FILLABLES);
            $teacherRepository->updateTeacher($teacherData);

            $data = $teacherRepository->processItemTransformer(
                $teacher,
                new TeacherTransformer,
                Teacher::RESOURCE_KEY,
                Teacher::INCLUDES
            );

            return response()->json($data->toArray(), 200);
        } catch (TeacherNotFoundErrorException $e) {
            return response()->json(__('errors.show'), 404);
        } catch (UpdateTeacherErrorException $e) {
            return response()->json(__('errors.update'), 400);
        }
    }
    /**
     * @param $teacherId
     * @return JsonResponse
     */
    public function show($teacherId): JsonResponse
    {
        try {
            $teacher = $this->teacherRepo->findTeacherById($teacherId);

            $data = $this->teacherRepo->processItemTransformer(
                $teacher,
                new TeacherTransformer,
                Teacher::RESOURCE_KEY,
                Teacher::INCLUDES
            );

            return response()->json($data->toArray(), 200);
        } catch (TeacherNotFoundErrorException $e) {
            return response()->json(__('errors.show'), 404);
        }
    }
    /**
     * @param  CreateTeacherRequest  $request
     * @return JsonResponse
     */
    public function store(CreateTeacherRequest $request): JsonResponse
    {
        try {
            $teacher = $this->teacherRepo->createTeacher($request->only(Teacher::FILLABLES));

            $data = $this->teacherRepo->processItemTransformer(
                $teacher,
                new TeacherTransformer,
                Teacher::RESOURCE_KEY,
                Teacher::INCLUDES
            );

            return response()->json($data->toArray(), 201);
        } catch (CreateTeacherErrorException $e) {
            return response()->json(__('errors.create'));
        }
    }
}
