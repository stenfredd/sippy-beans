@extends('layouts.app')
@section('content')
<section>
    <form id="category-form" name="category-form" action="{{ url('admin/categories/save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="category_id" id="category_id" value="{{ $category->id ?? '' }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">CATEGORY INFORMATION</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CATEGORY TITLE</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Add a title for the category" value="{{ $category->category_title ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>CATEGORY SUBTITLE</label>
                                        <input type="text" class="form-control" name="description" id="
                                        description" placeholder="Enter the subtitle for the category" value="{{ $category->description ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">CATEGORY ICON</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12  text-center py-2">
                                    <div class="form-group mb-0">
                                        <div class="add-new-banner-div">
                                            <div div class="enable-img d-flex align-items-center">
                                                <input type="file" name="image_url" id="image_url"
                                                    class="file-alternate-image-three d-none" accept="image/*">
                                                <img src="{{ asset($category->image_url ?? 'assets/images/product-uplode.png')}}"
                                                    onclick="$('#image_url').click()" id="image_url-preview">
                                            </div>
                                        </div>
                                        <p class="font-medium-2 text-bold-700 text-center pt-1">PRIMARY IMAGE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($category) && !empty($category->id))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-search">
                            <h4 class="card-title">
                                <b>PRODUCTS</b><br>
                                <span class="gray">{{ $products ?? 0 }} Products</span>
                            </h4>
                            <div id="ecommerce-searchbar">
                                <div class="row mt-1 justify-content-between align-items-top">
                                    <div class="col-lg-7 col-md-7">
                                        <form>
                                            <fieldset class="form-group position-relative has-icon-right mb-1">
                                                <input type="text" class="form-control form-control-lg" id="search_product"
                                                    placeholder="Search by product name, product#, brand, seller">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search px-1"></i>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                        <div class="d-flex justify-content-between align-items-top w-100">
                                            <button type="button" class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg"
                                                id="search_btn">SEARCH</button>
                                            <a href="{{ url('admin/products/create') }}" type="button"
                                                class="btn btn-outline-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD
                                                NEW PRODUCT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive pagenation-row beans-tabal">
                            <table class="table table-borderless table-striped" id="tblProducts">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>IMAGE</th>
                                        <th class="w-18">PRODUCT</th>
                                        <th>BRAND</th>
                                        <th>SELLER</th>
                                        <th>STATUS</th>
                                        <th class="no_sorting_asc"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row justify-content-end">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light"
                    data-dismiss="modal">SAVE</button>
                <button type="button" class="btn font-weight-bold btn-lg w-100 waves-effect waves-light btn-outline-primary mt-1"
                    onclick="deleteCategory()">DELETE</button>
            </div>
        </div>
    </form>
</section>
{{--
<!--Add New Service modal-->
<div class="modal fade text-left" id="create-variants" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD PRODUCT VARIANT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>PRICE</label>
                            <div class="form-group">
                                <fieldset>
                                    <div class="input-group variants-fild group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">AED</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>REWARD</label>
                            <div class="form-group">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="category">
                                    <i class="dropdown icon"></i>
                                    <div class="default text"></div>
                                    <div class="menu">
                                        <div class="item" data-value="electical">
                                            1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>SHIP WEIGHT</label>
                            <div class="form-group variants-fild group-append">
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold" id="basic-addon2">g</span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg w-30"
                        data-dismiss="modal">CREATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="edit-variants" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD PRODUCT VARIANT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>PRICE</label>
                            <div class="form-group">
                                <fieldset>
                                    <div class="input-group variants-fild group-prepend">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold" id="basic-addon1">AED</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>REWARD</label>
                            <div class="form-group">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="category">
                                    <i class="dropdown icon"></i>
                                    <div class="default text"></div>
                                    <div class="menu">
                                        <div class="item" data-value="electical">
                                            1
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>SHIP WEIGHT</label>
                            <div class="form-group variants-fild group-append">
                                <fieldset>
                                    <div class="input-group">
                                        <input type="text" class="form-control" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold" id="basic-addon2">g</span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-outline-primary  mr-1 waves-effect font-weight-bold waves-light btn-lg"
                        data-dismiss="modal">DELETE</button>
                    <button type="button" class="btn btn-primary font-weight-bold btn-lg w-30"
                        data-dismiss="modal">CREATE</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<!--End Add New Service modal-->
@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
        $("#search_product").keyup(function() {
            productsTable.ajax.reload();
        });
        $("#search_btn").click(function() {
            productsTable.ajax.reload();
        });
    });
    @if(!empty($category) && !empty($category->id))
    let productsTable = $('#tblProducts').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "searching": false,
        "order": [],
        "ajax": {
            "url": BASE_URL + @if(isset($is_equipment) && $is_equipment == 1) "equipments" @else "products" @endif,
            "type": "POST",
            "data": function(data) {
                data._token = '{{ csrf_token() }}';
                data.search = $("#search_product").val();
                data.category_id = '{{ $category->id ?? "" }}';
            }
        },
        "columns": [
            {
                "data": "sort_image",
                "class": "text-center"
            },
            {
                "data": "image_path",
                "class": "beans-product-img"
            },
            {
                "data": "product_name",
                "class": "text-bold-500 font-small-3"
            },
            {
                "data": "brand_name",
                "class": "text-bold-500 font-small-3"
            },
            {
                "data": "seller_name",
                "class": "text-bold-500 font-small-3"
            },
            {
                "data": "status",
                "class": "text-bold-500 font-small-3"
            },
            {
                "data": "action",
                orderable: false,
                "class": "no_sorting_asc"
            }
        ],
    createdRow: function (row, data, dataIndex) {
        $(row).attr('data-id', data.id);
    }
    });
    @endif
    $('#image_url').change(function(e) {
        var fileName = e.target.files[0].name;

        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("image_url-preview").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });

    function deleteCategory() {
        let category_id = '{{ $category->id ?? "" }}';
        if(category_id.toString().length === 0) {
            return false;
        }

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
                formData.append('category_id', category_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/categories/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            Swal.fire({
                                type: "success",
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonClass: 'btn btn-success',
                            });

                            setTimeout(() => {
                                location.href = BASE_URL + 'categories';
                            }, 2000);
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

    let sorting_products = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblProducts > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_products = [];
                    $(this).children().each(function(index) {
                        let product_id = $(this).data('id');
                        sorting_products.push({
                            product_id: product_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblProducts > tbody" ).disableSelection();
        }, 2000);
    });

    function updateSortOrders() {
        // sorting_products
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('sorting_products', JSON.stringify(sorting_products));
formData.append('is_equipment', '{{ $is_equipment ?? 0 }}');

        $.ajax({
            url: "{{ url('admin/categories/update-products-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    productsTable.ajax.reload();
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
