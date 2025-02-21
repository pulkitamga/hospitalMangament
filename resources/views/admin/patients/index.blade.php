@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Patients List</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patientModal">
                <i class="fa fa-plus-circle me-2"></i> Add Patient
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ ucfirst($patient->gender) }}</td>
                            <td>{{ $patient->department->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($patient->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editPatient" data-id="{{ $patient->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deletePatient({{ $patient->id }})">
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

<!-- Add/Edit Patient Modal -->
<div id="patientModal" class="modal fade" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="patientForm">
                    @csrf
                    <input type="hidden" name="id" id="patientId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" id="department_id" class="form-control">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#patientForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');

            submitButton.prop('disabled', true);

            let url = '{{ route("patients.store") }}';
            let method = 'POST';

            if ($('#patientId').val() !== '') {
                url = '{{ url("admin/patients") }}/' + $('#patientId').val();
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
                            $('#patientModal').modal('hide');
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

        $('.editPatient').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/patients") }}/' + id, function(response) {
                if (response.success) {
                    let patient = response.data;
                    $('#patientId').val(patient.id);
                    $('#name').val(patient.name);
                    $('#gender').val(patient.gender);
                    $('#department_id').val(patient.department_id);
                    $('#status').val(patient.status);
                    $('#messageBox').html('');
                    $('#patientModal').modal('show');
                }
            });
        });
    });

    function deletePatient(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/patients") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection
