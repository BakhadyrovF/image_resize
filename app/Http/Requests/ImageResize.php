<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImageResize extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "image" => ["required"],
            "w" => ["required", "regex:/^\d+(\.\d+)?%?$/"],
            "h" => ["regex:/^\d+(\.\d+)?%?$/"],
            "album_id" => ["exists:albums,id"]
        ];



    }
}
