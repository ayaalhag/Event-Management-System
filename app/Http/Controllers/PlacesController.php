<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlaceResource;
use App\Models\CategoryPlace;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Requests\AddCategoryPartRequest;
use App\Http\Requests\AddPlaceRequest;
use App\Http\Requests\PlaceRequest;
use App\Models\CategoryPart;
use App\Models\Part;
use App\Http\Requests\CategoryPlaceRequest;

class PlacesController extends BaseController
{
    public function showCategory()
    {
        $categoryPlace = CategoryPlace::all();
        return $this->sendResponse($categoryPlace, "done");
    }

    public function addCategory(AddCategoryPartRequest $request)
    {
        $categoryPlace = categoryPlace::create([
            'name' => $request->name,
        ]);
        $categoryPlace->save();
        return $this->sendResponse($categoryPlace, "done");
    }
    public function editCategory(CategoryPlaceRequest $request)
    {
        CategoryPlace::where('id', $request->catgory_place_id)->update([
            'name' => $request->name
        ]);
        $categoryPlace = CategoryPlace::find($request->catgory_place_id);
        return $this->sendResponse($categoryPlace, "done");
    }
    public function deleteCategory(CategoryPlaceRequest $request)
    {
        CategoryPlace::where('id', $request->catgory_place_id)->first()->delete();
        return $this->sendResponse(null, "done");
    }

    public function ShowAllPlaces(CategoryPlaceRequest $request)
    {
        $place = Place::with('category')->get();
        $places=PlaceResource::collection($place);
        return $this->sendResponse($places, "done");
    }

    public function showById(PlaceRequest $request)
    {
        $places = Place::find($request->place_id);
        return $this->sendResponse($places, "done");
    }


    public function addPlace(AddPlaceRequest $request)
    {
        $picture_url = null;

        if ($request->hasFile('picture_url')) {
            $ext = $request->file('picture_url')->getClientOriginalExtension();
            $path = 'picture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('picture_url')->move(public_path($path), $name);
            $picture_url = $path . $name;
        }

        // $image = 'null';
        // if ($request->hasFile("picture_url")) {
        //     $image = $request->file('picture_url');
        //     $imgpath = $image->store('images', 'public');
        //     $image = $imgpath;
        // }
        $place = Place::create([
            'name' => $request->name,
            'location' => $request->location,
            'phone' => $request->phone,
            'picture_url' => $picture_url,
            'assessment' => '0',
            'category_place_id' => $request->category_place_id,
        ]);
        $place->save();

        return $this->sendResponse($place, "done");
    }

    public function editPlace(PlaceRequest $request)
    {
        $place = Place::find($request->place_id);
        if ($request->hasFile('picture_url')) {
            $ext = $request->file('picture_url')->getClientOriginalExtension();
            $path = 'picture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('picture_url')->move(public_path($path), $name);
            $picture_url = $path . $name;
            $place->update([
                        'picture_url' => $picture_url,
                    ]);
        }

        // if ($request->hasFile("picture_url")) {
        //     $image = $request->file('picture_url');
        //     $imgpath = $image->store('images', 'public');
        //     $image = 'http://127.0.0.1:8000/storage/' . $imgpath;
        //     $place->update([
        //         'picture_url' => $image,
        //     ]);
        // }
        $validait = $request->validated();
        $place->update($validait);
        return $this->sendResponse($place, "done");
    }
    public function deletePlace(PlaceRequest $request)
    {
        Place::where('id', $request->place_id)->first()->delete();
        return $this->sendResponse(null, "done");
    }





    public function searchByTypeLike_place(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json([
                'status' => 400,
                'message' => 'search place is required',
            ]);
        }

        $place = Place::where('category_place_id', 'LIKE', "%{$search}%")->get();

        return response()->json([
            'status' => 200,
            'message' => 'place retrieved successfully',
            'place' => $place
        ]);
    }


    public function searchByPriceLessThanOrEqual_place(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json([
                'status' => 400,
                'message' => 'Search assessment is required',
            ]);
        }

        if (!is_numeric($search)) {
            return response()->json([
                'status' => 400,
                'message' => 'Search assessment must be a valid number',
            ]);
        }

        $place = Place::where('assessment', '<=', $search)->get();

        return response()->json([
            'status' => 200,
            'message' => 'place retrieved successfully',
            'place' => $place
        ]);
    }
}
