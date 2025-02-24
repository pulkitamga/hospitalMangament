@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Lab Tests Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labTestModal">
                <i class="fa fa-plus-circle me-2"></i> Add Lab Test
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labTests as $test)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->description ?? 'N/A' }}</td>
                            <td>{{ ucfirst($test->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editLabTest" data-id="{{ $test->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteLabTest" data-id="{{ $test->id }}">
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

<!-- Add/Edit Lab Test Modal -->
<div id="labTestModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lab Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="labTestForm">
                    @csrf
                    <input type="hidden" name="id" id="labTestId">
                    
                    <div class="mb-3">
                        <label>Test Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Lab Test</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function showMessage(type, message) {
            let alertBox = `<div class="alert alert-${type}">${message}</div>`;
            $(".modal-body").prepend(alertBox);
            setTimeout(() => {
                $(".alert").fadeOut();
                if (type === 'success') location.reload();
            }, 1500);
        }

        $('#labTestForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("lab_tests.store") }}';
            let method = 'POST';

            if ($('#labTestId').val() !== '') {
                url = '{{ url("admin/lab_tests") }}/' + $('#labTestId').val();
                method = 'PUT';
                formData += '&_method=PUT';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showMessage('success', response.message);
                        form.trigger("reset");
                        $('#labTestModal').modal('hide');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = 'Error:<br>';
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });
                    showMessage('danger', errorMessage);
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                }
            });
        });

        $('.editLabTest').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/lab_tests") }}/' + id, function(response) {
                if (response.success) {
                    let labTest = response.data;
                    $('#labTestId').val(labTest.id);
                    $('#name').val(labTest.name);
                    $('#description').val(labTest.description);
                    $('#status').val(labTest.status);
                    $('#labTestModal').modal('show');
                } else {
                    showMessage('danger', 'Error fetching lab test.');
                }
            }).fail(function() {
                showMessage('danger', 'Server error while fetching lab test.');
            });
        });

        $('.deleteLabTest').click(function() {
            let id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.post('{{ url("admin/lab_tests") }}/' + id, {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    if (response.success) {
                        showMessage('success', response.message);
                    } else {
                        showMessage('danger', 'Failed to delete lab test.');
                    }
                }).fail(function() {
                    showMessage('danger', 'Server error while deleting lab test.');
                });
            }
        });
    });
</script>
@endsection
