@extends('layouts.app') @section('content')
<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Promocodes</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Promocodes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Promocode</button>
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
                                    <table class="table nowrap w-100" id="tblPromocodes">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Title</th>
                                                <th>Promocode</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Used Limit</th>
                                                {{-- <th>User Ids</th> --}}
                                                <th>Discount Type</th>
                                                <th>Discount Amount</th>
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

<div class="modal fade" id="addEditPromocodeModal" tabindex="-1" role="dialog" aria-labelledby="addEditPromocodeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditPromocodeModalTitle">Add Promocode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditPromocodeForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="promocode_id" name="promocode_id" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control round" placeholder="Title">
                    </fieldset>
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control round" placeholder="Start Date">
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="start_hour">Hour</label>
                                <select name="start_hour" id="start_hour" class="form-control">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ (strlen($i) == 1 ? '0' : '') . $i }}</option>
                                    @endfor
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="start_minute">Minute</label>
                                <select name="start_minute" id="start_minute" class="form-control">
                                    @for ($i = 1; $i <= 59; $i++)
                                        <option>{{ (strlen($i) == 1 ? '0' : '') . $i }}</option>
                                    @endfor
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="start_am_pm">Time</label>
                                <select name="start_am_pm" id="start_am_pm" class="form-control">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control round" placeholder="End Date">
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="end_hour">Hour</label>
                                <select name="end_hour" id="end_hour" class="form-control">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option>{{ (strlen($i) == 1 ? '0' : '') . $i }}</option>
                                    @endfor
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="end_minute">Minute</label>
                                <select name="end_minute" id="end_minute" class="form-control">
                                    @for ($i = 1; $i <= 59; $i++)
                                        <option>{{ (strlen($i) == 1 ? '0' : '') . $i }}</option>
                                    @endfor
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <fieldset class="form-group">
                                <label for="end_am_pm">Time</label>
                                <select name="end_am_pm" id="end_am_pm" class="form-control">
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="promocode">Promocode</label>
                                <input type="text" id="promocode" name="promocode" class="form-control round" placeholder="Promocode">
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="used_limit">Used Limit</label>
                                <input type="number" id="used_limit" name="used_limit" class="form-control round" placeholder="Used Limit">
                            </fieldset>
                        </div>
                    </div>
                    <fieldset class="form-group">
                        <label for="user_ids">Users</label>
                        <select id="user_ids" name="user_ids[]" class="form-control round" multiple>
                            <option value="">Select User</option>
                            @if(!empty($users))
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </fieldset>
                    <div class="row">
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="discount_type">Discount Type</label>
                                <select id="discount_type" name="discount_type" class="form-control round">
                                    <option value="">Select User</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="amount">Amount</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <fieldset class="form-group">
                                <label for="discount_amount">Discount Amount</label>
                                <input type="text" id="discount_amount" name="discount_amount" class="form-control round" placeholder="Discount Amount">
                            </fieldset>
                        </div>
                    </div>
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
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditPromocode()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/jquery-ui.js') }}"></script>
<script type="text/javascript">
    let promocodesTable = $('#tblPromocodes').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/promocodes') }}",
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
                "data": "promocode_type",
                width: '10%'
            },
            {
                "data": "title",
                width: '15%'
            },
            {
                "data": "promocode",
                width: '15%'
            },
            {
                "render": function(data, type, row) {
                    if(type == 'display') {
                        return row.display_start_date
                    }
                    else {
                        return row.start_date;
                    }
                },
                width: '10%'
            },
            {
                "render": function(data, type, row) {
                    if(type == 'display') {
                        return row.display_end_date
                    }
                    else {
                        return row.end_date;
                    }
                },
                width: '10%'
            },
            {
                "data": "used_limit",
                width: '7%'
            },
            /* {
                "data": "user_ids",
                width: '15%'
            }, */
            {
                "data": "discount_type",
                width: '7%'
            },
            {
                "data": "discount_amount",
                width: '7%'
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
                width: '7%'
            }
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).attr('data-id', data.id);
        }
    });

    function showAddEditModal(t, edit) {
        $("#addEditPromocodeForm")[0].reset();
        $("#promocode_id").val('');
        if (edit === true) {
            let promocodeData = promocodesTable.row($(t).parents('tr')).data();
            $("#addEditPromocodeForm #promocode_id").val(promocodeData.id);
            $("#addEditPromocodeForm #title").val(promocodeData.title);
            $("#addEditPromocodeForm #promocode").val(promocodeData.promocode);
            $("#addEditPromocodeForm #start_date").val(promocodeData.start_date);
            $("#addEditPromocodeForm #start_hour").val(promocodeData.start_time.start_hour);
            $("#addEditPromocodeForm #start_minute").val(promocodeData.start_time.start_minute);
            $("#addEditPromocodeForm #start_am_pm").val(promocodeData.start_time.start_am_pm);
            $("#addEditPromocodeForm #end_date").val(promocodeData.end_date);
            $("#addEditPromocodeForm #end_hour").val(promocodeData.end_time.end_hour);
            $("#addEditPromocodeForm #end_minute").val(promocodeData.end_time.end_minute);
            $("#addEditPromocodeForm #end_am_pm").val(promocodeData.end_time.end_am_pm);
            $("#addEditPromocodeForm #used_limit").val(promocodeData.used_limit);
            $("#addEditPromocodeForm #user_ids").val(promocodeData.user_ids);
            $("#addEditPromocodeForm #discount_type").val(promocodeData.discount_type.toLowerCase());
            $("#addEditPromocodeForm #discount_amount").val(promocodeData.discount_amount);
            $("#addEditPromocodeForm #status").val(promocodeData.status);
        }
        $("#addEditPromocodeModal").modal('show');
    }

    function addEditPromocode() {
        $("#addEditPromocodeForm").find('.help-block').remove();
        $("#addEditPromocodeForm").removeClass("error");

        let formData = new FormData($("#addEditPromocodeForm")[0]);
        $.ajax({
            url: "{{ url('admin/promocodes/save') }}",
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

                    promocodesTable.ajax.reload();
                    $("#addEditPromocodeModal").modal('hide');
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
                        $("#addEditPromocodeForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditPromocodeForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function deletePromocode(t) {
        let promocode_id = $(t).data('id');

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
                formData.append('promocode_id', promocode_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/promocodes/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            promocodesTable.ajax.reload();
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
</script>
@endsection
