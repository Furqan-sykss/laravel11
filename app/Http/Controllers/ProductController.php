<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product;

//import return type View
use Illuminate\View\View;

//import return type redirectResponse
use Illuminate\Http\Request;

//import Http Request
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Redirect;


//import Facades Storage
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(Request $request) /*: View */
    {
        // Tampilkan input pencarian

        $keyword = $request->input('keyword');

        $products = Product::latest();

        if ($keyword) {
            $products->where('title', 'like', "%$keyword%")
                ->orWhere('description', 'like', "%$keyword%")
                ->orWhere('stock', 'like', "%$keyword%");
        }

        $products = $products->paginate(10);

        return view('products.index', compact('products'));


        // Daftar kata kunci yang diizinkan
        //     $allowedKeywords = ['apapun masalahnya, cintaku tetap kamu'];

        //     // Ambil nilai pencarian dari input form
        //     $keyword = $request->input('keyword');

        //     // Inisialisasi query utama untuk mengambil data produk
        //     $productsQuery = Product::latest();

        //     // Periksa apakah kata kunci yang dimasukkan pengguna sesuai dengan yang diizinkan
        //     if ($keyword && in_array($keyword, $allowedKeywords)) {
        //         // Jika sesuai, lakukan pencarian sesuai dengan kata kunci tersebut
        //         $productsQuery->where('title', $keyword);
        //     } elseif ($keyword) {
        //         // Jika kata kunci tidak sesuai dengan yang diizinkan, berikan pesan bahwa pencarian tidak valid
        //         return redirect()->route('products.index')->with('error', 'Pencarian tidak valid');
        //     }

        //     // Ambil 10 data produk per halaman
        //     $products = $productsQuery->paginate(10);

        //     // Kirim data produk ke view
        //     return view('products.index', compact('products'));
    }


    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);


        // Hapus tag HTML dari deskripsi
        $description = strip_tags($request->description);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/img/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.show', compact('product'));
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //render view with product
        return view('products.edit', compact('product'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //get product by ID
        $product = Product::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/img/products', $image->hashName());

            //delete old image
            Storage::delete('public/img/products' . $product->image);

            //update product with new image
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        } else {

            //update product without image
            $product->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        }

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        //get product by ID
        $product = Product::findOrFail($id);

        //delete image
        Storage::delete('public/products/' . $product->image);

        //delete product
        $product->delete();

        //redirect to index
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


    // /**
    //  * Share product to WhatsApp.
    //  *
    //  * @param  int  $id
    //  * @return RedirectResponse
    //  */
    // public function shareToWhatsApp($id): RedirectResponse
    // {
    //     // Get the product
    //     $product = Product::findOrFail($id);

    //     // Define the phone number to share with
    //     $phoneNumber = '6282238584400'; // Replace with the desired phone number

    //     // Create the message
    //     $message = "Check out this product:\n";
    //     $message .= "Title: " . $product->title . "\n";
    //     $message .= "Description: " . $product->description . "\n";
    //     $message .= "Price: " . $product->price . "\n";
    //     $message .= "Stock: " . $product->stock . "\n";


    //     // Create WhatsApp URL with phone number and message
    //     $whatsappUrl = 'https://api.whatsapp.com/send?phone=' . $phoneNumber . '&text=' . urlencode($message);

    //     // Redirect to WhatsApp URL
    //     return redirect()->back()->with('success', 'Produk berhasil dibagikan ke WhatsApp.');
    // }
}