<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\CustomCutDryice;
use App\Models\Product;
use App\Models\ProductAttribut;
use App\Models\ProductFaq;
use App\Models\ProductShippings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();
        if ($request->name) {
            $products = $products->where('name', 'like', '%' . trim(addslashes($request->name) . '%'));
        }
        if ($request->slug) {
            $products = $products->where('slug', 'like', '%' . $request->slug . '%');
        }

        if (isset($request->active)) {
            $products = $products->where('status', $request->active);
        }

        if ($request->fieldName && $request->shortBy) {
            $products->orderBy($request->fieldName, $request->shortBy);
        }

        $perPage = $request->perPage ?? 20;

        $products = $products
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/product/ProductList', ['products' => $products]);
    }

    public function customcutdryice(Request $request)
    {
        $customcutdryicerequest = CustomCutDryice::query();
        if ($request->name) {
            $customcutdryicerequest = $customcutdryicerequest->where('name', 'like', '%' . trim(addslashes($request->name) . '%'));
        }
        if ($request->email) {
            $customcutdryicerequest = $customcutdryicerequest->where('email', 'like', '%' . $request->email . '%');
        }

       
        $perPage = $request->perPage ?? 20;

        $customcutdryicerequest = $customcutdryicerequest
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/product/CustomCutDryice', ['customcutdryicerequest' => $customcutdryicerequest]);
    }

    public function contact_us(Request $request)
    {
        $contact_us = ContactUs::query();
        if ($request->name) {
            $contact_us = $contact_us->where('full_name', 'like', '%' . trim(addslashes($request->name) . '%'));
        }
        if ($request->email) {
            $contact_us = $contact_us->where('email', 'like', '%' . $request->email . '%');
        }

       
        $perPage = $request->perPage ?? 20;

        $contact_us = $contact_us
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Admin/ContactUs', ['contact_us' => $contact_us]);
    }

    public function ProductCreate(Request $request)
    {
        if ($request->isMethod('POST')) {
            $rules = [
                'name' => 'required|regex:/^[0-9A-Za-z.\s,\'-]*$/',
                'description' => 'required|max:5000',
                'status' => 'required',
                'thumbnail' => 'required|mimes:jpeg,png,jpg|max:2048',
                'stock' => ['required', 'numeric'],
                'slug' => 'required|max:225',
                'h1' => 'nullable|max:225',
                'meta_title' => ['nullable', 'max:500'],
                'meta_description' => 'nullable|max:500',
                'open_graph_title' => ['nullable', 'max:500'],
                'open_graph_description' => 'nullable|max:500',
                'open_graph_url' => ['nullable', 'url'],
                'open_graph_image' => ['nullable', 'mimes:jpeg,png,jpg', 'max:2048'],
                'featured_image' => ['nullable', 'mimes:jpeg,png,jpg', 'max:2048'],
                'x_card_description' => 'nullable|max:500',
                'x_card_title' => 'nullable|max:500',
                'product_attr' => 'required|array',
                'product_attr.*.size' => 'required|max:225',
                'product_attr.*.price' => 'required|numeric|min:0|max:999999',
                'product_attr.*.dtls' => 'required|max:500',
                'product_shipping' => 'required|array',
                'product_shipping.*.minimum_order' => 'required|numeric',
                'product_shipping.*.price' => 'required|numeric|min:0|max:999999',
                'faqs' => 'required|array',
                'faqs.*.question' => 'required',
                'faqs.*.answer' => 'required',
               
            ];

            $customMessages = [
                'name.required' => 'The name field is required and may contain letters and numbers.',
                'slug.required' => 'The slug field is required',
                'description.required' => 'The description field is required',
                'status.required' => 'The status field is required',
                'thumbnail.required' => 'The thumbnail field is required',
                'thumbnail.max' => 'The thumbnail size should be less than 2MB',
                'open_graph_image.max' => 'The open graph image size should be less than 2MB',
                'stock.required' => 'The stock field is required',
                'stock.numeric' => 'The stock field must be a number',
                'product_attr.*.size.required' => 'The field is required',
                'product_attr.*.size.max' => 'The field should not be more than 225',
                'product_attr.*.dtls.required' => 'The field is required',
                'product_attr.*.dtls.max' => 'The field should not be greater than 500',
                'product_attr.*.price.required' => 'The field is required',
                'product_attr.*.price.numeric' => 'The field should be numeric',
                'product_attr.*.price.max' => 'The field should not be greater than 999999',
                'product_shipping.*.price.required' => 'The field is required',
                'product_shipping.*.price.numeric' => 'The field should be numeric',
                'product_shipping.*.price.max' => 'The field should not be greater than 999999',
                'product_shipping.*.minimum_order.required' => 'The field is required',
                'product_shipping.*.minimum_order.numeric' => 'The field should be numeric',
                
            ];
            try {
                $request->validate($rules, $customMessages);
            } catch (ValidationException $e) {
                return back()->withErrors($e->errors())->withInput();
            }

            try {
                $product = new Product;
                $product->name = $request->name;
                $product->description = $request->description;
                $product->status = $request->status;
                $product->available_stock = $request->stock;
                if ($request->hasFile('thumbnail')) {
                    $file = $request->file('thumbnail');
                    $path = 'products-thumbnail';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->image = $final_image_url;
                }
                $product->slug = $request->slug;
                $product->h1 = $request->h1;
                $product->meta_title = $request->meta_title;
                $product->meta_description = $request->meta_description;
                $product->open_graph_title = $request->open_graph_title;
                $product->open_graph_description = $request->open_graph_description;
                $product->open_graph_url = $request->open_graph_url;
                $product->x_card_title = $request->x_card_title;
                $product->x_card_description = $request->x_card_description;
                // $product->canonical_url = $request->canonical_url;

                if ($request->hasFile('open_graph_image')) {
                    $file = $request->file('open_graph_image');
                    $path = 'open_graph_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->open_graph_image = $final_image_url;
                }

                if ($request->hasFile('featured_image')) {
                    $file = $request->file('featured_image');
                    $path = 'seo_featured_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->featured_image = $final_image_url;
                }

                $product->save();
                if ($request->product_attr[0]['size'] != null) {
                    foreach ($request->product_attr as $k) {
                        $product_attr = new ProductAttribut;
                        $product_attr->product_id = $product->id;
                        $product_attr->size = $k['size'];
                        $product_attr->details = $k['dtls'];
                        $product_attr->price = $k['price'];
                        $product_attr->save();
                    }
                }

                if ($request->product_shipping[0]['minimum_order'] != null) {
                    foreach ($request->product_shipping as $k) {
                        $product_shipping = new ProductShippings;
                        $product_shipping->product_id = $product->id;
                        $product_shipping->minimum_order = $k['minimum_order'];
                        $product_shipping->price = $k['price'];
                        $product_shipping->save();
                    }
                }
                if ($request->faqs[0]['question'] != null) {
                    foreach ($request->faqs as $k) {
                        $faq = new ProductFaq;
                        $faq->product_id = $product->id;
                        $faq->question = $k['question'];
                        $faq->answer = $k['answer'];
                        $faq->save();
                    }
                }

                session()->flash('success', 'Product successfully created');
                return redirect()->route('admin.product.list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/product/CreateEdit');
    }

    public function changeProductStatus(Request $request)
    {
        $product = Product::find($request->id);
        try {
            $product->status = !$product->status;
            $product->save();
            session()->flash('success', 'Product status successfully changed');
            return back();
        } catch (\Throwable $th) {
            Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
            abort(500);
        }
    }


    public function productDelete($id)
    {
        $product = Product::find($id);
        if (isset($product->thumbnail) && file_exists($product->thumbnail)) {
            @unlink($product->thumbnail);
        }
        Product::where('id', $id)->delete();

        session()->flash('success', 'Product successfully deleted');
        return back();
    }

    public function editProduct(Request $request, $id)
    {
        $product = Product::find($id);
        $product_attributes = ProductAttribut::where('product_id', $id)->get();
        $product_shippings = ProductShippings::where('product_id', $id)->get();
        $faqs = ProductFaq::where('product_id', $id)->get();
        $prev_picture = $product->image;
        $prev_picture_open_graph = $product->open_graph_image;
        $prev_featured_image = $product->featured_image;

        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'name' => 'required|max:50',
                'description' => 'required|max:5000',
                'status' => 'required',
                'thumbnail' => $request->hasFile('thumbnail') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'stock' => ['required', 'numeric'],
                'slug' => 'required|max:225',
                'h1' => 'nullable|max:225',
                'meta_title' => ['nullable', 'max:500'],
                'meta_description' => 'nullable|max:500',
                'open_graph_title' => ['nullable', 'max:500'],
                'open_graph_description' => 'nullable|max:500',
                'open_graph_image' => $request->hasFile('open_graph_image') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'featured_image' => $request->hasFile('featured_image') ? 'mimes:jpeg,png,jpg|max:2048' : '',
                'open_graph_url' => ['nullable', 'url'],
                'x_card_description' => 'nullable|max:500',
                'x_card_title' => 'nullable|max:500',
                'product_attr' => 'required|array',
                'product_attr.*.size' => 'required|max:225',
                'product_attr.*.price' => 'required|numeric|min:0|max:999999',
                'product_attr.*.dtls' => 'required|max:500',
                'product_shipping' => 'required|array',
                'product_shipping.*.minimum_order' => 'required|numeric',
                'product_shipping.*.price' => 'required|numeric|min:0|max:999999',
                'faqs' => 'required|array',
                'faqs.*.question' => 'required',
                'faqs.*.answer' => 'required',
            ], [
                'name.required' => 'The name field is required and may contain letters and numbers.',
                'slug.required' => 'The slug field is required',
                'description.required' => 'The description field is required',
                'status.required' => 'The status field is required',
                'thumbnail.required' => 'The thumbnail field is required',
                'thumbnail.max' => 'The thumbnail size should be less than 2MB',
                'open_graph_image.max' => 'The thumbnail size should be less than 2MB',
                'stock.required' => 'The stock field is required',
                'stock.numeric' => 'The stock field must be number',
                'product_attr.*.size.required' => 'The field is required',
                'product_attr.*.size.max' => 'The field should not be more than 225',
                'product_attr.*.dtls.required' => 'The field is required',
                'product_attr.*.dtls.max' => 'The field should not be greater than 500',
                'product_attr.*.price.required' => 'The field is required',
                'product_attr.*.price.numeric' => 'The field should be numeric',
                'product_attr.*.price.max' => 'The field should not be greater than 999999',
                'product_shipping.*.price.required' => 'The field is required',
                'product_shipping.*.price.numeric' => 'The field should be numeric',
                'product_shipping.*.price.max' => 'The field should not be greater than 999999',
                'product_shipping.*.minimum_order.required' => 'The field is required',
                'product_shipping.*.minimum_order.numeric' => 'The field should be numeric',
                
            ]);
            try {
                $product->name = $request->name;
                $product->description = $request->description;
                $product->status = $request->status;
                $product->available_stock = $request->stock;
                if ($request->hasFile('thumbnail')) {
                    if (file_exists($prev_picture)) {
                        @unlink($prev_picture);
                    }

                    $file = $request->file('thumbnail');
                    $path = 'products-thumbnail';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->image = $final_image_url;
                }
                $product->slug = $request->slug;
                $product->h1 = $request->h1;
                $product->meta_title = $request->meta_title;
                $product->meta_description = $request->meta_description;
                $product->open_graph_title = $request->open_graph_title;
                $product->open_graph_description = $request->open_graph_description;
                $product->open_graph_url = $request->open_graph_url;
                $product->x_card_title = $request->x_card_title;
                $product->x_card_description = $request->x_card_description;
                $product->canonical_url = $request->canonical_url;

                if ($request->hasFile('open_graph_image')) {
                    if (file_exists($prev_picture_open_graph)) {
                        @unlink($prev_picture_open_graph);
                    }

                    $file = $request->file('open_graph_image');
                    $path = 'open_graph_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->open_graph_image = $final_image_url;
                }


                if ($request->hasFile('featured_image')) {
                    if (file_exists($prev_featured_image)) {
                        @unlink($prev_featured_image);
                    }
                    $file = $request->file('featured_image');
                    $path = 'seo_featured_image';
                    $final_image_url = ImageHelper::customSaveImage($file, $path);
                    $product->featured_image = $final_image_url;
                }

                $product->save();

                ProductAttribut::where('product_id', $id)->delete();
                if ($request->product_attr) {
                    foreach ($request->product_attr as $value) {
                        $product_attr = new ProductAttribut;
                        $product_attr->product_id = $id;
                        $product_attr->size = $value['size'];
                        $product_attr->details = $value['dtls'];
                        $product_attr->price = $value['price'];
                        $product_attr->save();
                    }
                }

                ProductShippings::where('product_id', $id)->delete();
                if ($request->product_shipping[0]['minimum_order'] != null) {
                    foreach ($request->product_shipping as $k) {
                        $product_shipping = new ProductShippings;
                        $product_shipping->product_id = $product->id;
                        $product_shipping->minimum_order = $k['minimum_order'];
                        $product_shipping->price = $k['price'];
                        $product_shipping->save();
                    }
                }
                ProductFaq::where('product_id', $id)->delete();
                if ($request->faqs[0]['question'] != null) {
                    foreach ($request->faqs as $k) {
                        $faq = new ProductFaq;
                        $faq->product_id = $product->id;
                        $faq->question = $k['question'];
                        $faq->answer = $k['answer'];
                        $faq->save();
                    }
                }
                session()->flash('success', 'Product successfully updated');
                return redirect()->route('admin.product.list');
            } catch (\Throwable $th) {
                Log::error(" :: EXCEPTION :: " . $th->getMessage() . "\n" . $th->getTraceAsString());
                abort(500);
            }
        }
        return Inertia::render('Admin/product/CreateEdit', compact('product', 'product_attributes' , 'product_shippings' , "faqs"));
    }
}
