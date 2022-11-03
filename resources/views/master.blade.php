<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

    <title>Marketplace</title>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <a href="{{ route('product.create') }}" class="btn btn-md btn-success mb-3">CREATE PRODUCT</a>
                        <table class="table table-bordered">
                            <thead>
                              <tr class="text-center">
                                <th scope="col">NAME</th>
                                <th scope="col">PRICE</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">ACTION</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($product as $p)
                                <tr>
                                    <td>{{ $p->nama }}</td>
                                    <td>{!! $p->harga !!}</td>
                                    <td class="text-center">
                                        <img src="{{ Storage::url('public/product/').$p->gambar }}" class="rounded" style="width: 150px" alt="product image">
                                    </td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('product.destroy', $p->id) }}" method="POST">
                                            <a href="{{ route('product.edit', $p->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                              @empty
                                  <div class="alert alert-danger">
                                      Data Post belum Tersedia.
                                  </div>
                              @endforelse
                            </tbody>
                          </table>  
                          
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
