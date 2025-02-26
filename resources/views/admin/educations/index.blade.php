@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Education Information</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#educationModal">
                <i class="fa fa-plus-circle me-2"></i> Add Education
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>User</th>
                        <th>Institution</th>
                        <th>Field</th>
                        <th>Level</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($educations as $education)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $education->user->name ?? 'N/A' }}</td>
                            <td>{{ $education->institution }}</td>
                            <td>{{ $education->field }}</td>
                            <td>{{ $education->level }}</td>
                            <td>{{ $education->start_date }}</td>
                            <td>{{ $education->end_date }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editEducation" data-id="{{ $education->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteEducation({{ $education->id }})">
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

<!-- Add/Edit Education Modal -->
<div id="educationModal" class="modal fade" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
<<<<<<< HEAD
                <h5 class="modal-title">Add Education</h5>
=======
                <h5 class="modal-title">Education</h5>
>>>>>>> c310d12 (new data)
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="educationForm">
                    @csrf
                    <input type="hidden" name="id" id="educationId">
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="institution" id="institution" class="form-control mb-2" placeholder="Institution" required>
                    <input type="text" name="field" id="field" class="form-control mb-2" placeholder="Field" required>
                    <input type="text" name="level" id="level" class="form-control mb-2" placeholder="Level" required>
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-2" required>
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary">Save Education</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#educationForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("educations.store") }}';
            let method = 'POST';
            if ($('#educationId').val() !== '') {
                url = '{{ url("admin/educations") }}/' + $('#educationId').val();
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
                            $('#educationModal').modal('hide');
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

        $('.editEducation').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/educations") }}/' + id, function(response) {
                if (response.success) {
                    let education = response.data;
                    $('#educationId').val(education.id);
                    $('#user_id').val(education.user_id);
                    $('#institution').val(education.institution);
                    $('#field').val(education.field);
                    $('#level').val(education.level);
                    $('#start_date').val(education.start_date);
                    $('#end_date').val(education.end_date);
                    $('#messageBox').html('');
                    $('#educationModal').modal('show');
                }
            });
        });
    });

    function deleteEducation(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/educations") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection