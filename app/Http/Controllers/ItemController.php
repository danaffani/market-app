<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('stock', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Item::create($request->all());
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $item->update($request->all());
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index');
    }

    /**
     * Preview sale page
     */
    public function previewSale()
    {
        $items = Item::all();
        return view('preview_sale', compact('items'));
    }

    /**
     * Final sale page
     */
    public function finalSale()
    {
        // Assuming you have a way to get the sales data
        $sales = []; // Replace with actual sales data
        $total = 0; // Calculate the total price

        return view('final_sale', compact('sales', 'total'));
    }

    /**
     * Complete the sale
     */
    public function completeSale(Request $request)
    {
        $salesData = $request->input('sales'); // Expecting an array of sales data

        foreach ($salesData as $data) {
            $item = Item::find($data['id']);
            if ($item) {
                $item->available_amount -= $data['quantity'];
                $item->sold_amount += $data['quantity'];
                $item->save();
            }
        }

    return redirect()->route('items.index'); // Redirect to the stock page
}
}