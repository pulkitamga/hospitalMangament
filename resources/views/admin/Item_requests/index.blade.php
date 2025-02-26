@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Item Requests</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemRequestModal">
                <i class="fa fa-plus-circle me-2"></i> Add Request
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>User</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->user->name ?? 'N/A' }}</td>
                            <td>{{ $request->item->name ?? 'N/A' }}</td>
                            <td>{{ $request->quantity }}</td>
                            <td>{{ ucfirst($request->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editRequest" data-id="{{ $request->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteRequest({{ $request->id }})">
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

<!-- Add/Edit Item Request Modal -->
<div id="itemRequestModal" class="modal fade" tabindex="-1" aria-labelledby="itemRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                
                <form id="itemRequestForm">
                    @csrf
                    <input type="hidden" name="id" id="requestId">
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item</label>
                        <select name="item_id" id="item_id" class="form-control">
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="number" name="quantity" id="quantity" class="form-control mb-2" placeholder="Quantity" required>
                    <label class="form-label">Status</label>
                    <select name="status" id="status" class="form-control mb-2">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Save Request</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#itemRequestForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("item_requests.store") }}';
            let method = 'POST';
            if ($('#requestId').val() !== '') {
                url = '{{ url("admin/item-requests") }}/' + $('#requestId').val();
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
                            $('#itemRequestModal').modal('hide');
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

        $('.editRequest').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/item-requests") }}/' + id, function(response) {
                if (response.success) {
                    let request = response.data;
                    $('#requestId').val(request.id);
                    $('#user_id').val(request.user_id);
                    $('#item_id').val(request.item_id);
                    $('#quantity').val(request.quantity);
                    $('#status').val(request.status);
                    $('#messageBox').html('');
                    $('#itemRequestModal').modal('show');
                }
            });
        });
    });

    function deleteRequest(id) {
        if (confirm('Are you sure?')) {
            $.post('{{ url("admin/item-requests") }}/' + id, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection
