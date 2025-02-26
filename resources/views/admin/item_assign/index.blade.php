@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Item Assignments</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemAssignModal">
                <i class="fa fa-plus-circle me-2"></i> Assign Item
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
                    @foreach ($itemAssigns as $assign)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $assign->user->name ?? 'N/A' }}</td>
                            <td>{{ $assign->item->name }}</td>
                            <td>{{ $assign->quantity }}</td>
                            <td>{{ ucfirst($assign->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editAssign" data-id="{{ $assign->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteAssignment({{ $assign->id }})">
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

<!-- Add/Edit Item Assignment Modal -->
<div id="itemAssignModal" class="modal fade" tabindex="-1" aria-labelledby="itemAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                <form id="itemAssignForm">
                    @csrf
                    <input type="hidden" name="id" id="assignId">
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item</label>
                        <select name="item_id" id="item_id" class="form-control">
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="number" name="quantity" id="quantity" class="form-control mb-2" placeholder="Quantity" required>
                    <select name="status" id="status" class="form-control mb-2">
                        <option value="assigned">Assigned</option>
                        <option value="returned">Returned</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Save Assignment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#itemAssignForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $('#assignId').val() ? `/admin/item-assign/${$('#assignId').val()}` : '/admin/item-assign';
            let method = $('#assignId').val() ? 'PUT' : 'POST';
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    }
                }
            });
        });

        $('.editAssign').click(function() {
            let id = $(this).data('id');
            $.get(`/admin/item-assign/${id}`, function(response) {
                if (response.success) {
                    $('#assignId').val(response.data.id);
                    $('#user_id').val(response.data.user_id);
                    $('#item_id').val(response.data.item_id);
                    $('#quantity').val(response.data.quantity);
                    $('#status').val(response.data.status);
                    $('#itemAssignModal').modal('show');
                }
            });
        });
    });

    function deleteAssignment(id) {
        if (confirm('Are you sure?')) {
            $.post(`/admin/item-assign/${id}`, { _method: 'DELETE', _token: '{{ csrf_token() }}' }, function(response) {
                location.reload();
            });
        }
    }
</script>
@endsection