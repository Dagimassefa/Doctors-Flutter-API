<?php

namespace App\Traits;
use Illuminate\Support\Str;


trait ImageUpload
{

public function uploadImage($file)
{
    try {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $imageName = Str::uuid()->toString() . '.' . $file->extension();
            // Public Folder
            $file->move(public_path('files'), $imageName);
            return $imageName;
        }
        return null; // Or handle the case when $file is not an instance of UploadedFile
    } catch (\Throwable $th) {
        throw $th;
    }
}

public function uploadFile($file)
{
    try {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $docName = Str::uuid()->toString() . '.' . $file->extension();
            // Public Folder
            $file->move(public_path('docs'), $docName);
            return $docName;
        }
        return null; // Or handle the case when $file is not an instance of UploadedFile
    } catch (\Throwable $th) {
        throw $th;
    }
}

  public function unlinkImage($file_name)
{
    try {
        $path = public_path() . '/docs/';
        if ($file_name && file_exists($path . $file_name)) {
            unlink($path . $file_name);
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

}
