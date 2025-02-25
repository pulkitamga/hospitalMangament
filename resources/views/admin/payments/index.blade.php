@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Payments Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                <i class="fa fa-plus-circle me-2"></i> Add Payment
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Bill ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Mode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->patient->name ?? 'N/A' }}</td>
                            <td>{{ $payment->bill_id }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ ucfirst($payment->status) }}</td>
                            <td>{{ ucfirst($payment->mode) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editPayment" data-id="{{ $payment->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deletePayment" data-id="{{ $payment->id }}">
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

<!-- Add/Edit Payment Modal -->
<div id="paymentModal" class="modal fade" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="paymentForm">
                    @csrf
                    <input type="hidden" name="id" id="paymentId">
                    
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
                        <label class="form-label">Bill</label>
                        <select name="bill_id" id="bill_id" class="form-control">
                            <option value="">Select Bill</option>
                            @foreach($bills as $bill)
                                <option value="{{ $bill->id }}">{{ $bill->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mode</label>
                        <select name="mode" id="mode" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="cheque">Cheque</option>
                            <option value="online">Online</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Save or Update Payment
        $('#paymentForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let paymentId = $('#paymentId').val();
            let url = '{{ route("payments.store") }}';
            let method = 'POST';

            if (paymentId) {
                url = '{{ route("payments.update", ":id") }}'.replace(":id", paymentId);
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
                        $('#paymentModal').modal('hide');
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

        // Open Edit Modal & Fill Data
        $('.editPayment').on('click', function () {
            let id = $(this).data('id');
            $.get('/admin/payments/' + id, function (response) {
                if (response.success) {
                    let payment = response.data;
                    $('#paymentId').val(payment.id);
                    $('#patient_id').val(payment.patient_id);
                    $('#bill_id').val(payment.bill_id);
                    $('#amount').val(payment.amount);
                    $('#status').val(payment.status);
                    $('#mode').val(payment.mode);
                    $('#paymentModal').modal('show');
                }
            });
        });

        // Delete Payment
        $('.deletePayment').on('click', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this payment?')) {
                $.ajax({
                    url: '/admin/payments/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert('Something went wrong! Try again.');
                    }
                });
            }
        });

    });
</script>

@endsection
