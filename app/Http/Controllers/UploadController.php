<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    static function uploadImages(Request $request): void
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webm,webp|max:2048'
        ]);

        $images = $request->file('images');
        foreach ($images as $image) {
            $imageName = $image->getClientOriginalName();

            $image->move(public_path('images'), $imageName);
        }
    }
}
