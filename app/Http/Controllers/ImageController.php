<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
//        dd(database_path('database.sqlite'));
        return view('images.index');
    }

    public function show()
    {
        return Image::latest()->pluck('name')->toArray();
    }

    public function store(Request $request)
    {
        return response()->json(['error' => 'This is a test'], 500);
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'There is no image present.'], 400);
        }

        $request->validate([
            'image' => 'required|file|image|mimes:jpg,jpeg,png'
        ]);

        $path = $request->file('image')->store('public/images');

        if (!$path) {
            return response()->json(['error' => 'The file could not be saved.'], 500);
        }

        $uploadedFile = $request->file('image');


        return Image::create([
            'name' => $uploadedFile->hashName(),
            'extension' => $uploadedFile->extension(),
            'size' => $uploadedFile->getSize(),
        ])->name;
    }
}
