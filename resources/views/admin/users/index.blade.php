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
<<<<<<< HEAD
                                <td>Admin</td>
                                <td>+917582060792</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="editUser({{ $user->id }})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
=======
                                <td>{{ $user->role->name ?? 'No Role Assigned' }}</td>
                                <td>+917582060792</td>
                                <td>
                                    <button class="btn btn-primary btn-sm rounded-pill edit-user"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-role="{{ $user->role_id }}"
                                        data-bs-toggle="modal" data-bs-target="#editUserModal"><i
                                            class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm delete-user" data-id={{ $user->id }}>
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
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
<<<<<<< HEAD
                            <input type="text" class="form-control" id="name" name="name" required>
=======
                            <input type="text" class="form-control" id="name" name="name">
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Email</label>
<<<<<<< HEAD
                            <input type="email" class="form-control" id="email" name="email" required>
=======
                            <input type="email" class="form-control" id="email" name="email">
                            <p class="text-danger"></p>
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
<<<<<<< HEAD
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">Generate</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i id="passwordToggleIcon" class="bi bi-eye-slash"></i>
                                </button>
                            </div>
=======
                                <input type="password" class="form-control" id="password" name="password">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="generatePassword()">Generate</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i id="passwordToggleIcon" class="fa fa-eye-slash"></i>
                                </button>

                            </div>
                            <p class="text-danger"></p>

>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="user_role" class="form-control">
<<<<<<< HEAD
                                <option value="2">User</option>
                                <option value="3">Journalist</option>
                                <option value="4">Blogger</option>
                                <option value="5">Social Media Influencer</option>
                                <option value="6">Local Writer</option>
                            </select>
=======
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger"></p>
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Dynamic Content) -->
<<<<<<< HEAD
    <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"></div>
=======
    <div id="editUserModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        @csrf
                        @method('Put')
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <input type="text" class="form-control" id="edit_user_name" name="name">
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Email</label>
                            <input type="email" class="form-control" id="edit_user_email" name="email" readonly>
                            <p class="text-danger"></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">User Role</label>
                            <select name="user_role" class="form-control" id="edit_user_role">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->role_id == $role->id ? 'Selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger"></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9

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
<<<<<<< HEAD
                toggleIcon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('bi-eye', 'bi-eye-slash');
=======
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
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
<<<<<<< HEAD
                            location.reload();
                        } else {
                            alert(response.error);
=======
                            toastr.success(response.message);
                            $('#userModal').modal('hide');

                            // Reload the page after a short delay
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.error, 'Error');
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseJSON);
<<<<<<< HEAD
                        alert('An error occurred!');
=======
                        if (xhr.status === 422) {
                            $('.text-danger').text('');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                console.log("Field:", key, "Error:", value[0])
                                let field = $("[name='" + key + "']");

                                if (field.is('select')) {
                                    field.closest('.mb-3').find('.text-danger').text(
                                        value[0]);
                                } else if (field.closest('.input-group').length) {
                                    field.closest('.input-group').parent().find(
                                            '.text-danger')
                                        .text(value[0]);
                                } else {
                                    field.next('.text-danger').text(value[0]);
                                }
                            });
                        } else {
                            toastr.error('An error occurred!', 'Error');
                        }
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
                    }
                });
            });
        });

<<<<<<< HEAD
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
=======
        //edit user
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".edit-user").forEach(button => {
                button.addEventListener("click", function() {
                    let userId = this.getAttribute('data-id');
                    let userName = this.getAttribute('data-name');
                    let userEmail = this.getAttribute('data-email');
                    let userRole = this.getAttribute('data-role');
                    document.getElementById("edit_user_id").value = userId;
                    document.getElementById("edit_user_name").value = userName;
                    document.getElementById("edit_user_email").value = userEmail;
                    document.getElementById("edit_user_role").value = userRole;
                    new bootstrap.Modal(document.getElementById("editRoleModal")).show();
                })


            })
            document.getElementById("editUserForm").addEventListener("submit", function(e) {
                e.preventDefault();
                let userId = document.getElementById("edit_user_id").value;
                let userName = document.getElementById("edit_user_name").value;
                let userRole = document.getElementById("edit_user_role").value;
                fetch(`/admin/users/${userId}`, {
                        method: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            name: userName,
                            role: userRole
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        toastr.success(data.message);
                        location.reload();
                    })
                    .catch(error => console.error("Error:", error));
            })
        })

        //Delete User


        document.addEventListener("DOMContentLoaded", function() {
            document.body.addEventListener("click", function(event) {
                if (event.target.classList.contains("delete-user") || event.target.closest(
                    ".delete-user")) {
                    let button = event.target.closest(".delete-user");
                    let userId = button.getAttribute("data-id");

                    console.log("User ID:", userId);
                    if (!confirm("Are you sure you want to delete this user?")) return;

                    fetch(`/admin/users/${userId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                                "Accept": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                toastr.success(data.message);
                                button.closest("tr").remove(); // Remove the table row
                            } else {
                                toastr.error("Error deleting user!"); // Fixed message
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            toastr.error("Something went wrong. Please try again.");
                        }); // Added missing semicolon
                }
            });
        });
>>>>>>> e0f085aecc617219fd989588f47e657c868410a9
    </script>
@endsection
