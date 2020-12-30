@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">BEANS<br><span class="gray">{{ $total_products ?? 0 }} PRODUCTS FOUND</p>
                        </span>
                </div>
                <div>
                    <div class="card-body card-dashboard">

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
                                        <button type="button"
                                            class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg"
                                            id="search_btn">SEARCH</button>
                                        <a href="{{ url('admin/products/create') }}" type="button"
                                            class="btn btn-outline-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD
                                            NEW PRODUCT</a>
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
                                        {{-- <th class="no_sorting_asc">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="false">
                                                    <span class="vs-checkbox vs-checkbox-sm">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </th> --}}
                                        <th>ID#</th>
                                        <th>IMAGE</th>
                                        <th class="w-18">PRODUCT</th>
                                        <th>BRAND</th>
                                        <th>SELLER</th>
                                        <th>STATUS</th>
                                        {{-- <th>QTY</th>
                                        <th>PRICE</th> --}}
                                        <th>CREATED AT</th>
                                        <th class="no_sorting_asc"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td class="no_sorting_asc">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="false">
                                                    <span class="vs-checkbox vs-checkbox-sm">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </td>
                                        <td class="text-bold-500">#00001</td>
                                        <td class="beans-product-img"><img
                                                src="{{ asset('assets/images/product-img.png')}}"></td>
                                    <td class="text-bold-500">Basques de San Francisco</td>
                                    <td class="text-bold-500">Fritz Coffee</td>
                                    <td class="text-bold-500">Fritz Coffee</td>
                                    <td class="text-bold-500">Enabled</td>
                                    <td class="text-bold-500">99</td>
                                    <td class="text-bold-500">AED 1,200.00</td>
                                    <td class="text-bold-500">
                                        Sept 5, 2020<br><span class="time">11:30AM</span>
                                    </td>
                                    <td class="text-bold-500"><a href="{{ url('admin/products/1') }}"><i
                                                class="feather icon-eye"></i></a></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    let productsTable = $('#tblProducts').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthChange": false,
        "searching": false,
        "order": [],
        "ajax": {
            "url": BASE_URL + "products",
            "type": "POST",
            "data": function(data) {
                data._token = '{{ csrf_token() }}';
                data.search = $("#search_product").val();
            }
        },
        "columns": [
            /* {
                "data": "chk_select",
                "class": "no_sorting_asc"
            }, */
            {
                "data": "id",
                "class": "text-bold-500"
            },
            {
                "data": "image_path",
                "class": "beans-product-img"
            },
            {
                "data": "product_name",
                "class": "text-bold-500"
            },
            {
                "data": "brand_name",
                "class": "text-bold-500"
            },
            {
                "data": "seller_name",
                "class": "text-bold-500"
            },
            {
                "data": "status",
                "class": "text-bold-500"
            },
            /* {
                "data": "quantity",
                "class": "text-bold-500"
            },
            {
                "data": "price",
                "class": "text-bold-500"
            }, */
            {
                "data": "created_at",
                "class": "text-bold-500"
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
</script>
@endsection
