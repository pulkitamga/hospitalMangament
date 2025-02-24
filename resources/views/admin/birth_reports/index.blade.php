@extends('admin.layouts.master')

@section('main_section')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-3">Birth Reports Management</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#birthReportModal">
                <i class="fa fa-plus-circle me-2"></i> Add Birth Report
            </button>
        </div>

        <div class="table-responsive text-nowrap card-body">
            <table class="table table-hover" id="Datatable">
                <thead>
                    <tr class="bg-light">
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Gender</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($birthReports as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->patient->name ?? 'N/A' }}</td>
                            <td>{{ $report->doctor->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst($report->gender) }}</td>
                            <td>{{ $report->description }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm editBirthReport" data-id="{{ $report->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteBirthReport" data-id="{{ $report->id }}">
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

<!-- Add/Edit Birth Report Modal -->
<div id="birthReportModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Birth Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageBox"></div>
                <form id="birthReportForm">
                    @csrf
                    <input type="hidden" name="id" id="birthReportId">
                    
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
                        <label class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Birth Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#birthReportForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();
            let submitButton = $('button[type="submit"]');
            submitButton.prop('disabled', true);

            let birthReportId = $('#birthReportId').val();
            let url = '{{ route("birth_reports.store") }}';
            let method = 'POST';

            if (birthReportId) {
                url = '{{ route("birth_reports.update", ":id") }}'.replace(':id', birthReportId);
                method = 'POST';
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
                        $('#birthReportModal').modal('hide');
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

        $(document).on('click', '.editBirthReport', function () {
            let id = $(this).data('id');

            $.ajax({
                url: '{{ route("birth_reports.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        let report = response.data;
                        $('#birthReportId').val(report.id);
                        $('#patient_id').val(report.patient_id);
                        $('#doctor_id').val(report.doctor_id);
                        $('#gender').val(report.gender);
                        $('#description').val(report.description);
                        $('#messageBox').html('');
                        $('#birthReportModal').modal('show');
                    }
                },
                error: function () {
                    alert('Something went wrong! Please try again.');
                }
            });
        });

        $(document).on('click', '.deleteBirthReport', function () {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this birth report?')) {
                $.ajax({
                    url: '{{ route("birth_reports.destroy", ":id") }}'.replace(':id', id),
                    type: 'POST',
                    data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
