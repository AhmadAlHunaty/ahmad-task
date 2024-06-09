<form action="{{url('admin/subject')}}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Subject Name</label>
        <input required type="text" class="form-control" id="name" name="name">
    </div>

    <div class="mb-3">
        <label for="min-mark" class="form-label">Minimum Mark</label>
        <input required type="number" max="99" min="20" class="form-control" id="min-mark" name="min_mark">
    </div>

    <div class="mb-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">Create</button>
    </div>
</form>
