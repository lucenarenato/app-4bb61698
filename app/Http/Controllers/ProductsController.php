<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\SKUGenerator;
use App\Http\Requests\ProductsRequest;
use App\Http\Resources\ProductsResource;
use App\Http\Controllers\HistoryController;
use BinaryCats\Sku\Concerns\SkuGenerator as Sku;

class ProductsController extends Controller
{
    public function index(Products $Products)
    {
        $response = [];
        $allData = ProductsResource::collection($Products::all());
        // Condition for if there is no data to be displayed
        if (count($allData) > 0) {
            $response['status'] = 1;
            $response['data'] = $allData;
        } else {
            $response['status'] = 0;
            $response['data'] = [];
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $produtos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [];
        $prod = Products::find($id);

        if ($prod) {
            $response['status'] = 1;
            $response['data'] = new ProductsResource($prod);
        } else {
            $response['status'] = 0;
            $response['mensagem'] = 'Product not available or not found...';
        }

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        $response = [];

        try {
            $Product = new Products;
            $Product->name = $request->name;
            $Product->sku = $request->sku;
            $Product->quantity = $request->quantity;
            $Product->price = $request->price;
            $Product->save();

            $response['status'] = 1;
            $response['data'] = new ProductsResource($Product);
            return response()->json($response, 200);

            /*return response()->json([
                'products_id' => $Product['id'],
                'Success' => 'success'
            ], 200);*/
        } catch (\Throwable $th) {
            $response['status'] = 0;
            $response['error'] = $th->getMessage();
            $response['mensagem'] = 'Could not perform this action...';
        }

        return response($response, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $produtos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = [];
        \Log::debug(json_encode($request->all()));
        try {
            $History = new HistoryController;
            $Product = Products::find(intval($id));

            \Log::debug(json_encode($Product));
            \Log::debug(json_encode($id));

            // Create the movimentation history
            $History->store($request->all(), $Product);

            \Log::debug(json_encode($History));

            // Atualiza o registro
            $Product->update($request->all());

            $response['status'] = 1;
            $response['mensagem'] = 'Product successfully updated';
        } catch (\Throwable $th) {
            $response['status'] = 0;
            $response['error'] = $th->getMessage();
            $response['mensagem'] = 'Could not perform this action...';
        }

        return response($response, 200);
    }

    public function updateSkus()
    {
        $prodSku = Products::get()->each(function ($product) {
            \Log::debug(json_encode($product));
            $SkuGenerator = new SkuGenerator;
            $sku = new Sku;
            $product->update([
                'sku' => $sku($product)->render()
                //'sku' => $SkuGenerator->generate($product->name, $product->toArray())

            ]);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $produtos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
        \Log::debug('delete id: ' . $id);
        try {
            Products::destroy($id);

            $response['status'] = 1;
            $response['mensagem'] = 'Product successfully deleted';
        } catch (\Throwable $th) {
            $response['status'] = 0;
            $response['error'] = $th->getMessage();
            $response['mensagem'] = 'Could not perform this action...';
        }
        return response($response, 200);
    }
}
