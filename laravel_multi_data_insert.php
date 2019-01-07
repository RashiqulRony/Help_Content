<?php

public function productVarientStore(Request $request){
        $variantType = $request->get('variant_type');
        $variant_name = $request->get('variant_name');
        $variant_quantity = $request->get('variant_quantity');
        $price_sell = $request->get('price_sell');
        $price_cost = $request->get('price_cost');
        $discount_type = $request->get('discount_type');
        $discount_text = $request->get('discount_text');
        $discount_amount = $request->get('discount_amount');
        $product_id = session('product_id');
        $qty = 0;
        for($i = 0; $i< count($variantType); $i++){
            $variant = new ProductVarient;
            $variant->product_id = $product_id;
            $variant->variant_type = $variantType[$i];
            $variant->variant_name = $variant_name[$i];
            $variant->variant_quantity = $variant_quantity[$i];
            $variant->discount_type = $discount_type[$i];
            $variant->discount_text = $discount_text[$i];
            $variant->discount_amount = $discount_amount[$i];
            $variant->price_sell = $price_sell[$i];
            $variant->price_cost = $price_cost[$i];
            $qty = $qty + intval($variant_quantity[$i]);
            $variant->save();
        }

        Product::where('id', '=', $product_id)->update(['quantity' => $qty]);
        return redirect('company/products')->with('success', 'Product  variant successfully');
    }
