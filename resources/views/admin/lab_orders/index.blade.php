@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Lab Orders Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labOrderModal">
                <i class="fa fa-plus-circle me-2"></i> Add Lab Order
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Visit</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labOrders as $labOrder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $labOrder->visit->id ?? 'N/A' }}</td>
                            <td>{{ $labOrder->patient->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($labOrder->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editLabOrder" data-id="{{ $labOrder->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteLabOrder" data-id="{{ $labOrder->id }}">
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

<!-- Add/Edit Lab Order Modal -->
<div id="labOrderModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lab Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="labOrderForm">
                    @csrf
                    <input type="hidden" name="id" id="labOrderId">
                    
                    <div class="mb-3">
                        <label>Visit</label>
                        <select name="visit_id" id="visit_id" class="form-control">
                            @foreach($visits as $visit)
                                <option value="{{ $visit->id }}">{{ $visit->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Lab Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
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

        $('#labOrderForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("lab_orders.store") }}';
            let method = 'POST';

            if ($('#labOrderId').val() !== '') {
                url = '{{ url("admin/lab_orders") }}/' + $('#labOrderId').val();
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
                        $('#labOrderModal').modal('hide');
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

        $('.editLabOrder').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/lab_orders") }}/' + id, function(response) {
                if (response.success) {
                    let labOrder = response.data;
                    $('#labOrderId').val(labOrder.id);
                    $('#visit_id').val(labOrder.visit_id);
                    $('#patient_id').val(labOrder.patient_id);
                    $('#status').val(labOrder.status);
                    $('#labOrderModal').modal('show');
                } else {
                    showMessage('danger', 'Error fetching lab order.');
                }
            }).fail(function() {
                showMessage('danger', 'Server error while fetching lab order.');
            });
        });

        $('.deleteLabOrder').click(function() {
            let id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.post('{{ url("admin/lab_orders") }}/' + id, {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    if (response.success) {
                        showMessage('success', response.message);
                    } else {
                        showMessage('danger', 'Failed to delete lab order.');
                    }
                }).fail(function() {
                    showMessage('danger', 'Server error while deleting lab order.');
                });
            }
        });
    });

</script>
@endsection
