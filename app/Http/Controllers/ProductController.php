<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Organization;
use App\Product;
use App\ProductQuality;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller {

    public function index() {
        return view('backend.product-lists');
    }

    public function add() {
        return view('backend.product');
    }

    public function store(StoreProductRequest $storeProductRequest) {
        $storeProductRequest->validated();

        DB::transaction(function () use ($storeProductRequest) {
            $product = new Product();
            $product->name = $storeProductRequest->name;
            $product->sac_code = $storeProductRequest->sac_code;
            $product->description = $storeProductRequest->description;
            $product->price = $storeProductRequest->price;
            $product->sgst = $storeProductRequest->sgst;
            $product->cgst = $storeProductRequest->cgst;
            $product->igst = $storeProductRequest->igst;
            $product->type = $storeProductRequest->type;
            $product->quality = $storeProductRequest->quality;
            $product->save();
        });

        return self::successResponse('Product data successfully saved.');
    }

    public function show($id) {

    }

    public function edit($id) {
        try {
            $productDetail = Product::find($id);
            return response()->json(['error' => false, 'data' => $productDetail]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function update(StoreProductRequest $storeProductRequest) {
        $storeProductRequest->validated();
        $product = Product::findOrFail($storeProductRequest->id);
        $product->name = $storeProductRequest->name;
        $product->sac_code = $storeProductRequest->sac_code;
        $product->description = $storeProductRequest->description;
        $product->price = $storeProductRequest->price;
        $product->sgst = $storeProductRequest->sgst;
        $product->cgst = $storeProductRequest->cgst;
        $product->igst = $storeProductRequest->igst;
        $product->type = $storeProductRequest->type;
        $product->quality = $storeProductRequest->quality;
        $product->save();
        return self::successResponse('Product data successfully updated.');
    }

    public function destroy($id) {
        try {
            $customerAccountNumber = Product::destroy($id);
            return response()->json(['error' => false, 'data' => $customerAccountNumber]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function lists() {
        $products = Product::select(['id', 'name', 'sac_code', 'description', 'price', 'cgst', 'sgst', 'igst', 'type', 'quality'])->get();
        return DataTables::of($products)->addColumn('action', function ($product) {
            $btn = '<a href="javascript:void(0)" class="btn btn-xs btn-primary productEdit" data-id="' . $product->id . '"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            $btn .= '<a href="javascript:void(0)" class="btn btn-xs btn-danger productDelete" data-id="' . $product->id . '"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            return $btn;
        })->toJson();
    }

    public function details($id, $quantity) {
        try {
            $productDetail = Product::find($id);
            $amount = $quantity * $productDetail->price;
            return response()->json(['error' => false, 'data' => ['amount' => $amount]]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }
}
