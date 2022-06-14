<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Tax</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->tax }}</td>
            <td>{{ $product->stock }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
