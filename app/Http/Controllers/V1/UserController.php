<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\show\UserResource;
use App\Http\ValidatorResponse;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
     /**
     * @OA\Get(
     *      path="/api/user",
     *      security={{"api":{}}},
     *      operationId="user_index",
     *      tags={"User"},
     *      summary="All User",
     *      description="Hamma Userlarni korish",
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }


    /**
     * @OA\Post(
     *      path="/api/user",
     *      security={{"api":{}}},
     *      operationId="user_store",
     *      tags={"User"},
     *      summary="new User add",
     *      description="Yangi student qoshish",
     *      @OA\RequestBody(required=true, description="user save",
     *              @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"name", "surname", "email", "password", "phone", "status", "is_bloced"},
     *              @OA\Property(property="name", type="string", format="text", example="salohiddin"),
     *              @OA\Property(property="surname", type="string", format="text", example="Nuriddinov"),
     *              @OA\Property(property="email", type="string", format="text", example="lorenzo.emmerich@example.com"),
     *              @OA\Property(property="password", type="string", format="text", example="user"),
     *              @OA\Property(property="phone", type="string", format="text", example="+998911234567"),
     *              @OA\Property(property="status", type="string", format="text", example="active"),
     *              @OA\Property(property="is_bloced", type="number", format="number", example="1")))
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
            'email' => 'required|email',
            'password' =>'required',
            'phone' =>'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->email_verified_at = $request->email_verified_at;
        $user->password = $request->password;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->is_bloced = $request->is_bloced;
        $user->save();
        return response()->json(['message' => 'Saqlandi'],200);
    }
/**
 * @OA\Get(
 * path="/api/user/{id}",
 * security={{"api":{}}},
 * summary="Show user",
 * description="bitta studentni hamma malumotlarini ko'rsatadi",
 * operationId="user_show",
 * tags={"User"},
 * @OA\Parameter(name="id", description="Project id", required=true, in="path",
 *    @OA\Schema(type="integer")
 * ),
 * @OA\Response(response=200, description="success",
 *    @OA\JsonContent(ref="#/components/schemas/User"),
 * ),
 * @OA\Response(response=404,description="Not found",
 *    @OA\JsonContent(ref="#/components/schemas/Error"),
 * ),
 * )
 */
    public function show($id)
    {
        $model = User::find($id);
        if($model){
            return new UserResource($model);
        }
        return response()->json(['errors' => ['Not found']], 404);
    }

    /**
     * @OA\Put(
     *      path="/api/user/{id}",
     *      security={{"api":{}}},
     *      operationId="user_update",
     *      tags={"User"},
     *      summary="Update existing project",
     *      description="Returns updated project data",
     *      @OA\Parameter(name="id", description="Project id", required=true,in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(required=true, description="user save",
     *              @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"name", "email", "password", "phone"},
     *              @OA\Property(property="name", type="string", format="text", example="salohiddin"),
     *              @OA\Property(property="surname", type="string", format="text", example="Nuriddinov"),
     *              @OA\Property(property="email", type="string", format="text", example="lorenzo.emmerich@example.com"),
     *              @OA\Property(property="password", type="string", format="text", example="user"),
     *              @OA\Property(property="phone", type="string", format="text", example="+998911234567")))
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
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
            'email' => 'required',
            'password' =>'required',
            'phone' =>'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model = User::find($id);
        if ($model) {
            $model->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
            ]);
            return response()->json(['message'=>['Yangilandi']], 200);
        }else{
            return response()->json(['errors' => ['Not found']], 404);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/user/{id}",
     *      security={{"api":{}}},
     *      operationId="user_delete",
     *      tags={"User"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(name="id",description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function destroy($id)
    {
        $model = User::find($id);
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
