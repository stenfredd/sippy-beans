@extends('layouts.app') @section('content')
    <div class="content-wrapper pt-1">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Equipments</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('admin') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:">Products</a>
                                </li>
                                <li class="breadcrumb-item">Equipments</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
                <div class="form-group breadcrum-right">
                    <button class="btn-icon btn btn-primary btn-round btn-sm font-small-2 font-weight-bold" type="button"
                        onclick="window.location='{{ url('admin/equipments') }}'">Add Equipment</button>
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
                                        <table class="table nowrap w-100" id="tblEquipments">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Product</th>
                                                    <th>Brand</th>
                                                    <th>Seller</th>
                                                    <th>Status</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Created At</th>
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

    {{-- <div class="modal fade" id="addEditEquipmentModal" tabindex="-1" role="dialog"
        aria-labelledby="addEditEquipmentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEditEquipmentModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>
        </div>
    </div> --}}

@endsection

@section('scripts')
    <script type="text/javascript">
/*         document.getElementById("myCheck").addEventListener("click", function() {
            toggle('area');
        });

        function toggle(obj) {

            var el = document.getElementById(obj);

            el.style.display = (el.style.display != 'none' ? 'none' : '');

        }
 */
    </script>
    <script type="text/javascript">
        let equipmentsTable = $('#tblEquipments').DataTable({
            "scrollY": 500,
            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/equipments') }}",
                "type": "GET",
                "data": {
                    "_token": "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "DT_RowIndex",
                    orderable: false,
                    width: '5%'
                },
                {
                    "data": "image_path",
                    width: '10%'
                },
                {
                    "data": "title",
                    width: '10%'
                },
                {
                    "data": "brand_name",
                    width: '10%'
                },
                {
                    "data": "seller_name",
                    width: '10%'
                },
                {
                    "render": function(meta, type, row) {
                        return (row.status === 1 ? 'Enabled' : 'Disabled');
                    },
                    width: '10%'
                },
                {
                    "data": "quantity",
                    width: '10%'
                },
                {
                    "data": "price",
                    width: '10%'
                },
                {
                    "data": "created_at",
                    width: '10%'
                },
                {
                    "data": "action",
                    orderable: false,
                    width: '10%'
                }
            ]
        });

        function showAddEditModal(t, edit) {
            $('#addEditEquipmentModalTitle').text('Add equipment');
            $("#addEditEquipmentForm")[0].reset();
            $("#equipment_id").val('');
            if (edit === true) {
                $('#addEditEquipmentModalTitle').text('Edit equipment');
                let equipmentData = equipmentsTable.row($(t).parents('tr')).data();
                $("#addEditEquipmentForm #equipment_id").val(equipmentData.id);
                $("#addEditEquipmentForm #seller_id").val(equipmentData.seller_id);
                $("#addEditEquipmentForm #title").val(equipmentData.title);
                $("#addEditEquipmentForm #short_description").val(equipmentData.short_description);
                $("#addEditEquipmentForm #description").val(equipmentData.description);
                $("#addEditEquipmentForm #price").val(equipmentData.price);
                $("#addEditEquipmentForm #image_path").val(equipmentData.image_path);
                $("#addEditEquipmentForm #status").val(equipmentData.status);
            }
            $("#addEditEquipmentModal").modal('show');
        }

        function addEditEquipment() {
            $("#addEditEquipmentForm").find('.help-block').remove();
            $("#addEditEquipmentForm").removeClass("error");

            let formData = new FormData($("#addEditEquipmentForm")[0]);
            $.ajax({
                url: "{{ url('admin/equipments/save') }}",
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

                        equipmentsTable.ajax.reload();
                        $("#addEditEquipmentModal").modal('hide');
                    } else {
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
                            $("#addEditEquipmentForm #" + field).parents(".form-group").append(
                                '<div class="help-block"><span class="text-danger">' + errorMsg +
                                '</span></div>');
                            $("#addEditEquipmentForm #" + field).parents(".form-group").addClass(
                                "error");
                        });
                    }
                }
            });
        }

        function deleteEquipment(t) {
            let equipment_id = $(t).data('id');

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
                        formData.append('equipment_id', equipment_id);
                        formData.append('_token', "{{ csrf_token() }}");
                        $.ajax({
                            url: "{{ url('admin/equipments/delete') }}",
                            type: "post",
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status === true) {
                                    equipmentsTable.ajax.reload();
                                    Swal.fire({
                                        type: "success",
                                        title: 'Deleted!',
                                        text: response.message,
                                        confirmButtonClass: 'btn btn-success',
                                    })
                                } else {
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
            // sorting_equipment
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('sorting_equipment', JSON.stringify(sorting_equipment));

            $.ajax({
                url: "{{ url('admin/equipments/update-sort-orders') }}",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === true) {
                        brandsTable.ajax.reload();
                        Swal.fire({
                            type: "success",
                            title: 'Success',
                            text: response.message,
                            confirmButtonClass: 'btn btn-success',
                        })
                    } else {
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
