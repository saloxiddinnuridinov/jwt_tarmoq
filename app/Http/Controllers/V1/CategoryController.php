<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\index\CategoryIndexResource;
use App\Http\Resources\show\CategoryResource;
use App\Http\ValidatorResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
 /**
 * @OA\Get(
 * path="/api/category",
 * security={{"api":{}}},
 * summary="all categorys",
 * description="Categorys",
 * operationId="category_index",
 * tags={"Category"},
 * @OA\Response(response=200, description="Success",
 *    @OA\JsonContent(ref="#/components/schemas/Category"),
 * ),
 * @OA\Response(response=404,description="Not found",
 *    @OA\JsonContent(ref="#/components/schemas/Error"),
 * ),
 * )
 */
    public function index()
    {
        return CategoryIndexResource::collection(Category::all());
    }

/**
 * @OA\Post(
 *  path="/api/category",
 *  security={{"api":{}}},
 *  summary="add categorys",
 *  description="Category add",
 *  operationId="category_store",
 *  tags={"Category"},
 *  @OA\RequestBody(required=true, description="Category Qo'shish",
 *          @OA\MediaType(mediaType="multipart/form-data",
 *          @OA\Schema(type="object", required={"name_uz","name_ru","name_en","image","parent_id"},
 *          @OA\Property(property="name_uz",type="string",@OA\Schema(example="Tana")),
 *          @OA\Property(property="name_ru",type="string",@OA\Schema(example="body")),
 *          @OA\Property(property="name_en",type="string",@OA\Schema(example="body")),
 *          @OA\Property(property="parent_id",type="integer",@OA\Schema(example="1")),
 *          @OA\Property(property="image", type="string", format="binary")))
 *   ),
 *  @OA\Response(response=200, description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Category"),
 *  ),
 *  @OA\Response(response=404,description="Not found",
 *    @OA\JsonContent(ref="#/components/schemas/Error"),
 *  ),
 * )
 */
    public function store(Request $request)
    {
        $rules = [
            'name_uz'    =>  'required|string|max:255',
            'name_ru'    =>  'required|string|max:255',
            'name_en'    =>  'required|string|max:255',
            'parent_id'  =>  'required|numeric',
            'image'      =>  'required|mimes:jpeg,png,jpg,gif',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }

        $image  =  $request->file('image');
        $date   =  date("d.m.Y");
        $name   =  time() . "_" . str_replace([" ", '"', "'"], ["", '', ''], $image->getClientOriginalName());

        $image->move(public_path("uploads/images/$date/"), $name);

        $category             = new Category();
        $category->name_uz    =  $request->name_uz;
        $category->name_ru    =  $request->name_ru;
        $category->name_en    =  $request->name_en;
        $category->image      =  asset("uploads/images/$date/$name");
        $category->parent_id  =  $request->parent_id;
        $category->save();
        return response()->json(['message' => 'Success'], 200);
    }

/**
 * @OA\Get(
 * path="/api/category/{id}",
 * summary="Show categorys",
 * description="Bitta idga tegishli categoriyalar ko'rinadi",
 * operationId="category_show",
 * tags={"Category"},
 * security={{"api":{}}},
 * @OA\Parameter(name="id", description="Categoryni ko'rish id orqali", required=true, in="path",
 *      @OA\Schema(type="integer")
 * ),
 * @OA\Response(response=200, description="success",
 *    @OA\JsonContent(ref="#/components/schemas/Category"),
 *  ),
 * @OA\Response(response=404,description="Not found",
 *    @OA\JsonContent(ref="#/components/schemas/Error"),
 *  ),
 * )
 */

    public function show($id)
    {
        $model  =  Category::find($id);
        if($model){
            return new CategoryResource($model);
        }
        return response()->json(['errors' => ['Not found']], 404);
    }

/**
 *  @OA\Put (
 *      path="/api/category/{id}",
 *      security={{"api":{}}},
 *      tags={"Category"},
 *      operationId="category_update",
 *      summary="Update branch",
 *
 *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
 *          @OA\Schema(type="integer")
 *      ),
 *
 *      @OA\RequestBody(required=true,
 *        @OA\JsonContent(required={"title", "content", "status"},
 *           @OA\Property(property="name_uz", type="string", example="Tana"),
 *           @OA\Property(property="name_ru", type="string", example="body"),
 *           @OA\Property(property="name_en", type="string", example="body"),
 *           @OA\Property(property="parent_id",type="integer", example="1"),
 *           @OA\Property(property="image", type="string", format="binary")
 *        ),
 *     ),
 *
 *      @OA\Response(response=200, description="success",
 *          @OA\JsonContent(ref="#/components/schemas/Category"),
 *      ),
 *      @OA\Response(response=404,description="Not found",
 *          @OA\JsonContent(ref="#/components/schemas/Error"),
 *      ),
 * )
 */

    public function update(Request $request, $id)
    {
        $rules = [
            'name_uz'    =>  'required|string|max:255',
            'name_ru'    =>  'required|string|max:255',
            'name_en'    =>  'required|string|max:255',
            'parent_id'  =>  'required|numeric',
           // 'image'      =>  'required|mimes:jpeg,png,jpg,gif',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model = Category::find($id);
        if ($model) {
            $model->name_uz   =  $request->name_uz;
            $model->name_ru   =  $request->name_ru;
            $model->name_en   =  $request->name_en;
            $model->parent_id =  $request->parent_id;
            $image            =  $request->file('image');
            if ($image){
                $date = date("d.m.Y");
                $name = time() . "_" . str_replace([" ", '"', "'"], ["", '', ''], $image->getClientOriginalName());
                $image->move(public_path("uploads/images/$date/"), $name);
                $model->image = asset("uploads/images/$date/$name");
            }
            $model->update();
            return response()->json(['message'  =>  ['Success']], 200);
        }else{
            return response()->json(['errors'   =>  ['Not found']], 404);
        }
    }
    /**
     * @OA\Delete(
     *      path="/api/category/{id}",
     *      operationId="deleteProject",
     *      security={{"api":{}}},
     *      tags={"Category"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Category"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      )
     * )
     */
    public function destroy($id)
    {
        $model = Category::find($id);
        if($model){
            try {
                $model->delete();
                return response()->json(['message' =>  "O`chirildi"],200);
            }catch (\Exception $e) {
                return response()->json(["errors"  =>  [$e->getMessage()]], 403);
            }
        }
        return response()->json(['errors'  =>  ['Not found']], 404);
    }
}
