@extends('templates.admin.layouts.main')
@section('admin-section')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">News</h1>
    <p class="mb-4">This Show all news data.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary float-right" id="addNewsButton"><i class="fas fa-plus"></i> Add News</button>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table data-table table-bordered table-hover" style="width: 100%;">
                <thead>

                    <tr>

                        <th>No</th>
                        <th>title</th>
                        <th>seo title</th>
                        <th>by</th>
                        <th>content</th>
                        <th>hits</th>
                        <th>status</th>
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
                <form id="postEditForm" name="postEditForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    @csrf

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="editTitle" name="editTitle" placeholder="Enter Title" value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">SEO Title:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="editSeoTitle" editSeoTitle="name" placeholder="Enter Seo Title" value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content:</label>
                        <div class="col-sm-12">
                            <textarea id="editContent" name="editContent" placeholder="Content here" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="editStatus" id="editStatus" value="true">
                        <label class="form-check-label" for="exampleRadios1">
                            Publish
                        </label>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 mt-5">
                        <button type="button" class="btn btn-secondary mt-2" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary mt-2" id="saveBtn" value="create"><i class="fa fa-save" id="sumbitIcon"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" data-backdrop="static" id="addNews" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="newsHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="postsAddForm" name="postsAddForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    @csrf

                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6 control-label">Seo title:</label>
                        <div class="col-sm-12">
                            <input type="text" id="seotitle" name="seotitle" placeholder="Enter Seo Title" class="form-control"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Category:</label>
                        <div class="col-sm-12">
                            <select id="category_id" name="category_id" placeholder="Enter role" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Pengelola</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Content:</label>
                        <div class="col-sm-12">
                            <textarea id="content" name="content" placeholder="Content here" class="form-control" rows="4" cols="50"></textarea>
                        </div>
                    </div>

                    <div class="custom-file form-group ml-2">
                        <input type="file" class="custom-file-input form-control col-sm-12" id="customFile" name="images">
                        <label class="custom-file-label" for="customFile">Upload Image</label>
                    </div>

                    <div class="form-check ml-2">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="true">
                        <label class="form-check-label" for="exampleRadios1">
                            Publish
                        </label>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10 mt-2">
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

            ajax: "{{ route('posts.index') }}",

            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'id',
                },

                {
                    data: 'title',
                    name: 'title'
                },

                {
                    data: 'seotitle',
                    name: 'seotitle'
                },

                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'hits',
                    name: 'hits'
                },
                {
                    data: 'styledStatus',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },

            ]

        });

        $('body').on('click', '.edit', async function() {
            var user_id = $(this).data('id');

            await axios.get(`<?= url('posts') ?>/${user_id}/edit`).then(({
                data
            }) => {
                $('#modelHeading').html("<i class='fa-regular fa-pen-to-square'></i> Edit User");
                $('#saveBtn').val("edit-user");
                $('#ajaxModel').modal('show');
                $('#editTitle').val(data.data.title);
                $('#editSeoTitle').val(data.data.seotitle);
                $('#editContent').html(data.data.content);
                if (data.data.status === 'publish') {
                    $('#editStatus').prop('checked', 'true');
                }
            })
        });
        $('body').on('click', '#addNewsButton', function() {

            $('#newsHeading').html("<i class='fas fa-plus'></i> Add New Post");
            $('#saveBtn').val("edit-user");
            $('#addNews').modal('show');


        });

        $('#postsAddForm').submit(async function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('status', $('#status').val())
            $('#saveBtn').html('<i class="fas fa-circle-notch fa-spin"></i> Sending...');
            try {
                const {
                    data
                } = await axios.post('<?= url('posts') ?>', formData, {
                    header: {
                        'X-CSRF-TOKEN': '<?= csrf_token() ?>',
                        'content-type': 'multipart/form-data'
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
                    $('#addNews').modal('hide');
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