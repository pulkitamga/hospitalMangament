@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Medicines Name List</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medicineNameModal">
                <i class="fa fa-plus-circle me-2"></i> Add Medicine Name
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Medicine Name</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines as $medicine)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->total }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editMedicine" data-id="{{ $medicine->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteMedicine" data-id="{{ $medicine->id }}">
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

<!-- Add/Edit Medicine Name Modal -->
<div id="medicineNameModal" class="modal fade" tabindex="-1" aria-labelledby="medicineNameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medicine Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="medicineNameForm">
                    @csrf
                    <input type="hidden" name="id" id="medicineNameId">
                    <div class="mb-3">
                        <label class="form-label">Medicine Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <input type="text" name="total" id="total" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Medicine</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#medicineNameForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("medicines_name.store") }}';
            let method = 'POST';
            if ($('#medicineNameId').val() !== '') {
                url = '{{ url("admin/medicines_name") }}/' + $('#medicineNameId').val();
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
                            $('#medicineNameModal').modal('hide');
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

        $('.editMedicine').click(function() {
            let id = $(this).data('id');
            $.get('{{ url("admin/medicines_name") }}/' + id, function(response) {
                if (response.success) {
                    let medicine = response.data;
                    $('#medicineNameId').val(medicine.id);
                    $('#name').val(medicine.name);
                    $('#total').val(medicine.total);
                    $('#messageBox').html('');
                    $('#medicineNameModal').modal('show');
                }
            });
        });

        $('.deleteMedicine').click(function() {
            let id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: '{{ url("admin/medicines_name") }}/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error processing request.');
                    }
                });
            }
        });
    });
</script>
@endsection
