@extends('layouts.app') @section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui.css') }}">

<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Best for </h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Best for </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Best for</button>
            </div>
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
                                    <table class="table nowrap w-100" id="tblBestFor">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Action</th>
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

<div class="modal fade" id="addEditBestForModal" tabindex="-1" role="dialog" aria-labelledby="addEditBestForModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditBestForModalTitle">Best for</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditBestForForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="best_for_id" name="best_for_id" class="form-control round">
                    </fieldset>


                    <fieldset class="form-group">
                        <label for="title">Best for</label>
                        <input type="text" id="title" name="title" class="form-control round" placeholder="Title">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control round">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditBestFor()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script type="text/javascript">
    let bestForTable = $('#tblBestFor').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/best_for') }}",
            "type": "GET",
            "data": {
                "_token": "{{ csrf_token() }}"
            }
        },
        "columns": [
            {
                "data": "DT_RowIndex",
                orderable: false,
                width: '5%'
            },

            {
                "data": "title",
                width: '15%'
            },
            {
                "render": function(meta, type, row) {
                    return (row.status === 1 ? 'Active' : 'Inactive');
                },
                width: '7%'
            },
            {
                "data": "action",
                orderable: false,
                width: '8%'
            }
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-id', data.id);
        }
    });

    let sorting_best_for = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblBestFor > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_best_for = [];
                    $(this).children().each(function(index) {
                        let best_for_id = $(this).data('id');
                        sorting_best_for.push({
                            best_for_id: best_for_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblBestFor > tbody" ).disableSelection();
        }, 2000);
    });

    function showAddEditModal(t, edit) {
        $('#addEditBestForModalTitle').text('Add Best for');
        $("#addEditBestForForm")[0].reset();
        $("#best_for_id").val('');
        if (edit === true) {
            $('#addEditBestForModalTitle').text('Edit Best for');
            let bestForData = bestForTable.row($(t).parents('tr')).data();
            $("#addEditBestForForm #best_for_id").val(bestForData.id);
            $("#addEditBestForForm #title").val(bestForData.title);
            $("#addEditBestForForm #status").val(bestForData.status);
        }
        $("#addEditBestForModal").modal('show');
    }

    function addEditBestFor() {
        $("#addEditBestForForm").find('.help-block').remove();
        $("#addEditBestForForm").removeClass("error");

        let formData = new FormData($("#addEditBestForForm")[0]);
        $.ajax({
            url: "{{ url('admin/best_for/save') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if (response.status === true) {
                    toastr.success(response.message, 'Success', {
                        "closeButton": true,
                        "progressBar": true,
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        "timeOut": 2000
                    });

                    bestForTable.ajax.reload();
                    $("#addEditBestForModal").modal('hide');
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
                        $("#addEditBestForForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditBestForForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function deleteBestFor(t) {
        let best_for_id = $(t).data('id');

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
                formData.append('best_for_id', best_for_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/best_for/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            bestForTable.ajax.reload();
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
                        // console.log(error);
                    }
                });
            }
        })
    }

    function updateSortOrders() {
        // sorting_best_for
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_best_for', JSON.stringify(sorting_best_for));

        $.ajax({
            url: "{{ url('admin/best_for/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    bestForTable.ajax.reload();
                    Swal.fire({
                        type: "success",
                        title: 'Success',
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
                // console.log(error);
            }
        });
    }
</script>
@endsection
