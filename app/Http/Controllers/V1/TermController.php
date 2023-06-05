<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\index\TermIndexResource;
use App\Http\Resources\show\TermResource;
use App\Http\ValidatorResponse;
use App\Models\Term;
use Illuminate\Http\Request;


class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    /**
     * @OA\Get(
     *      path="/api/term",
     *      security={{"api":{}}},
     *      operationId="term_index",
     *      tags={"Terms"},
     *      summary="All Terms",
     *      description="Hamma Terminlarlarni ko'rish",
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     *     )
     */
    public function index()
    {
        return TermIndexResource::collection(Term::all());
    }

    /**
     * @OA\Post(
     *      path="/api/term",
     *      security={{"api":{}}},
     *      operationId="term_store",
     *      tags={"Terms"},
     *      summary="new Trems add",
     *      description="Yangi Terms qoshish",
     *      @OA\RequestBody(required=true, description="lesson save",
     *           @OA\MediaType(mediaType="multipart/form-data",
     *              @OA\Schema(type="object", required={"keyword_latin", "keyword_ru", "keyword_uz", "keyword_en", "description_uz", "description_ru", "description_en"},
     *                 @OA\Property(property="keyword_latin", type="string", format="text", example="Harley"),
     *                 @OA\Property(property="keyword_ru", type="string", format="text", example="Augustus"),
     *                 @OA\Property(property="keyword_uz", type="string", format="text", example="Augustus"),
     *                 @OA\Property(property="keyword_en", type="string", format="text", example="Augustus"),
     *                 @OA\Property(property="description_uz", type="string", format="text", example="Description"),
     *                 @OA\Property(property="description_ru", type="string", format="text", example="Description"),
     *                 @OA\Property(property="description_en", type="string", format="text", example="Description"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function store(Request $request)
    {
        $rules = [
            'keyword_latin'  =>  'required|max:255',
            'keyword_ru'     =>  'required|max:255',
            'keyword_uz'     =>  'required|max:255',
            'keyword_en'     =>  'required|max:255',
            'description_uz' =>  'required',
            'description_ru' =>  'required',
            'description_en' =>  'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model                 = new Term();
        $model->keyword_latin  = $request->keyword_latin;
        $model->keyword_ru     = $request->keyword_ru;
        $model->keyword_uz     = $request->keyword_uz;
        $model->keyword_en     = $request->keyword_en;
        $model->description_uz = $request->description_uz;
        $model->description_ru = $request->description_ru;
        $model->description_en = $request->description_en;
        $model->save();
        return response()->json(['message' => 'Saqlandi'], 200);
    }
    /**
     * @OA\Get(
     * path="/api/term/{id}",
     * security={{"api":{}}},
     * summary="Show term",
     * description="bitta termda hamma malumotlarini ko'rsatadi",
     * operationId="term_show",
     * tags={"Terms"},
     * @OA\Parameter(name="id", description="Lesson id", required=true, in="path",
     *    @OA\Schema(type="integer")
     * ),
     * @OA\Response(response=200, description="success",
     *    @OA\JsonContent(ref="#/components/schemas/Term"),
     * ),
     * @OA\Response(response=404,description="Not found",
     *    @OA\JsonContent(ref="#/components/schemas/Error"),
     * ),
     * )
     */
    public function show($id)
    {
        $model = Term::find($id);
        if($model){
            return new TermResource($model);
        }
        return response()->json(['errors' => ['Not found']], 404);
    }

    /**
     *  @OA\Put (
     *      path="/api/term/{id}",
     *      security={{"api":{}}},
     *      tags={"Terms"},
     *      operationId="term_update",
     *      summary="Update branch",
     *
     *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *
     *      @OA\RequestBody(required=true,
     *        @OA\JsonContent(required={"keyword_latin", "keyword_uz", "keyword_ru", "keyword_en", "description_uz"},
     *           @OA\Property(property="keyword_latin", type="string", example="keyword_latin"),
     *           @OA\Property(property="keyword_ru", type="string", example="keyword_ru"),
     *           @OA\Property(property="keyword_uz", type="string", example="keyword_uz"),
     *           @OA\Property(property="keyword_en", type="string", example="keyword_en"),
     *           @OA\Property(property="description_uz", type="text", example="description"),
     *           @OA\Property(property="description_ru", type="text", example="description"),
     *           @OA\Property(property="description_en", type="text", example="description"),
     *        ),
     *      ),
     *
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'keyword_latin'  =>  'required|max:255',
            'keyword_ru'     =>  'required|max:255',
            'keyword_uz'     =>  'required|max:255',
            'keyword_en'     =>  'required|max:255',
            'description_uz' =>  'required',
            'description_ru' =>  'required',
            'description_en' =>  'required',
        ];
        $validator = new ValidatorResponse();
        $validator->check($request, $rules);
        if ($validator->fails) {
            return response()->json($validator->response, 400);
        }
        $model = Term::find($id);
        if ($model){
            $model->keyword_latin  = $request->keyword_latin;
            $model->keyword_ru     = $request->keyword_ru;
            $model->keyword_uz     = $request->keyword_uz;
            $model->keyword_en     = $request->keyword_en;
            $model->description_uz = $request->description_uz;
            $model->description_ru = $request->description_ru;
            $model->description_en = $request->description_en;
            $model->update();
            return response()->json(['message'  =>  'Yangilandi' ], 200);
        }else{
            return response()->json(['errors'   =>  ['Not found']], 404);
        }
    }
/**
     * @OA\Delete(
     *      path="/api/term/{id}",
     *      security={{"api":{}}},
     *      operationId="term_delete",
     *      tags={"Terms"},
     *      summary="Delete existing project",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(name="id", description="Project id", required=true, in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function destroy($id)
    {
        $model = Term::find($id);
        if($model){
            try {
                $model->delete();
                return response()->json(['message'  =>  "O`chirildi"], 200);
            }catch (\Exception $e) {
                return response()->json(["errors"   =>  [$e]], 403);
            }
        }
        return response()->json(['errors' => ['Not found']], 404);
    }


}
