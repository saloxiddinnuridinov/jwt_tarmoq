<?php

namespace App\Http\Controllers\V1\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\show\ReturnTermResource;
use App\Models\ImageFile;
use App\Models\ObjectFile;
use App\Models\Term;
use App\Models\VideoFile;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student', ['except' => []]);
    }

    /**
     * @OA\Get(
     * path="/api/get-term/{term}/{from}",
     * security={{"student":{}}},
     * summary="Get Term term",
     * description="bitta termda hamma malumotlarini ko'rsatadi",
     * operationId="term_getTerm",
     * tags={"Terms Student"},
     * @OA\Parameter(name="term", description="Term name", required=true, in="path",
     *    @OA\Schema(type="string")
     * ),
     * @OA\Parameter(name="from", description="from name", required=true, in="path",
     *    @OA\Schema(type="string", enum={"keyword_latin", "keyword_ru","keyword_uz"},)
     * ),
     *
     * @OA\Response(response=200, description="success",
     *    @OA\JsonContent(ref="#/components/schemas/Term"),
     * ),
     * @OA\Response(response=404,description="Not found",
     *    @OA\JsonContent(ref="#/components/schemas/Error"),
     * ),
     * )
     */
    public function getTerms($term, $from){
        $result = Term::select("*")
            ->where($from, 'LIKE', "%$term%")
            ->get();
        return ReturnTermResource::collection($result);
    }
    /**
     * @OA\Get(
     * path="/api/get-image/{term_id}/",
     * security={{"student":{}}},
     * summary="Show term",
     * description="Imageni olish",
     * operationId="Image_term",
     * tags={"Terms Student"},
     * @OA\Parameter(name="term_id", description="image id", required=true, in="path",
     *    @OA\Schema(type="integer")
     * ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function getImage($id){
        $result = ImageFile::select("*")
            ->join("term_join_image_files", "term_join_image_files.image_file_id", "=", "image_files.id")
            ->where("term_join_image_files.term_id", $id)
            ->get();
        return ReturnTermResource::collection($result);
    }
    /**
     * @OA\Get(
     * path="/api/get-video/{term_id}/",
     * security={{"student":{}}},
     * summary="Show term",
     * description="Videoni olish",
     * operationId="Video_term",
     * tags={"Terms Student"},
     * @OA\Parameter(name="term_id", description="image id", required=true,in="path",
     *    @OA\Schema(type="integer")
     * ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function getVideo($id){
        $result = VideoFile::select("*")
            ->join("term_join_video_files", "term_join_video_files.video_file_id", "=", "video_files.id")
            ->where("term_join_video_files.term_id", $id)
            ->get();
        return ReturnTermResource::collection($result);
    }
    /**
     * @OA\Get(
     * path="/api/get-object/{term_id}/",
     * security={{"student":{}}},
     * summary="Show term object",
     * description="Objectni olish",
     * operationId="Object_term",
     * tags={"Terms Student"},
     * @OA\Parameter(name="term_id", description="image id", required=true, in="path",
     *    @OA\Schema(type="integer")
     * ),
     *      @OA\Response(response=200, description="success",
     *          @OA\JsonContent(ref="#/components/schemas/Term"),
     *      ),
     *      @OA\Response(response=404,description="Not found",
     *          @OA\JsonContent(ref="#/components/schemas/Error"),
     *      ),
     * )
     */
    public function getObject($id){
        $result = ObjectFile::select("*")
            ->join("term_join_object_files", "term_join_object_files.object_file_id", "=", "object_files.id")
            ->where("term_join_object_files.term_id", $id)
            ->get();
        return ReturnTermResource::collection($result);
    }
}
