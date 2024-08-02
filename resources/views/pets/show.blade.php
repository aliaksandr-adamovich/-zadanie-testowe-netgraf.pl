<!DOCTYPE html>
<html lang="en">
<head>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif <h1>Watch Pet</h1>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $pet['id'] }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $pet['name']?? 'unnamed' }}</td>
        </tr>
        <tr>
            <th>Category</th>
            <td>{{ $pet['category']['name']?? 'unnamed' }}</td>
        </tr>
        <tr>
            <th>Photo URL</th>
            <td>{{ $pet['photoUrls'][0]?? 'null' }}</td>
        </tr>
        <tr>
            <th>Tag</th>
            <td>{{ $pet['tags'][0]['name'] ?? 'unnamed' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $pet['status'] ?? 'unnamed'}}</td>
        </tr>
    </table>
    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
    <form action="{{ route('pets.uploadImage', $pet['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="additionalMetadata">Additional Metadata</label>
            <input type="text" class="form-control" id="additionalMetadata" name="additionalMetadata">
        </div>
        <div class="form-group">
            <label for="file">Upload Image</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

</div>
</body>
</html>
