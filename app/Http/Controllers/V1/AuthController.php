<?php

namespace App\Http\Controllers\V1;

use App\Http\ValidatorResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['register', 'login']]);
//    }


    /**
     * @OA\Post(
     *      path="/api/login",
     *      security={{"bearerAuth":{}}},
     *      operationId="auth_login",
     *      tags={"Auth"},
     *      summary="Login",
     *      description="Login Parol yordamida kirish",
     *       @OA\RequestBody(required=true, description="lesson save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"email", "password"},
     *                 @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="admin123"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function login(Request $request)
    {
        $rules  = [
            'email' => 'required|string|email',
            'password' => 'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model = User::where('email', $request->email)->first();
        if ($model) {
            if (Hash::check($request->password, $model->password)) {
                $credentials = $request->only('email', 'password');
                $token = auth('api')->attempt($credentials);
                $user = auth('api')->user();
                return response()->json(['user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ], 200);
            }else {
                return response()->json(['errors' => ['Password incorrect']],400);

            }
        }else{
            return response()->json(['errors' => ['User not found']],400);
        }

    }
    /**
     * @OA\Post(
     *      path="/api/register",
     *      security={{"bearerAuth":{}}},
     *      operationId="auth_store",
     *      tags={"Auth"},
     *      summary="Auth",
     *      description="Registratsiya qoshish",
     *       @OA\RequestBody(required=true, description="lesson save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"name", "surname", "email", "password", "phone", "status"},
     *                 @OA\Property(property="name", type="string", format="text", example="Salohiddin"),
     *                 @OA\Property(property="surname", type="string", format="text", example="Nuridinov"),
     *                 @OA\Property(property="email", type="string", format="email", example="admin@gmail.com"),
     *                 @OA\Property(property="password", type="string", format="password", example="admin123"),
     *                 @OA\Property(property="phone", type="string", format="text", example="998941234567"),
     *                 @OA\Property(property="status", type="string", format="text", example="active"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/User"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function register(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required'],
            'status' => ['required'],
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => $request->status,
        ]);
        $token = auth()->login($user);
        $user = auth('api')->user();
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/logout",
     * summary="Logout ",
     *  security={{ "api": {} }},
     * description="logout user !",
     * tags={"Auth"},
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     )
     * )
     */

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'success' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'success' => 'success',
            'data' => auth('api')->user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
