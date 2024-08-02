<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
 @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div class="container">
    <h1>Pets</h1>
    <div class="mb-3">
         <form id="status-form" action="{{ route('pets.index') }}" method="GET">
        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                <option value="all" {{ $selectedStatus === 'all' ? 'selected' : '' }}>All</option>
                <option value="available" {{ $selectedStatus === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ $selectedStatus === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
    </form>
    </div>
    <a href="{{ route('pets.create') }}" class="btn btn-primary mb-3">Add pet</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pets as $pet)
            <tr>
                <td>{{ $pet['id'] }}</td>
                <td>{{ $pet['name'] ?? 'unnamed' }}</td>
                <td>{{ $pet['status'] }}</td>
                <td>
                    <a href="{{ route('pets.show', $pet['id']) }}" class="btn btn-info">Watch</a>
                    <a href="{{ route('pets.edit', $pet['id']) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
