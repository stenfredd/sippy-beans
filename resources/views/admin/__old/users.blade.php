@extends('layouts.app') @section('content')
<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Users</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            {{-- <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li> --}}
                            <li class="breadcrumb-item">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            {{-- <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add User</button>
            </div> --}}
        </div>
    </div>
    <div class="content-body">
        <section id="horizontal-vertical">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table nowrap w-100" id="tblUsers">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="select_all" id="select_all"/></th>
                                                <th>USER NO.</th>
                                                <th>FIRST NAME</th>
                                                <th>LAST NAME</th>
                                                <th>EMAIL ADDRESS</th>
                                                <th>REWARD POINTS</th>
                                                <th>ORDERS</th>
                                                <th>REVENUE</th>
                                                <th>CREATED AT</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

{{-- <div class="modal fade" id="addEditUserModal" tabindex="-1" role="dialog" aria-labelledby="addEditUserModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditUserModalTitle">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditUserForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="user_id" name="user_id" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" id="profile_image" name="profile_image" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control round" placeholder="First Name">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control round" placeholder="Last Name">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control round" placeholder="Email">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control round" placeholder="Phone">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control round" placeholder="Password">
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditUser()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@endsection

@section('scripts')
{{-- <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> --}}


<script type="text/javascript">
    let usersTable = $('#tblUsers').DataTable({
        /*"dom": 'Bfrtip',
        "buttons": [
            // 'copy',
            // 'csv',
            'excel',
            // 'pdf',
            // 'print'
        ],*/
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/users') }}",
            "type": "GET",
            "data": {
                "_token": "{{ csrf_token() }}"
            }
        },
        "columns": [
            {
                "data": "DT_RowIndex",
                "render": function(data, meta, row) {
                    return "<input type='checkbox' name='user_actions[]' id='user_actions_"+row.id+"'/>"
                },
                orderable: false,
                width: '5%'
            },
            {
                "data": "id",
                orderable: false,
                width: '5%'
            },
            {
                "data": "first_name",
                orderable: false,
                width: '20%'
            },
            {
                "data": "last_name",
                orderable: false,
                width: '20%'
            },
            {
                "data": "email",
                width: '20%'
            },
            {
                "data": "reward_points",
                width: '20%'
            },
            {
                "data": "orders_count",
                width: '20%'
            },
            {
                "data": "revenue",
                width: '20%'
            },
            {
                "data": "created_at",
                width: '20%'
            },
            {
                "data": "action",
                orderable: false,
                width: '10%'
            }
        ]
    });

    /* function showAddEditModal(t, edit) {
        $("#addEditUserForm")[0].reset();
        $("#user_id").val('');
        $("#addEditUserForm #password").parents(".form-group").show();
        if (edit === true) {
            let userData = ussersTable.row($(t).parents('tr')).data();
            $("#addEditUserForm #user_id").val(userData.id);
            $("#addEditUserForm #first_name").val(userData.first_name);
            $("#addEditUserForm #last_name").val(userData.last_name);
            $("#addEditUserForm #email").val(userData.email);
            $("#addEditUserForm #phone").val(userData.phone);
            $("#addEditUserForm #password").parents(".form-group").hide();
        }
        $("#addEditUserModal").modal('show');
    } */

    /* function addEditUser() {
        $("#addEditUserForm").find('.help-block').remove();
        $("#addEditUserForm").removeClass("error");

        let formData = new FormData($("#addEditUserForm")[0]);
        $.ajax({
            url: "{{ url('admin/users/save') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    toastr.success(response.message, 'Success', {
                        "closeButton": true,
                        "progressBar": true,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 2000
                    });
                    usersTable.ajax.reload();
                    $("#addEditUserModal").modal('hide');
                }
                else {
                    toastr.error(response.message, 'Error', {
                        "closeButton": true,
                        "progressBar": true,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 2000
                    });
                }
            },
            error: function(error) {
                if (error.status === 422) {
                    $.each(error.responseJSON.errors, function(field, errorMsg) {
                        $("#addEditUserForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditUserForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    } */

    /* function deleteUser(t) {
        let user_id = $(t).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        })
        .then(function(result) {
            if (result.value) {
                let formData = new FormData();
                formData.append('user_id', user_id);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ url('admin/users/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            usersTable.ajax.reload();
                            Swal.fire({
                                type: "success",
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonClass: 'btn btn-success',
                            })
                        }
                        else {
                            toastr.error(response.message, 'Error', {
                                "closeButton": true,
                                "progressBar": true,
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                "timeOut": 2000
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        })
    } */
</script>
@endsection
