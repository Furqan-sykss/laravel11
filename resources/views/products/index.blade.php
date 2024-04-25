<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: lightgray">

    <div>
        <h3 class="text-center my-4">Laravel 11 </h3>
        <hr>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <div class="col-6">
                        <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>

                        <form class="d-flex" role="search" action="{{ route('products.index') }}" method="GET">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                                name="keyword" value="{{ request('keyword') }}">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>

                    </div>
                    <hr>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col" style="width: 20%">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/img/products/' . $product->image) }}"
                                                class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ 'Rp ' . number_format($product->price, 2, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                <button onclick="shareToWhatsApp({{ json_encode($product) }})">Share to
                                                    WhatsApp</button>
                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Products belum Tersedia.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //message with sweetalert
        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif


        function shareToWhatsApp(product) {


            // Membuat pesan teks
            var message = "Check out this product:\n";
            message += "Image: " + product.image_url + "\n";
            message += "Title: " + product.title + "\n";
            message += "Description: " + product.description + "\n";
            message += "Price: " + product.price + "\n";
            message += "Stock: " + product.stock;

            // Membuka WhatsApp dengan pesan teks
            var whatsappUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(message);
            window.open(whatsappUrl, '_blank');

        }
    </script>

</body>

</html>
