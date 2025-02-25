@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Bills Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#billModal">
                <i class="fa fa-plus-circle me-2"></i> Add Bill
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bills as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->patient->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($bill->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editBill" data-id="{{ $bill->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteBill" data-id="{{ $bill->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $bills->links() }}
        </div>
    </div>
</div>

<!-- Add/Edit Bill Modal -->
<div id="billModal" class="modal fade" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="billForm">
                    @csrf
                    <input type="hidden" name="id" id="billId">
                    
                    <div class="mb-3">
                        <label class="form-label">Patient</label>
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
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Bill</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function () {
        $('#billForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let billId = $('#billId').val();
            let url = '{{ route("bills.store") }}';
            let method = 'POST';

            if (billId) {
                url = '/admin/bills/' + billId;
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
                        $('#billModal').modal('hide');
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

        // Edit Bill
        $('.editBill').click(function () {
            let id = $(this).data('id');
            $.ajax({
                url: '/admin/bills/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        let bill = response.data;
                        $('#billId').val(bill.id);
                        $('#patient_id').val(bill.patient_id);
                        $('#status').val(bill.status);
                        $('#messageBox').html('');
                        $('#billModal').modal('show');
                    }
                },
                error: function () {
                    alert('Something went wrong! Please try again.');
                }
            });
        });

        // Delete Bill
        $('.deleteBill').click(function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this bill?')) {
                $.ajax({
                    url: '/admin/bills/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
