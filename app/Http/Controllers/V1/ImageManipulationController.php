<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageResize;
use App\Http\Resources\V1\ImageManipulationResource;
use App\Models\Album;
use App\Models\ImageManipulation;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stringable;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;

//

class ImageManipulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ImageManipulationResource::collection(ImageManipulation::paginate());
    }


    public function resize(ImageResize $request)
    {
        $all = $request->all();
        $image = $request->image;

        $data = [
            "type" => "resize",
            "data" => json_encode($all),
            "user_id" => null,
        ];

        if(isset($all["album_id"]))
        {
            $data["album_id"] = $all["album_id"];
            unset($all["album_id"]);
        }


        $dir = "storage/images/" . Str::random(10) . "/";
        $absolutePath = public_path($dir);
        File::makeDirectory($absolutePath);



        $data["name"] = $image->getClientOriginalName();
        $fileName = pathinfo($data["name"], PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $imagePath = $absolutePath . $data["name"];
        $data["path"] = $dir.$data["name"];



        $image->move($absolutePath, $data["name"]);

        $w = $all["w"];
        $h = $all["h"] ?? false;

        list($width, $height, $interventionImage) = $this->getImageWidthAndHeight($w, $h, $imagePath);
        $resizedImagePath = $absolutePath . $fileName."resized". "." .$extension;

        $interventionImage->resize($width, $height)->save($resizedImagePath, 100);
        $data["output_path"] = $dir.$fileName."resized". "." .$extension;



        return new ImageManipulationResource(ImageManipulation::create($data));




    }


    public function show($id)
    {
        return new ImageManipulationResource(ImageManipulation::findOrFail($id));
    }

    public function byAlbum(Album $album)
    {
        return ImageManipulationResource::collection($album->images);
    }



    public function destroy($id)
    {
        ImageManipulation::destroy($id);

        return response("", 204);
    }

    public function getImageWidthAndHeight($w, $h, $absolutePath)
    {
        $image = Image::make($absolutePath);
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        if(str_ends_with($w, "%")){
            $ratioW = (float)str_replace("%", "", $w);
            $ratioH = $h ? (float)str_replace("%", "", $h) : $ratioW;

            $newWidth = $originalWidth * $ratioW / 100;
            $newHeight = $originalHeight * $ratioH / 100;
        }else{
            $newWidth = (float)$w;
            $newHeight = $h ?  (float)$h : $originalHeight * $newWidth / $originalWidth;
        }

        return [$newWidth, $newHeight, $image];

    }
}
