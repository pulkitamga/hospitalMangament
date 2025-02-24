@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Lab Results Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labResultModal">
                <i class="fa fa-plus-circle me-2"></i> Add Lab Result
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Test</th>
                        <th>Result</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($labResults as $result)
                    <tr>
                        <td>{{ $result->id }}</td>
                        <td>{{ $result->order ? $result->order->id : 'N/A' }}</td>
                        <td>{{ $result->test ? $result->test->name : 'N/A' }}</td>
                        <td>{{ $result->result }}</td>
                        <td>{{ ucfirst($result->status) }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm editLabResult" data-id="{{ $result->id }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteLabResult" data-id="{{ $result->id }}">
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

<!-- Add/Edit Lab Result Modal -->
<div id="labResultModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lab Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                <form id="labResultForm">
                    @csrf
                    <input type="hidden" name="id" id="labResultId">
                    
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <select name="order_id" id="order_id" class="form-control">
                            @foreach($labOrders as $order)
                                <option value="{{ $order->id }}">{{ $order->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Test</label>
                        <select name="test_id" id="test_id" class="form-control">
                            @foreach($labTests as $test)
                                <option value="{{ $test->id }}">{{ $test->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Result</label>
                        <input type="text" name="result" id="result" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Lab Result</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#labResultForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let labResultId = $('#labResultId').val();
            let url = '{{ route("lab_results.store") }}';
            let method = 'POST';

            if (labResultId) {
                url = '/admin/lab_results/' + labResultId;
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
                        $('#labResultModal').modal('hide');
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

        $(document).on('click', '.editLabResult', function () {
            let id = $(this).data('id');

            $.ajax({
                url: '/admin/lab_results/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        let result = response.data;
                        $('#labResultId').val(result.id);
                        $('#order_id').val(result.order_id);
                        $('#test_id').val(result.test_id);
                        $('#result').val(result.result);
                        $('#status').val(result.status);
                        $('#labResultModal').modal('show');
                    } else {
                        alert('Error fetching data');
                    }
                },
                error: function () {
                    alert('Something went wrong! Please try again.');
                }
            });
        });


        $(document).on('click', '.deleteLabResult', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this lab result?')) {
                $.ajax({
                    url: '/admin/lab_results/' + id,
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
