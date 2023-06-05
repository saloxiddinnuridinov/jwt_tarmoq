<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\index\LessonIndexResource;
use App\Http\Resources\show\LessonResource;
use App\Http\ValidatorResponse;
use App\Models\ImageFile;
use App\Models\Lesson;
use App\Models\LessonJoinImageFile;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * @OA\Get(
     * path="/api/lesson",
     * security={{"api":{}}},
     * operationId="lesson_index",
     * tags={"Lessons"},
     * summary="All Lessons",
     * description="Hamma Dars(Lesson)larrni ko'rish",
     * @OA\Response(response=200, description="Success",
     *    @OA\JsonContent(ref="#/components/schemas/Lesson"),
     * ),
     * @OA\Response(response=404,description="Not found",
     *    @OA\JsonContent(ref="#/components/schemas/Error"),
     * ),
     * )
     */
    public function index()
    {
        return LessonIndexResource::collection(Lesson::all());
    }

    /**
     * @OA\Post(
     *      path="/api/lesson",
     *      security={{"api":{}}},
     *      operationId="lesson_store",
     *      tags={"Lessons"},
     *      summary="new Lesson add",
     *      description="Yangi Lesson qoshish",
     *      @OA\RequestBody(required=true, description="Lesson Qo'shish",
     *          @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"title_uz", "title_ru", "title_en", "category_id", "images[]"},
     *              @OA\Property(property="title_uz", type="string", format="text", example="PHP"),
     *              @OA\Property(property="title_ru", type="string", format="text", example="ПХП"),
     *              @OA\Property(property="title_en", type="string", format="text", example="PHP"),
     *              @OA\Property(property="category_id", type="number", format="number", example="2"),
     *              @OA\Property(property="images[]", type="array",@OA\Items(type="integer",format="number"))
     *              )),
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Lesson"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */

    public function store(Request $request)
    {
        try {
        $rules = [
            'title_uz'     =>  'required|max:255',
            'title_ru'     =>  'required|max:255',
            'title_en'     =>  'required|max:255',
            'category_id'  =>  'required|exists:categories,id',
            'images'       =>  'required|array',
            'images.*'     =>  'required|numeric',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }

        $lesson               =  new Lesson();
        $lesson->title_ru     =  $request->title_ru;
        $lesson->title_uz     =  $request->title_uz;
        $lesson->title_en     =  $request->title_en;
        $lesson->category_id  =  $request->category_id;
        $lesson->save();

        for ($i = 0; $i < count($request->images); $i++) {

            $image  =  $request->images[$i];
//            $date   =  date("d.m.Y.");
//            $name   =  $date . time() . "_" . str_replace([" ", '"', "'"], ["", '', ''], $image->getClientOriginalName());
//            $image->move(public_path("uploads/image_file/"), $name);
//
//            $image_file             =  new ImageFile();
//            $image_file->name_ru    =  $request->name_ru;
//            $image_file->name_uz    =  $request->name_uz;
//            $image_file->name_en    =  $request->name_en;
//            $image_file->url        =  asset("uploads/image_file/$name");
//            $image_file->save();

            $lessonJoinImage                  =  new LessonJoinImageFile();
            $lessonJoinImage->lesson_id       =  $lesson->id;
            $lessonJoinImage->image_file_id   =  $image;
            $lessonJoinImage->save();
        }
        return response()->json(['message' => 'Success'],200);
        } catch (\Exception $e) {
            return response()->json(['errors' => [$e->getFile(). $e->getLine() . $e->getMessage()]],403);
        }
    }
    /**
     * @OA\Get(
     * path="/api/lesson/{id}",
     * security={{"api":{}}},
     * summary="Show Lesson",
     * description="bitta Lessonni hamma malumotlarini ko'rsatadi",
     * operationId="lesson_show",
     * tags={"Lessons"},
     * @OA\Parameter(name="id", description="Lesson id", required=true, in="path",
     *    @OA\Schema(type="integer")
     * ),
     * @OA\Response(response=200, description="success",
     *    @OA\JsonContent(ref="#/components/schemas/Lesson"),
     * ),
     * @OA\Response(response=404,description="Not found",
     *    @OA\JsonContent(ref="#/components/schemas/Error"),
     * ),
     * )
     */
    public function show($id)
    {
        $model = Lesson::find($id);
        if($model){
            return new LessonResource($model);
        }
        return response()->json(['errors' => ['Not found']], 404);
    }

    /**
     *  @OA\Put (
     *      path="/api/lesson/{id}",
     *      security={{"api":{}}},
     *      tags={"Lessons"},
     *      operationId="lesson_update",
     *      summary="Update branch",
     *
     *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\RequestBody(required=true,
     *        @OA\JsonContent(required={"title_uz", "title_ru", "title_en", "category_id"},
     *           @OA\Property(property="title_uz", type="string", example="title_uz"),
     *           @OA\Property(property="title_ru", type="string", example="title_ru"),
     *           @OA\Property(property="title_en", type="string", example="body"),
     *           @OA\Property(property="category_id",type="integer", example="1"),
     *        ),
     *      ),
     *
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Lesson"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title_uz'     =>  'required',
            'title_ru'     =>  'required',
            'title_en'     =>  'required',
            'category_id'  =>  'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model              =  Lesson::find($id);
        $model->title_ru    =  $request->title_ru;
        $model->title_uz    =  $request->title_uz;
        $model->title_en    =  $request->title_en;
        $model->category_id =  $request->category_id;
        $model->update();
        return response()->json(['message'  =>  'Yangilandi'], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/lesson/{id}",
     *      security={{"api":{}}},
     *      operationId="lesson_delete",
     *      tags={"Lessons"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
     *          @OA\Schema( type="integer")
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Lesson"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function destroy($id)
    {
        $model = Lesson::find($id);
        if($model){
            try {
                $model->delete();
                return response()->json(['message'  => "O`chirildi"],200);
            }catch (\Exception $e) {
                return response()->json(["errors"   => [$e]], 403);
            }
        }
        return response()->json(['errors' => ['Not found']], 404);
    }
}
