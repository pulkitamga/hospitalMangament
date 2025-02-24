@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Appointments Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">
                <i class="fa fa-plus-circle me-2"></i> Add Appointment
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Appointment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ ucfirst($appointment->status) }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editAppointment" data-id="{{ $appointment->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteAppointment" data-id="{{ $appointment->id }}">
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

<!-- Add/Edit Appointment Modal -->
<div id="appointmentModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                <form id="appointmentForm">
                    @csrf
                    <input type="hidden" name="id" id="appointmentId">
                    
                    <div class="mb-3">
                        <label class="form-label">Patient</label>
                        <select name="patient_id" id="patient_id" class="form-control">
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-control">
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Appointment Date</label>
                        <input type="datetime-local" name="appointment_date" id="appointment_date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#appointmentForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let appointmentId = $('#appointmentId').val();
            let url = '{{ route("appointments.store") }}';
            let method = 'POST';

            if (appointmentId) {
                url = '/admin/appointments/' + appointmentId;
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
                        $('#appointmentModal').modal('hide');
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

        $(document).on('click', '.editAppointment', function () {
            let id = $(this).data('id');

            $.ajax({
                url: '/admin/appointments/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        let appointment = response.data;
                        $('#appointmentId').val(appointment.id);
                        $('#patient_id').val(appointment.patient_id);
                        $('#doctor_id').val(appointment.doctor_id);
                        $('#appointment_date').val(appointment.appointment_date);
                        $('#status').val(appointment.status);
                        $('#messageBox').html('');
                        $('#appointmentModal').modal('show');
                    }
                },
                error: function () {
                    alert('Something went wrong! Please try again.');
                }
            });
        });

        $(document).on('click', '.deleteAppointment', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this appointment?')) {
                $.ajax({
                    url: '/admin/appointments/' + id,
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
