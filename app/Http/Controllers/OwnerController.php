<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerRequest;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class OwnerController extends Controller
{
    public function index()
    {
        $Owner = OwnerResource::collection(Owner::query()->get());
        if ($Owner->isEmpty()) {
            return response()->json([
                'message' => 'No Owner foundes',
            ], Response::HTTP_PARTIAL_CONTENT);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Get all Owner Successfully',
            'Owner' => $Owner
        ]);
    }


    public function store(OwnerRequest $request)
    {
        $owner = Owner::create($request->validated());

        return response()->json([
            'status' => 201,
            'message' => 'Owner created successfully',
            'owner' =>OwnerResource::make($owner)
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::find($id);

        if (!$owner) {
            return response()->json([
                'status' => 404,
                'message' => 'Owner not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric|min:0',
        ]);

        $owner->update(array_filter($validatedData));

        return response()->json([
            'status' => 200,
            'message' => 'Owner updated successfully',
            'owner' => OwnerResource::make($owner)
        ], 200);
    }

    public function destroy($id)
    {
        $owner = Owner::find($id);
        if (!$owner) {
            return response()->json([
                'status' => 404,
                'message' => 'Owner not found',
            ], 404);
        }

        $owner->delete();

        return response()->json([
            'status' => 204,
            'message' => 'Owner deleted successfully. The deletion process has been completed.',
        ], 204);
    }


}
