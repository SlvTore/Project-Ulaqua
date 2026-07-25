<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class PublicItemController extends Controller
{
    public function index()
    {
        // Query items where is_active is true and category_id is 1 (Produk Jadi)
        $items = Item::with(['category', 'unit'])
            ->where('is_active', true)
            ->where('category_id', 1)
            ->get();

        // Format data for React frontend
        $products = $items->map(function ($item, $index) {
            // Map default images based on the index or name
            $imageNum = ($index % 3) + 1;
            $imagePath = "assets/images/resource/shop/shop-{$imageNum}.jpg";

            return [
                'id' => $item->id,
                'name' => $item->name,
                'sku' => $item->sku,
                'category' => $item->category->name ?? 'Produk Jadi',
                'unit' => $item->unit->name ?? 'Pcs',
                'price' => 'Rp ' . number_format($item->default_price, 0, ',', '.'),
                'raw_price' => $item->default_price,
                'stock' => $item->expected_stock,
                'is_out_of_stock' => $item->expected_stock <= 0,
                'image' => $imagePath,
                'delay' => ($index * 300) . 'ms',
                'link' => 'https://wa.me/6282119425191?text=' . urlencode("Halo Ulaqua, saya tertarik untuk memesan produk " . $item->name . ". Apakah stoknya tersedia?"),
            ];
        });

        return response()->json($products);
    }

    public function recordView($id)
    {
        $item = Item::where('is_active', true)->where('id', $id)->firstOrFail();

        $view = \App\Models\ProductView::firstOrCreate(
            ['item_id' => $item->id],
            ['views' => 0]
        );
        
        $view->increment('views');

        return response()->json(['success' => true, 'views' => $view->views]);
    }
}
