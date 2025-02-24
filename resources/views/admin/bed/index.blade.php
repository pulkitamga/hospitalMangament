@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Bed Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bedModal">
                <i class="fa fa-plus-circle me-2"></i> Add Bed
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Room</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Alloted Time</th>
                        <th>Discharge Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beds as $bed)
                        <tr>
                            <td>{{ $bed->id }}</td>
                            <td>{{ $bed->room->id }}</td>
                            <td>{{ $bed->patient->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($bed->status) }}</td>
                            <td>{{ $bed->alloted_time ?? '-' }}</td>
                            <td>{{ $bed->discharge_time ?? '-' }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editBed" data-id="{{ $bed->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteBed" data-id="{{ $bed->id }}">
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

<!-- Add/Edit Bed Modal -->
<div id="bedModal" class="modal fade" tabindex="-1" aria-labelledby="bedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bed</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="bedForm">
                    @csrf
                    <input type="hidden" name="id" id="bedId">
                    
                    <div class="mb-3">
                        <label class="form-label">Room</label>
                        <select name="room_id" id="room_id" class="form-control">
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Patient (Optional)</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            <option value="">Select Patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="allotted">Allotted</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alloted Time</label>
                        <input type="datetime-local" name="alloted_time" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Discharge Time</label>
                        <input type="datetime-local" name="discharge_time" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Bed</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function () {
        // Create & Update Bed
        $('#bedForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let bedId = $('#bedId').val();
            let url = '{{ route("beds.store") }}';
            let method = 'POST';

            if (bedId) {
                url = '/admin/beds/' + bedId;
                method = 'PUT';
                formData += '&_method=PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function (response) {
                    $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');
                    form.trigger("reset");
                    setTimeout(function () {
                        $('#bedModal').modal('hide');
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

        $(document).on('click', '.editBed', function () {
            let id = $(this).data('id');

            $.ajax({
                url: '/admin/beds/' + id + '/edit',  // ✅ सही URL लगाएं
                type: 'GET', // ✅ सही HTTP Method इस्तेमाल करें
                success: function (response) {
                    if (response.success) {
                        let bed = response.data;
                        $('#bedId').val(bed.id);
                        $('#room_id').val(bed.room_id);
                        $('#patient_id').val(bed.patient_id);
                        $('#status').val(bed.status);
                        $('#messageBox').html('');
                        $('#bedModal').modal('show');  // ✅ Modal Open करें
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong! Please try again.');
                }
            });
        });

        // Delete Bed
        $(document).on('click', '.deleteBed', function () {
            let id = $(this).data('id');

            if (confirm('Are you sure you want to delete this bed?')) {
                $.ajax({
                    url: '/admin/beds/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Failed to delete! Try again.');
                    }
                });
            }
        });

    });
</script>
@endsection
