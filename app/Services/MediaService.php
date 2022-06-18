<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class MediaService extends Service
{
    public function uploadImage(UploadedFile $file): string
    {
        if (!$file->isValid())
        {
            return redirect()->back()->with([
                'error' => 'Please select a valid image file!'
            ]);
        }

        $imageName = time().'.'.$file->extension();

        $file->move(public_path('/avatar'), $imageName);
        return '/avatar/'.$imageName;
    }
}
