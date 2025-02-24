@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Visits Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#visitModal">
                <i class="fa fa-plus-circle me-2"></i> Add Visit
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Symptoms</th>
                        <th>Diagnosis</th>
                        <th>Disease</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $visit->patient->name }}</td>
                            <td>{{ $visit->doctor->name }}</td>
                            <td>{{ $visit->symptoms }}</td>
                            <td>{{ $visit->diagnosis }}</td>
                            <td>{{ $visit->disease }}</td>
                            <td>{{ ucfirst($visit->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editVisit" data-id="{{ $visit->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteVisit({{ $visit->id }})">
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

<!-- Add/Edit Visit Modal -->
<div id="visitModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Visit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                <form id="visitForm">
                    @csrf
                    <input type="hidden" name="id" id="visitId">
                    <div class="mb-3">
                        <label>Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control">
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Symptoms</label>
                        <input type="text" name="symptoms" id="symptoms" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Diagnosis</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Disease</label>
                        <input type="text" name="disease" id="disease" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Visit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX -->
<script>
    $(document).ready(function() {
        $('#visitForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let url = '{{ route("visits.store") }}';
            let method = 'POST';
            if ($('#visitId').val() !== '') {
                url = '{{ url("admin/visits") }}/' + $('#visitId').val();
                method = 'PUT';
            }

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');
                        
                        // Modal बंद करें
                        setTimeout(function() {
                            $('#visitModal').modal('hide');
                            location.reload();
                        }, 1500); // 1.5 सेकंड में पेज रीलोड होगा
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

        $('.editVisit').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route("visits.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        let visit = response.data;
                        $('#visitId').val(visit.id);
                        $('#patient_id').val(visit.patient_id);
                        $('#doctor_id').val(visit.doctor_id);
                        $('#symptoms').val(visit.symptoms);
                        $('#diagnosis').val(visit.diagnosis);
                        $('#disease').val(visit.disease);
                        $('#status').val(visit.status);
                        $('#messageBox').html('');
                        $('#visitModal').modal('show');
                    }
                },
                error: function(xhr) {
                    alert("Error: " + xhr.statusText);
                }
            });
        });

    });

    function deleteVisit(id) {
        if (confirm('Are you sure?')) {
            $.ajax({
                url: '{{ url("admin/visits") }}/' + id,
                type: 'POST',
                data: { _method: 'DELETE', _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        $('#messageBox').html('<div class="alert alert-success">' + response.message + '</div>');

                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        }
    }
</script>


@endsection
