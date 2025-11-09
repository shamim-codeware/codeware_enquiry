<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Models\ProductType;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = "Product ";
        $description = "Some description for the page";

        $query = Product::with(['users', 'categories', 'types'])->orderBy('id','DESC');

        // Keyword
        if ($request->keyword) {
            $query->where('name', 'like', "%$request->keyword%");
        }
        $products = $query->paginate(50);

        return view('pages.settings.product.index', compact('title', 'description', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Product ";
        $description = "Some description for the page";

        return view('pages.settings.product.create', compact('title', 'description'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productcategory = new Product();
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $productcategory->fill($data)->save();
        return  redirect()->back()->with('success', 'Success! Create Product');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Product Category";
        $description = "Some description for the page";
        $types = ProductType::orderBy('id', 'DESC')->get();
        $product = Product::with(['types', 'categories'])->findOrFail($id);
        return view('pages.settings.product.edit', compact('title', 'description', 'product', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $product->fill($request->all())->save();
        return  redirect('product')->with('success', 'Success! Update Product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function QueryProduct(Request $request){

        $producttype = Product::where('type_id', $request->type)->where('category_id', $request->category)->orderBy('id', 'DESC')->get();

        return $producttype;
    }
}
