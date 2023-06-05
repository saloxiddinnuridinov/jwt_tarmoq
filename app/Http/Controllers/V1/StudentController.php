<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\index\StudentIndexResource;
use App\Http\Resources\show\StudentResource;
use App\Http\ValidatorResponse;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     *      path="/api/student",
     *      security={{"api":{}}},
     *      operationId="student_index",
     *      tags={"Student"},
     *      summary="All Students",
     *      description="Hamma studentlarni korish",
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Student"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function index()
    {
        return StudentIndexResource::collection(Student::all());
    }

    /**
     * @OA\Post(
     *      path="/api/student",
     *      security={{"api":{}}},
     *      operationId="student_store",
     *      tags={"Student"},
     *      summary="new Student add",
     *      description="Yangi student qoshish",
     *      @OA\RequestBody(required=true, description="Student Save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object",required={"name","surname", "email", "password", "balance", "birthday"},
     *              @OA\Property(property="name", type="string", format="text", example="Harley"),
     *              @OA\Property(property="surname", type="string", format="text", example="Augustus"),
     *              @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="password", format="text", example="admin123"),
     *              @OA\Property(property="balance", type="integer", format="number", example="6275"),
     *              @OA\Property(property="birthday", type="date", format="number", example="1987-08-29")))
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Student"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'balance' => 'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
            $model = new Student();
            $model->name = $request->name;
            $model->surname = $request->surname;
            $model->email = $request->email;
            $model->email_verified_at = $request->email_verified_at;
            $model->block_reason = $request->block_reason;
            $model->password = $request->password;
            $model->balance = $request->balance;
            $model->birthday = $request->birthday;
            $model->save();
            return response()->json(['message' => ['Saqlandi']],200);
    }

/**
 * @OA\Get(
 * path="/api/student/{id}",
 * security={{"api":{}}},
 * summary="Show Student",
 * description="bitta studentni hamma malumotlarini ko'rsatadi",
 * operationId="student_show",
 * tags={"Student"},
 * @OA\Parameter(name="id", description="Student id", required=true, in="path",
 *    @OA\Schema(type="integer")
 * ),
 * @OA\Response(response=200, description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Student"),
 * ),
 * @OA\Response(response=404,description="Not found",
 *    @OA\JsonContent(ref="#/components/schemas/Error"),
 * ),
 * )
 */

    public function show($id)
    {
        $model = Student::find($id);
        if($model){
            return new StudentResource($model);
        }
        return response()->json(['errors' => ['Not found']], 404);
    }

    /**
     * @OA\Put(
     *      path="/api/student/{id}",
     *      security={{"api":{}}},
     *      operationId="student_update",
     *      tags={"Student"},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\Parameter(name="id", description="student id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(required=true, description="Student Save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object",required={"name","surname", "email", "password", "status", "balance", "birthday"},
     *              @OA\Property(property="name", type="string", format="text", example="Harley"),
     *              @OA\Property(property="surname", type="string", format="text", example="Augustus"),
     *              @OA\Property(property="email", type="string", format="text", example="admin@gmail.com"),
     *              @OA\Property(property="password", type="password", format="text", example="admin123"),
     *              @OA\Property(property="status", type="enum", format="text", example="active"),
     *              @OA\Property(property="balance", type="integer", format="number", example="6275"),
     *              @OA\Property(property="birthday", type="date", format="number", example="1987-08-29")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Student"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'balance' => 'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model                  = Student::find($id);
        $model->name            = $request->name;
        $model->surname         = $request->surname;
        $model->email           = $request->email;
        $model->block_reason    = $request->is_bloked;
        $model->password        = $request->password;
        $model->balance         = $request->balance;
        $model->birthday        = $request->birthday;
        $model->update();
        return response()->json(['message' => ['Yangilandi']], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/student/{id}",
     *      security={{"api":{}}},
     *      operationId="student_delete",
     *      tags={"Student"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(name="id",description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Student"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function destroy($id)
    {
        $model = Student::find($id);
        if($model){
            try {
                $model->delete();
                return response()->json([
                    'message' => ["O`chirildi"],
                    ],200);
                }catch (\Throwable $th) {
                    return response()->json([
                        "errors" =>["$th"],
                    ], 403);
                }
            }
            return response()->json(['errors' => ['Not found']], 404);
    }


}
