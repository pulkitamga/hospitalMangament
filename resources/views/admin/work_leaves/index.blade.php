@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Work Leaves</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#workLeaveModal">
                <i class="fa fa-plus-circle me-2"></i> Add Work Leave
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>Sno</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workLeaves as $leave)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $leave->user->name }}</td>
                            <td>{{ $leave->description }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                            <td>{{ ucfirst($leave->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editWorkLeave" data-id="{{ $leave->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteWorkLeave({{ $leave->id }})">
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

<!-- Add/Edit Work Leave Modal -->
<div id="workLeaveModal" class="modal fade" tabindex="-1" aria-labelledby="workLeaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Work Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div> <!-- Success/Error मैसेज यहाँ दिखेगा -->

                <form id="workLeaveForm">
                    @csrf
                    <input type="hidden" name="id" id="workLeaveId">
                    <div class="mb-3">
                        <label class="form-label">Employee Name</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Leave Type</label>
                        <input type="text" class="form-control" name="description" id="description">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="from_date" id="from_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="to_date" id="to_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Work Leave</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#workLeaveForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');

            submitButton.prop('disabled', true);

            let url = '{{ route("work-leaves.store") }}';
            let method = 'POST';

            if ($('#workLeaveId').val() !== '') {
                url = '{{ url("admin/work-leaves") }}/' + $('#workLeaveId').val();
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
                            $('#workLeaveModal').modal('hide');
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

        // Edit Work Leave
        $('.editWorkLeave').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/work-leaves") }}/' + id, function(response) {
                if (response.success) {
                    let leave = response.data;
                    $('#workLeaveId').val(leave.id);
                    $('#user_id').val(leave.user_id);
                    $('#description').val(leave.description);
                    $('#status').val(leave.status);
                    $('#from_date').val(leave.from_date);
                    $('#to_date').val(leave.to_date);
                    $('#messageBox').html('');
                    $('#workLeaveModal').modal('show');
                }
            });
        });
    });

    function deleteWorkLeave(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/work-leaves") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection
