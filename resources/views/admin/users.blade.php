@extends('templates.admin.layouts.main')
@section('admin-section')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users</h1>
    <p class="mb-4">This Show all data user.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table data-table table-bordered table-hover" style="width: 100%;">
                <thead>

                    <tr>

                        <th>No</th>

                        <th>Name</th>

                        <th>Email</th>

                        <th>Role</th>

                        <th width="100px">Action</th>

                    </tr>

                </thead>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" data-backdrop="static" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    @csrf

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" placeholder="Enter Email" class="form-control"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Role:</label>
                        <div class="col-sm-12">
                            <select id="role" name="role" placeholder="Enter role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="pengelola">Pengelola</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Change Password</label>
                        <div class="col-sm-12">
                            <input autocomplete="off" type="password" id="password" name="password" placeholder="Enter New Password" class="form-control"></input>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary mt-2" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary mt-2" id="saveBtn" value="create"><i class="fa fa-save" id="sumbitIcon"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        console.log('asd');
        let table = $('.data-table').DataTable({
            responsive: true,
            buttons: ["excel", "pdf"],
            dom: 'Bfrtip',

            processing: true,

            serverSide: true,

            ajax: "{{ route('users.index') }}",

            columns: [

                {
                    data: 'id',
                    name: 'id',
                },

                {
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'role',
                    name: 'role'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ]

        });

        $('body').on('click', '.edit', function() {
            var user_id = $(this).data('id');
            $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(data) {
                $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit User");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#user_id').val(data.data.id);
                $('#name').val(data.data.name);
                $('#email').val(data.data.email);
                $('#role').val(data.data.role);
            })
        });

        $('#userForm').submit(async function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            const body = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                role: formData.get('role'),
            }
            const id = $('#user_id').val()
            $('#saveBtn').html('<i class="fas fa-circle-notch fa-spin"></i> Sending...');
            try {
                const {
                    data
                } = await axios.put(`<?= url('users') ?>/${id}`, body, {
                    headers: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>',
                    }
                })
                $('#saveBtn').html('<i class="fa fa-check"></i> Success');
                $('#userForm').trigger("reset");
                await Swal.fire({
                    toast: true,
                    position: "top-end",
                    timer: 1500,
                    title: data.message,
                    showConfirmButton: false,
                    icon: "success",
                }).then((data) => {
                    $('#ajaxModel').modal('hide');
                    table.draw();
                })

            } catch (error) {
                console.log(error);
                $('#saveBtn').html('<i class="fas fa-save"></i> Save');
                let errors = ''
                $.each(error.response.data.errors, function(key, value) {
                    errors += `<li>${value}</li>`
                });
                Swal.fire({
                    title: 'error',
                    showConfirmButton: true,
                    html: `<ul>
                        ${errors}
                    </ul>`,
                    showConfirmButton: false,
                    icon: "warning"
                })
            }

        });

    });
</script>
@endSection()