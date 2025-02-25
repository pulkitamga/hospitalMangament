@extends('admin.layouts.master')

@section('main_section')
    <h3>Role Management</h3>

    <!---Add Role Button--->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add Role</button>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Role Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="role-list">
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm rounded-pill edit-role" data-id="{{ $role->id }}"
                            data-name="{{ $role->name }}" data-bs-toggle="modal" data-bs-target="#editRoleModal"><i
                                class="fa fa-edit"></i></button>
                        <!-- Delete Role Button -->
                        <button class="btn rounded-pill btn-danger btn-sm delete-role" data-id="{{ $role->id }}">
                            <i class="fa fa-trash m-0"></i>
                        </button>
<<<<<<< HEAD
=======

>>>>>>> 772d19c (role commit)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!--Add Role Modal-->

    <div id="addRoleModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="addRoleForm">
                    @csrf
                    <div class="modal-body">
                        <label>Role Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary m-1">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <!--Edit Modal-->
    <div id="editRoleModal" class="modal fade" tabindex="-1" aria-labelledby="editRoleMOdalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="editRoleForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editRoleId">
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="editRoleName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
=======
>>>>>>> 772d19c (role commit)
    <script>
        //Add User Role
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("addRoleForm").addEventListener("submit", function(event) {
                event.preventDefault();

                let formData = new FormData(this);

                fetch("{{ route('role.store') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                            "Accept": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            toastr.error(Object.values(data.errors).flat().join("\n"));
                        } else {
                            toastr.success(data.message);

                            // Refresh role list (replace with index update logic if needed)
                            location.reload();
                        }

                        // Close modal after short delay
                        setTimeout(() => {
                            document.querySelector("#addRoleModal .btn-close").click();
                        }, 2000);

                        document.getElementById("addRoleForm").reset();
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        toastr.error("Something went wrong. Please try again!");
                    });
            });
        });

<<<<<<< HEAD

        //Edit Role
        document.addEventListener("DOMContentLoaded",function(){
         document.querySelectorAll('.edit-role').forEach(button =>{
            button.addEventListener("click",function(){
                let roleId=this.getAttribute("data-id");
                let roleName=this.getAttribute("data-name");
                document.getElementById("editRoleId").value=roleId;
                document.getElementById("editRoleName").value=roleName;
                new bootstrap.Modal(document.getElementById("editRoleModal")).show();
            });
         });

         document.getElementById("editRoleForm").addEventListener("submit",function(e){
            e.preventDefault();
            let roleId=document.getElementById("editRoleId").value;
            let roleName=document.getElementById("editRoleName").value;
            
            fetch(`/admin/role/${roleId}`,{
                method:"PUT",
                headers:{
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                     "Content-Type": "application/json"
                },
                body: JSON.stringify({ name: roleName })
            })
            .then(response =>response.json())
            .then(data =>{
                toastr.success(data.message);
                location.reload();
            })
            .catch(error => console.error("Error:", error));
         })

        });
        //Delete User Role

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-role").forEach(button => {
                button.addEventListener("click", function() {
                    let roleId = this.getAttribute("data-id");
                    let token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');
                    if (confirm("Are You sure you want to delete this role?")) {
                        fetch(`/admin/role/${roleId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": token,
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                toastr.success(data.message);
                                location.reload();
                            })
                            .catch(error => console.error("Error:", error));
                    }
                })
            })
        });
=======
        //Delete User Role

        document.addEventListener("DOMContentLoaded", function() {
    document.body.addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-role") || event.target.closest(".delete-role")) {
            let button = event.target.closest(".delete-role");
            let roleId = button.getAttribute("data-id");

            console.log("Role id", roleId);
            if (!confirm("Are you sure you want to delete this role?")) return;

            fetch(`/role/${roleId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    toastr.success(data.message);
                    button.closest("tr").remove(); // Remove row on success
                } else {
                    toastr.error("Error deleting role!");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });
});

>>>>>>> 772d19c (role commit)
    </script>
@endsection
