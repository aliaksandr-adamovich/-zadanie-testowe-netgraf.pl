<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Pet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <h1>Add Pet</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id">Id</label>
            <input type="text" name="id" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category[id]" class="form-control" placeholder="ID Category" required>
            <input type="text" name="category[name]" class="form-control" placeholder="Name category" required>
        </div>
        <div class="form-group">
            <label for="photoUrls">Photo Url</label>
            <div id="photoUrls">
                <input type="text" name="photoUrls[]" class="form-control mb-2" required>
            </div>
            <button type="button" onclick="addPhotoUrl()">Add Photo URL</button>
        </div>
        <div class="form-group">
            <label for="tags">Tags</label>
            <div id="tags">
                <input type="text" name="tags[0][id]" class="form-control mb-2" placeholder="ID tag">
                <input type="text" name="tags[0][name]" class="form-control mb-2" placeholder="Name tag">
            </div>
            <button type="button" onclick="addTag()">Add Tag</button>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
</body>
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
</html>
