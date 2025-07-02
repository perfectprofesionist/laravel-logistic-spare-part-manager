<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRule;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    public function index()
    {

        // Paginate products, 10 per page
        $products = Product::latest()->paginate(20);
        return view('products.index', compact('products')); // Pass the paginated products to the view
    }


    public function create()
    {
        return view('products.create'); // View for creating a new product
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'internal_external' => 'required|in:internal,external,none',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'quantity' => 'required|integer|min:0',
            'length_units' => 'nullable|numeric',
            'fitment_time' => 'required|numeric|min:0',
            'depends_on_products' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('productfiles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'productfiles/' . $imageName;
        }


        // Create product
        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        //$allProducts = Product::select('id as value', 'name as text', 'image')->get();
        $productRules = $product->productRules();
        $allProducts = Product::select('id', 'name',  'image')
        ->get()
        ->map(function ($product) {
            return [
                'value' => $product->id,
                'text' => $product->name,
                'continent' => 'Product', // or whatever static value you need,
                'image' => asset($product->image),
                "depends_on_products" => $product->depends_on_products,
            ];
        })
        ->toArray();

        return view('products.edit', compact('product', 'allProducts','productRules'));
    }






    // Update product
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'internal_external' => 'required|in:internal,external,none',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'image' => 'nullable|file|mimes:jpg,jpeg,png',
            'quantity' => 'required|integer|min:0',
            'length_units' => 'nullable|numeric',
            'fitment_time' => 'required|numeric|min:0',
             'depends_on_products' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = public_path('productfiles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
            $validated['image'] = 'productfiles/' . $imageName;
        }



        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    // Update product
    public function updateRelation(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'allowed_products'   => 'required|array|min:1',
            'allowed_products.*' => 'integer',
            'max_total'          => 'required|integer|min:1',
            'message'            => 'required|string|max:255',
            'id'                 => 'required|integer|exists:product_rules,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Fetch the rule to update
        $rule = ProductRule::find($request->id);

        // Update the fields
       // $rule->allowed_products = json_encode($request->allowed_products); // stored as JSON in DB

        $allowedProducts = array_map('intval', $request->allowed_products);
        $rule->allowed_products = $allowedProducts;


        $rule->max_total        = $request->max_total;
        $rule->message          = $request->message;
        $rule->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product rule updated successfully.',
            'data'    => $rule
        ]);
        
    }


    public function storeRelation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'allowed_products'   => 'required|array|min:1',
            'allowed_products.*' => 'integer',
            'max_total'          => 'required|integer|min:1',
            'message'            => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $allowedProducts = array_map('intval', $request->allowed_products);

        $rule = new ProductRule();
        $rule->allowed_products = $allowedProducts; // Laravel will cast this to JSON
        $rule->max_total = $request->max_total;
        $rule->message = $request->message;
        $rule->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product rule created successfully.',
            'data'    => $rule
        ]);
    }

    public function deleteRelation($id)
    {
        $rule = ProductRule::find($id);

        if (!$rule) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rule not found.'
            ], 404);
        }

        $rule->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product rule deleted successfully.'
        ]);
    }

    // Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
