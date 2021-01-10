@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <form name="attribute-form" id="attribute-form" action="{{ url('admin/attributes/save') }}" method="post">
        @csrf
        <input type="hidden" name="attribute_type" id="attribute_type"
            value="{{ request()->segment(count(request()->segments())) }}">
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
                                        <label>ATTRIBUTE TITLE </label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst(str_replace('_', ' ', request()->segment(count(request()->segments())))) }}"
                                            name="title" id="title" placeholder="Title" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>PRODUCT LINK</label>
                                        <input type="text" class="form-control" placeholder="Beans" disabled
                                            value="Beans">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>TYPE</label>
                                        <input type="text" class="form-control" placeholder="Drop Down Selection"
                                            value="Drop Down Selection" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom pb-1">
                        <h4 class="card-title">
                            <b>ATTRIBUTES</b>
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-borderless example table-striped add-table" id="tblAttributes">
                                <thead>
                                    <tr>
                                        <th class="w-5"></th>
                                        <th class="font-small-3 text-bold-700 text-center w-15">SORT ORDER</th>
                                        <th class="font-small-3 text-bold-700">ATTRIBUTE</th>
                                        @if(request()->segment(count(request()->segments())) == 'sellers')
                                        <th>Email</th>
                                        @endif
                                        <th class="w-5"></th>
                                        <th class="font-small-3 text-bold-700 w-5"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attributes as $key => $attribute)
                                    <tr data-id="{{ $attribute->id }}">
                                        <td class="text-center">
                                            <img src="{{ asset('assets/images/sort-icon.png')}}" class="handle">
                                        </td>
                                        <td class="product-name index text-center font-medium-4">
                                            {{ $attribute->display_order ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="form-group mb-0">
                                                <input type="text" name="attributes_list[]" class="form-control"
                                                    placeholder="Input Attribute" id="title-{{ $attribute->id }}" value="{{
($attribute->title ?? '' ) .
($attribute->name ?? '' ) .
($attribute->flavor_name ?? '' ) .
($attribute->level_title ?? '' ) .
($attribute->seller_name ?? '' ) .
($attribute->origin_name ?? '' )
}}">
                                                <input type="hidden" name="attributes_list_old[]" class="form-control"
                                                    placeholder="Input Attribute" id="title-{{ $attribute->id }}" value="{{
($attribute->title ?? '' ) .
($attribute->name ?? '' ) .
($attribute->flavor_name ?? '' ) .
($attribute->level_title ?? '' ) .
($attribute->seller_name ?? '' ) .
($attribute->origin_name ?? '' )
}}">
                                            </div>
                                        </td>
                                        @if(request()->segment(count(request()->segments())) == 'sellers')
                                        <td>
                                            <input type="text" name="attributes_emails[]" class="form-control"
                                                placeholder="Input Attribute" id="email-{{ $attribute->id }}" value="{{
                                                                                                    ($attribute->seller_email ?? '' )
                                                                                                }}">
                                        </td>
                                        @endif
                                        <td>
                                            @if ((count($attributes) - 1) == $key)
                                            <button type="button" onclick="addAttribute()"
                                                class="btn btn-icon btn-success  waves-effect waves-light">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:" onclick="deleteAttribute(this)"
                                                data-id={{ $attribute->id }}>
                                                <img src="{{ asset('assets/images/extra-icon-orange.svg')}}" width="7">
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-md-6">
                <button type="submit"
                    class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE</button>
            </div>
        </div>
    </form>
</section>
@endsection


@section('scripts')
<script type="text/javascript">
    let sorting_attributes = [];
    $(document).ready(function() {
        setTimeout(function() {
            $( "#tblAttributes > tbody" ).sortable({
                placeholder: "ui-state-highlight",
                helper: 'clone',
                update: function( event, ui ) {
                    sorting_attributes = [];
                    $(this).children().each(function(index) {
                        let attribute_id = $(this).data('id');
                        sorting_attributes.push({
                            attribute_id: attribute_id,
                            sort_order: index + 1,
                        });
                    });
                    updateSortOrders();
                }
            });
            $( "#tblAttributes > tbody" ).disableSelection();
        }, 2000);
    });

    function deleteAttribute(t) {
        let id = $(t).data('id');
        let type = '{{ request()->segment(count(request()->segments())) }}';

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
                formData.append('id', id);
                formData.append('type', type);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/attributes/delete') }}",
                    type: "post",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === true) {
                            toastr.success(response.message, 'Success', toastrOptions);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        else {
                            toastr.error(response.message, 'Error', toastrOptions);
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
            }
        });
    }

    function updateSortOrders() {
        // sorting_attributes
        let type = '{{ request()->segment(count(request()->segments())) }}';

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('type', type);
        formData.append('sorting_attributes', JSON.stringify(sorting_attributes));

        $.ajax({
            url: "{{ url('admin/attributes/update-sort-orders') }}",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === true) {
                    toastr.success(response.message, 'Success', toastrOptions);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
                else {
                    toastr.error(response.message, 'Error', toastrOptions);
                }
            },
            error: function(error) {
                // console.log(error);
            }
        });
    }

    function addAttribute(is_confirm = false) {
        if(is_confirm === false) {
            let html = '<tr data-id="">\
                <td class="text-center">\
                    <img src="' + ASSET_URL + 'assets/images/sort-icon.png" class="handle">\
                </td>\
                <td class="product-name index text-center font-medium-4">-</td>\
                <td>\
                    <div class="form-group mb-0">\
                        <input type="text" name="attributes_list[]" class="form-control" placeholder="Input Attribute" id="title-null" value="">\
                        <input type="hidden" name="attributes_list_old[]" class="form-control" placeholder="Input Attribute" id="title-null"\
                            value="">\
                    </div>\
                </td>\
                @if(request()->segment(count(request()->segments())) == "sellers")\
                <td>\
                    <input type="email" name="attributes_emails[]" class="form-control" placeholder="Input Attribute"\
                        id="email-null" value="">\
                </td>\
                @else\
                <td></td>\
                @endif\
                <td></td>\
            </tr>';
            $("#tblAttributes tbody").append(html);
        }
    }
</script>
@endsection
