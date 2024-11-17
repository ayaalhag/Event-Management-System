<?php

namespace App\Http\Controllers;

use App\Http\Resources\PriceResource;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class PriceController extends Controller
{
    public function index()
    {
        $price = PriceResource::collection(Price::query()->get());
        if ($price->isEmpty()) {
            return response()->json([
                'message' => 'No Price foundes',
            ], Response::HTTP_PARTIAL_CONTENT);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Get all Price Successfully',
            'Price' => $price
        ]);
    }
}
