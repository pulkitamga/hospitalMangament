@extends('admin.layouts.master')

@section('main_section')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-3">Users</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                    <i class="fa fa-plus-circle me-2"></i> Add User
                </button>
            </div>

            <div class="table-responsive text-nowrap card-body">
                <table class="table table-hover" id="Datatable">
                    <thead>
                        <tr class="bg-light">
                            <th>Sno</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                <td>Admin</td>
                                <td>+917582060792</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
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

    <!-- Add User Modal -->
    <div id="userModal" class="modal fade" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">Generate</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i id="passwordToggleIcon" class="bi bi-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="user_role" class="form-control">
                                <option value="2">User</option>
                                <option value="3">Journalist</option>
                                <option value="4">Blogger</option>
                                <option value="5">Social Media Influencer</option>
                                <option value="6">Local Writer</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Dynamic Content) -->
    <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"></div>

    <script>
        function generatePassword() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('password').value = password;
        }

        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }

        $(document).ready(function() {
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('users.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON);
                        alert('An error occurred!');
                    }
                });
            });
        });

        function editUser(id) {
    $.ajax({
        url: "{{ url('admin/users') }}/" + id + "/edit",
        type: "GET",
        success: function(response) {
            $('#editModal').html(response).modal('show');
        }
    });
}


        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '{{ route('users.destroy', '') }}/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        }
    </script>
@endsection
