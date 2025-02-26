@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Medicine Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medicineModal">
                <i class="fa fa-plus-circle me-2"></i> Add Medicine
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Manufacturer</th>
                        <th>Expiry Date</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->id }}</td>
                            <td>{{ $medicine->name }}</td>
                            <td>{{ $medicine->quantity }}</td>
                            <td>{{ $medicine->price }}</td>
                            <td>{{ $medicine->manufacturer }}</td>
                            <td>{{ $medicine->expiry_date }}</td>
                            <td>{{ $medicine->category }}</td>
                            <td>{{ ucfirst($medicine->status) }}</td>
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

<!-- Add/Edit Medicine Modal -->
<div id="medicineModal" class="modal fade" tabindex="-1" aria-labelledby="medicineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medicine</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>

                <form id="medicineForm">
                    @csrf
                    <input type="hidden" name="id" id="medicineId">
                    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Manufacturer</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" id="category" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="available">Available</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Medicine</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Create & Update Medicine
        $('#medicineForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let medicineId = $('#medicineId').val();
            let url = '{{ route("medicines.store") }}';
            let method = 'POST';

            if (medicineId) {
                url = '/admin/medicines/' + medicineId;
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
                        $('#medicineModal').modal('hide');
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

        $(document).on('click', '.editMedicine', function () {
            let id = $(this).data('id');
            let url = "{{ route('medicines.edit', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        let medicine = response.data;
                        $('#medicineId').val(medicine.id);
                        $('#name').val(medicine.name);
                        $('#quantity').val(medicine.quantity);
                        $('#price').val(medicine.price);
                        $('#manufacturer').val(medicine.manufacturer);
                        $('#expiry_date').val(medicine.expiry_date);
                        $('#category').val(medicine.category);
                        $('#status').val(medicine.status);
                        $('#messageBox').html('');
                        $('#medicineModal').modal('show');
                    }
                },
                error: function (xhr) {
                    alert("Error fetching medicine data.");
                }
            });
        });


        $(document).on('click', '.deleteMedicine', function () {
            let id = $(this).data('id');
            let url = "{{ route('medicines.destroy', ':id') }}".replace(':id', id);

            if (confirm('Are you sure you want to delete this medicine?')) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload(); // ✅ अब डेटा सही से डिलीट होगा
                    },
                    error: function () {
                        alert("Error deleting medicine.");
                    }
                });
            }
        });

    });
</script>
@endsection
