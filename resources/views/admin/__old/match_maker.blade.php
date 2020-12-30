@extends('layouts.app') @section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui.css') }}">

<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Match Makers</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Match Makers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Match maker</button>
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
                                    <table class="table nowrap w-100" id="tblMatchMakers">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Questions</th>
                                                <th>Type</th>
                                                <th>Minimum select</th>
                                                <th>Miximum select</th>
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

<div class="modal fade" id="addEditMatchMakerModal" tabindex="-1" role="dialog" aria-labelledby="addEditMatchMakerModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditMatchMakerModalTitle">Add Match maker</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditMatchMakerForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="match_maker_id" name="match_maker_id" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group"> 
                        <label for="question">Question</label>
                        <input type="text" id="question" name="question" class="form-control round" placeholder="Question">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" class="form-control round">
                            <option value="">--- Select Type ---</option>
                            <option value="brand">Brand</option>
                            <option value="characteristic">Characteristic</option>
                            <option value="coffee_flavor">Coffee flavor</option>
                            <option value="grind">Grind</option>
                            <option value="level">Level</option>
                            <option value="origin">Origin</option>
                            <option value="process">Process</option>
                            <option value="seller">Seller</option>
                            <option value="type1">Type</option>
                        </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="min_select">Minimum select</label>
                        <input type="number" id="min_select" name="min_select" class="form-control round" placeholder="Minimum select">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="max_select">Maximum select</label>
                        <input type="number" id="max_select" name="max_select" class="form-control round" placeholder="Maximum select">
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
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditMatchMaker()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script type="text/javascript">
    let matchmakersTable = $('#tblMatchMakers').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/match_maker') }}",
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
                "data": "question",
                orderable: false,
                width: '25%'
            },
            {
                "data": "type",
                width: '15%'
            },
            {
                "data": "min_select",
                width: '40%'
            },
            {
                "data": "max_select",
                width: '40%'
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

    let sorting_match_makers = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblMatchMakers > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_match_makers = [];
                    $(this).children().each(function(index) {
                        let match_maker_id = $(this).data('id');
                        sorting_match_makers.push({
                            match_maker_id: match_maker_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblMatchMakers > tbody" ).disableSelection();
        }, 2000);
    });

    function showAddEditModal(t, edit) {
        $('#addEditMatchMakerModalTitle').text('Add Match maker')
        $("#addEditMatchMakerForm")[0].reset();
        $("#match_maker_id").val('');
        if (edit === true) {
            $('#addEditMatchMakerModalTitle').text('Edit Match maker')
            let matchmakerData = matchmakersTable.row($(t).parents('tr')).data();
            $("#addEditMatchMakerForm #match_maker_id").val(matchmakerData.id);
            $("#addEditMatchMakerForm #question").val(matchmakerData.question);
            $("#addEditMatchMakerForm #type").val(matchmakerData.type);
            $("#addEditMatchMakerForm #min_select").val(matchmakerData.min_select);
            $("#addEditMatchMakerForm #max_select").val(matchmakerData.max_select);
            $("#addEditMatchMakerForm #status").val(matchmakerData.status);
        }
        $("#addEditMatchMakerModal").modal('show');
    }

    function addEditMatchMaker() {
        $("#addEditMatchMakerForm").find('.help-block').remove();
        $("#addEditMatchMakerForm").removeClass("error");

        let formData = new FormData($("#addEditMatchMakerForm")[0]);
        $.ajax({
            url: "{{ url('admin/match_maker/save') }}",
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

                    matchmakersTable.ajax.reload();
                    $("#addEditMatchMakerModal").modal('hide');
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
                        $("#addEditMatchMakerForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditMatchMakerForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function deleteMatchMaker(t) {
        let match_maker_id = $(t).data('id');

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
                formData.append('match_maker_id', match_maker_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/match_maker/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            matchmakersTable.ajax.reload();
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
        // sorting_match_makers
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_match_makers', JSON.stringify(sorting_match_makers));

        $.ajax({
            url: "{{ url('admin/match_maker/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    matchmakersTable.ajax.reload();
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
