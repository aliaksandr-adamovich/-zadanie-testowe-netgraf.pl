<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit pet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <h1>Edit pet</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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

    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id">ID</label>
            <input type="text" name="id" class="form-control" value="{{ $pet['id'] }}" required>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $pet['name'] ?? 'unnamed' }}" required>
        </div>
        <div class="form-group">
            <label for="category[id]">Category ID</label>
            <input type="number" name="category[id]" class="form-control" value="{{ $pet['category']['id'] }}" required>
        </div>
        <div class="form-group">
            <label for="category[name]">Category Name</label>
            <input type="text" name="category[name]" class="form-control" value="{{ $pet['category']['name'] }}" required>
        </div>
        <div class="form-group">
            <label for="photoUrls">Photo URLs</label>
            <div id="photoUrls">
                @foreach ($pet['photoUrls'] as $index => $url)
                    <input type="text" name="photoUrls[]" class="form-control mb-2" value="{{ $url }}" required>
                @endforeach
            </div>
            <button type="button" onclick="addPhotoUrl()">Add Photo URL</button>
        </div>
        <div class="form-group">
            <label for="tags">Tags</label>
            <div id="tags">
                @foreach ($pet['tags'] as $index => $tag)
                    <div class="tag-group">
                        <input type="number" name="tags[{{ $index }}][id]" class="form-control mb-2" value="{{ $tag['id'] }}">
                        <input type="text" name="tags[{{ $index }}][name]" class="form-control mb-2" value="{{ $tag['name'] }}">
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="addTag()">Add Tag</button>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available" {{ $pet['status'] == 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ $pet['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ $pet['status'] == 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<script>
    function addPhotoUrl() {
        const photoUrlsDiv = document.getElementById('photoUrls');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'photoUrls[]';
        input.classList.add('form-control', 'mb-2');
        input.required = true;
        photoUrlsDiv.appendChild(input);
    }

    function addTag() {
        const tagsDiv = document.getElementById('tags');
        const tagGroupDiv = document.createElement('div');
        tagGroupDiv.classList.add('tag-group');
        const idInput = document.createElement('input');
        idInput.type = 'number';
        idInput.name = 'tags[' + tagsDiv.children.length + '][id]';
        idInput.classList.add('form-control', 'mb-2');
        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = 'tags[' + tagsDiv.children.length + '][name]';
        nameInput.classList.add('form-control', 'mb-2');
        tagGroupDiv.appendChild(idInput);
        tagGroupDiv.appendChild(nameInput);
        tagsDiv.appendChild(tagGroupDiv);
    }
</script>
</body>
</html>
