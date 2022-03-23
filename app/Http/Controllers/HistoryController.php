<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\HistoriesResource;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(History $History)
    {
        $response = [];
        $allData = HistoriesResource::collection($History::all());
        // Condição para caso não existir dados a serem exibidos
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
     * Store the data at the product update
     * 
     * @param $productReq
     * @return \Illuminate\Http\Response
     */
    public function store($productReq, $productDB)
    {
        $action = '';
        $response = [];
        $difference = 0;

        \Log::debug('debug history');
        \Log::debug(json_encode($productReq));
        \Log::debug(json_encode($productDB));

        try {
            $History = new History;
            // Validating if the product SKU has changed
            if ($productDB->sku != $productReq['sku'] && $productReq['sku'] != '') {
                $History->sku = $productReq['sku'];
            } else {
                $History->sku = $productDB->sku;
            }
            // Condition to check whether the quantity has been added or removed
            if ($productDB->quantity < $productReq['quantity']) {
                $action = 'added';
                $difference = $productReq['quantity'] - $productDB->quantity;
            } else if ($productDB->quantity > $productReq['quantity']) {
                $action = 'removed';
                $difference = $productDB->quantity - $productReq['quantity'];
            } else {
                $action = 'none';
            }

            $History->qtd = json_encode(array(
                "action" => $action,
                "oldQtd" => $productDB->quantity,
                "newQtd" => $productReq['quantity'],
                "differenceBetween" => $difference
            ));

            \Log::debug('prod id: ' . $productDB->id);

            $History->productID = $productDB->id;
            $History->save();

            \Log::debug(json_encode($History));

            $response['status'] = 1;
            $response['data'] = $productDB;
        } catch (\Throwable $th) {
            $response['status'] = 0;
            $response['error'] = $th->getMessage();
            $response['mensagem'] = 'Could not perform this action...';
        }

        return response($response, 201);
    }
}
