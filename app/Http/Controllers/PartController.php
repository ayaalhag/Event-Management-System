<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCategoryPartRequest;
use App\Http\Requests\AddPartRequest;
use App\Http\Requests\CategoryPartRequest;
use App\Http\Requests\CategoryPartsIdRequest;
use App\Http\Requests\PartRequest;
use App\Http\Resources\CategoryPartResource;
use App\Http\Resources\PartResource;
use App\Models\CategoryPart;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends BaseController
{
    public function showCategory()
    {
        $categoryPart = CategoryPartResource::collection(CategoryPart::get());
        return $this->sendResponse($categoryPart, "done");
    }

    public function ShowAllPart()
    {
        $parts = Part::with('category')->get();
        $part = PartResource::collection($parts);
        return $this->sendResponse($part, "done");
    }
    public function ShowByCategory()
    {
        $parts = Part::with('category')->get();
        $part = PartResource::collection($parts);
        return $this->sendResponse($part, "done");
    }

    public function showByCategory_id(CategoryPartsIdRequest $request)
    {
        $parts = Part::where('catgory_part_id', $request->category_id)
            ->with('category')
            ->get();

        $partResource = PartResource::collection($parts);

        return $this->sendResponse($partResource, "done");
    }


    // public function showById(PartRequest $request)
    // {
    //     $part = Part::find($request->part_id);
    //     if (!$part) {
    //         return $this->sendError("Part not found", 404);
    //     }
    //     $partResource = PartResource::make($part);
    //     return $this->sendResponse($partResource, "Done");
    // }
    public function showById(PartRequest $request)
    {
        $part_id = Part::find($request->part_id);

        if (!$part_id) {
            return $this->sendError("Part not found", 404);
        }
        $part =  new PartResource($part_id);
        return $this->sendResponse($part, "Done");
    }


    //for admin

    public function addCategory(AddCategoryPartRequest $request)
    {
        $categoryPart = categoryPart::create([
            'name' => $request->name,
        ]);
        $categoryPart->save();
        return $this->sendResponse($categoryPart, "done");
    }

    public function addPart(AddPartRequest $request)
    {
        $pictture_url = null;

        if ($request->hasFile('pictture_url')) {
            $ext = $request->file('pictture_url')->getClientOriginalExtension();
            $path = 'pictture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('pictture_url')->move(public_path($path), $name);
            $pictture_url = $path . $name;
        }

        $part = Part::create([
            'name' => $request->name,
            'price' => $request->price,
            'assessment' => $request->assessment,
            'pictture_url' => $pictture_url,
            'catgory_part_id' => $request->catgory_part_id,
        ]);

        return $this->sendResponse($part, "done");
    }



    public function editCategory(CategoryPartRequest $request)
    {
        CategoryPart::where('id', $request->catgory_part_id)->update([
            'name' => $request->name,
        ]);
        $categoryPart = CategoryPart::find($request->catgory_part_id);
        return $this->sendResponse($categoryPart, "done");
    }

    public function editPart(PartRequest $request)
    {

        $part = Part::find($request->part_id);
        if ($request->hasFile('picture_url')) {
            $ext = $request->file('picture_url')->getClientOriginalExtension();
            $path = 'picture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('picture_url')->move(public_path($path), $name);
            $picture_url = $path . $name;
            Part::where('id', $request->part_id)->update([
                'pictture_url' => $picture_url,
            ]);
        }
        Part::where('id', $request->part_id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'assessment' => $request->assessment,
            'catgory_part_id' => $request->catgory_part_id,
        ]);
        $part = Part::find($request->part_id);
        $data['part'] = new PartResource($part);
        return $this->sendResponse($data, "Edited successfully");
    }

    public function deleteCategory(CategoryPartRequest $request)
    {
        CategoryPart::where('id', $request->catgory_part_id)->first()->delete();
        return $this->sendResponse(null, "done");
    }

    public function deletePart(PartRequest $request)
    {
        Part::where('id', $request->part_id)->first()->delete();
        return $this->sendResponse(null, "done");
    }


    public function searchByTypeLike_part(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json([
                'status' => 400,
                'message' => 'search part is required',
            ]);
        }

        $part = Part::where('catgory_part_id', 'LIKE', "%{$search}%")->get();

        return response()->json([
            'status' => 200,
            'message' => 'Part retrieved successfully',
            'part' => $part
        ]);
    }


    public function searchByPriceLessThanOrEqual(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return response()->json([
                'status' => 400,
                'message' => 'Search amount is required',
            ]);
        }

        if (!is_numeric($search)) {
            return response()->json([
                'status' => 400,
                'message' => 'Search amount must be a valid number',
            ]);
        }

        $part = Part::where('price', '<=', $search)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Parts retrieved successfully',
            'parts' => $part
        ]);
    }

}
