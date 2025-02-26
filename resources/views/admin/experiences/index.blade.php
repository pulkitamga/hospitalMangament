@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Work Experience</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#experienceModal">
                <i class="fa fa-plus-circle me-2"></i> Add Experience
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
                        <th>Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($experiences as $experience)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $experience->user->name ?? 'N/A' }}</td>
                            <td>{{ $experience->institution }}</td>
                            <td>{{ $experience->field }}</td>
                            <td>{{ $experience->start_date }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editExperience" data-id="{{ $experience->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteExperience({{ $experience->id }})">
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

<!-- Add/Edit Experience Modal -->
<div id="experienceModal" class="modal fade" tabindex="-1" aria-labelledby="experienceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Work Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="experienceForm">
                    @csrf
                    <input type="hidden" name="id" id="experienceId">
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
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary">Save Experience</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#experienceForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("experiences.store") }}';
            let method = 'POST';
            if ($('#experienceId').val() !== '') {
                url = '{{ url("admin/experiences") }}/' + $('#experienceId').val();
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
                            $('#experienceModal').modal('hide');
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

        $('.editExperience').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/experiences") }}/' + id, function(response) {
                if (response.success) {
                    let experience = response.data;
                    $('#experienceId').val(experience.id);
                    $('#user_id').val(experience.user_id);
                    $('#institution').val(experience.institution);
                    $('#field').val(experience.field);
                    $('#start_date').val(experience.start_date);
                    $('#messageBox').html('');
                    $('#experienceModal').modal('show');
                }
            });
        });
    });

    function deleteExperience(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/experiences") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection
