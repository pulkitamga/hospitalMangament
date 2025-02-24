@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Rooms Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roomModal">
                <i class="fa fa-plus-circle me-2"></i> Add Room
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $room->department->name }}</td>
                            <td>{{ ucfirst($room->status) }}</td>
                            <td>{{ ucfirst($room->type) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editRoom" data-id="{{ $room->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteRoom" data-id="{{ $room->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Room Modal -->
<div id="roomModal" class="modal fade" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="roomForm">
                    @csrf
                    <input type="hidden" name="id" id="roomId">
                    
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="occupied">Occupied</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="ward">Ward</option>
                            <option value="private">Private</option>
                            <option value="semi-private">Semi-Private</option>
                            <option value="general">General</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Room</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function () {
        // ✅ Create & Update Room
        $('#roomForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let roomId = $('#roomId').val();
            let url = '{{ route("rooms.store") }}';
            let method = 'POST';

            if (roomId) {
                url = '/admin/rooms/' + roomId; // ✅ सही URL
                method = 'PUT'; // ✅ सही Method
                formData += '&_method=PUT'; // ✅ Laravel Method Spoofing
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function (response) {
                    $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');
                    form.trigger("reset");
                    setTimeout(function () {
                        $('#roomModal').modal('hide');
                        location.reload();
                    }, 1000);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function (key, value) {
                        errorMessage += '<li>' + value + '</li>';
                    });
                    errorMessage += '</ul></div>';
                    $('#messageBox').html(errorMessage);
                },
                complete: function () {
                    submitButton.prop('disabled', false);
                }
            });
        });

        // ✅ Open Edit Modal & Load Data
        $(document).on('click', '.editRoom', function () {
            let id = $(this).data('id');

            $.get('/admin/rooms/' + id, function (response) { // ✅ सही URL
                if (response.success) {
                    let room = response.data;
                    $('#roomId').val(room.id);
                    $('#department_id').val(room.department_id);
                    $('#status').val(room.status);
                    $('#type').val(room.type);
                    $('#messageBox').html('');
                    $('#roomModal').modal('show');
                }
            }).fail(function () {
                alert('Something went wrong! Please try again.');
            });
        });

        // ✅ Delete Room (Fixed)
        $(document).on('click', '.deleteRoom', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this room?')) {
                $.ajax({
                    url: '/admin/rooms/' + id, // ✅ सही URL
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert('Failed to delete! Try again.');
                    }
                });
            }
        });
    });
</script>



@endsection
