@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Items List</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#itemModal">
                <i class="fa fa-plus-circle me-2"></i> Add Item
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manufacturer</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Receipt No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->manufacturer }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->receipt_no }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editItem" data-id="{{ $item->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteItem({{ $item->id }})">
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

<!-- Add/Edit Item Modal -->
<div id="itemModal" class="modal fade" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="itemForm">
                    @csrf
                    <input type="hidden" name="id" id="itemId">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Manufacturer</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" id="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Receipt No</label>
                        <input type="text" name="receipt_no" id="receipt_no" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#itemForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("items.store") }}';
            let method = 'POST';

            if ($('#itemId').val() !== '') {
                url = '{{ route("items.update", "") }}/' + $('#itemId').val();
                formData += '&_method=PUT';
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');
                        form.trigger("reset");
                        setTimeout(function() {
                            $('#itemModal').modal('hide');
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

        $('.editItem').click(function() {
            let id = $(this).data('id');
            $.get('{{ route("items.show", "") }}/' + id, function(response) {
                if (response.success) {
                    let item = response.data;
                    $('#itemId').val(item.id);
                    $('#name').val(item.name);
                    $('#manufacturer').val(item.manufacturer);
                    $('#quantity').val(item.quantity);
                    $('#price').val(item.price);
                    $('#receipt_no').val(item.receipt_no);
                    $('#messageBox').html('');
                    $('#itemModal').modal('show');
                }
            });
        });
    });

    function deleteItem(id) {
        if (confirm('Are you sure?')) {
            $.ajax({
                url: '{{ route("items.destroy", "") }}/' + id,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    }
                }
            });
        }
    }
</script>

@endsection
