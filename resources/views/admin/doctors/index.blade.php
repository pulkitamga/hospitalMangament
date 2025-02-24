@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Doctors List</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#doctorModal">
                <i class="fa fa-plus-circle me-2"></i> Add Doctor
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Employee Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $doctor->employee->name ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editDoctor" data-id="{{ $doctor->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteDoctor({{ $doctor->id }})">
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

<!-- Add/Edit Doctor Modal -->
<div id="doctorModal" class="modal fade" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="doctorForm">
                    @csrf
                    <input type="hidden" name="id" id="doctorId">
                    <div class="mb-3">
                        <label class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Doctor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#doctorForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("doctors.store") }}';
            let method = 'POST';
            if ($('#doctorId').val() !== '') {
                url = '{{ url("admin/doctors") }}/' + $('#doctorId').val();
                method = 'PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');
                        form.trigger("reset");
                        setTimeout(function() {
                            $('#doctorModal').modal('hide');
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorMessage += '<li>' + value + '</li>';
                    });
                    errorMessage += '</ul></div>';
                    $('#messageBox').html(errorMessage);
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                }
            });
        });

        $('.editDoctor').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/doctors") }}/' + id, function(response) {
                if (response.success) {
                    let doctor = response.data;
                    $('#doctorId').val(doctor.id);
                    $('#employee_id').val(doctor.employee_id);
                    $('#messageBox').html('');
                    $('#doctorModal').modal('show');
                }
            });
        });
    });

    function deleteDoctor(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/doctors") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection
