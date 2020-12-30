@extends('layouts.app') @section('content')
<link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui.css') }}">

<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Countries</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Masters</a>
                            </li>
                            <li class="breadcrumb-item">Countries</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button" onclick="showAddEditModal(this, false)">Add Country</button>
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
                                    <table class="table nowrap w-100" id="tblCountries">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Country Name</th>
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

<div class="modal fade" id="addEditCountryModal" tabindex="-1" role="dialog" aria-labelledby="addEditCountryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditCountryModalTitle">Add country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addEditCountryForm" class="form-horizontal" action="#" onsubmit="return false;" novalidate>
                @csrf
                <div class="modal-body">
                    <fieldset class="form-group d-none">
                        <input type="hidden" id="country_id" name="country_id" class="form-control round">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="country_name">Country Name</label>
                        <input type="text" id="country_name" name="country_name" class="form-control round" placeholder="Country Name">
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
                    <button type="submit" class="btn btn-primary btn-round" onclick="addEditCountry()">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    let countriesTable = $('#tblCountries').DataTable({
        "scrollY": 500,
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "{{ url('admin/countries') }}",
            "type": "GET",
            "data": {
                "_token": "{{ csrf_token() }}"
            }
        },
        "columns": [
            {
                "data": "DT_RowIndex",
                orderable: false,
                width: '10%'
            },
            {
                "data": "country_name",
                width: '60%'
            },
            {
                "render": function(meta, type, row) {
                    return (row.status === 1 ? 'Active' : 'Inactive');
                },
                width: '15%'
            },
            {
                "data": "action",
                orderable: false,
                width: '15%'
            }
        ]
    });

    function showAddEditModal(t, edit) {
        $('#addEditCountryModalTitle').text('Add country');
        $("#addEditCountryForm")[0].reset();
        $("#country_id").val('');
        if (edit === true) {
            $('#addEditCountryModalTitle').text('Edit country');
            let country_data = countriesTable.row($(t).parents('tr')).data();
            $("#addEditCountryForm #country_id").val(country_data.id);
            $("#addEditCountryForm #country_name").val(country_data.country_name);
            $("#addEditCountryForm #status").val(country_data.status);
        }
        $("#addEditCountryModal").modal('show');
    }

    function addEditCountry() {
        $("#addEditCountryForm").find('.help-block').remove();
        $("#addEditCountryForm").removeClass("error");

        let formData = new FormData($("#addEditCountryForm")[0]);
        $.ajax({
            url: "{{ url('admin/countries/save') }}",
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

                    countriesTable.ajax.reload();
                    $("#addEditCountryModal").modal('hide');
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
                        $("#addEditCountryForm #" + field).parents(".form-group").append('<div class="help-block"><span class="text-danger">' + errorMsg + '</span></div>');
                        $("#addEditCountryForm #" + field).parents(".form-group").addClass("error");
                    });
                }
            }
        });
    }

    function deleteCountry(t) {
        let country_id = $(t).data('id');

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
                formData.append('country_id', country_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/countries/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            countriesTable.ajax.reload();
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
