<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BoxPack;
use App\Services\Items;

class BoxPackController extends Controller
{
    protected $boxPacker;


    public function __construct(BoxPack $boxPacker)
    {
        $this->boxPacker = $boxPacker;
    }

    public function packProducts(Request $request, BoxPack $boxPacker)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.length' => 'required|integer|min:1',
            'items.*.width' => 'required|integer|min:1',
            'items.*.height' => 'required|integer|min:1',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        foreach ($request->items as $itemData) {
            $boxPacker->addItem(new Items(
                $itemData['name'],
                $itemData['length'],
                $itemData['width'],
                $itemData['height'],
                $itemData['weight'],
                $itemData['quantity']
            ));
        }

        $packedBoxes = $boxPacker->pack();

        return view('box-pack-result', compact('packedBoxes'));
    }
}