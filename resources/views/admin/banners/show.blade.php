@extends('layouts.app')
@section('content')
    <section>
        <form action="{{ url('admin/banners/save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="banner_id" id="banner_id" value="{{ ($banner->id ?? '') }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header pb-1 border-bottom">
                            <h4 class="card-title">BANNER MANAGMENT</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>BANNER TITLE</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Add a title for the banner" value="{{ old('title') ?? ($banner->title ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>BANNER URL</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                                placeholder="Add a url for the banner" value="{{ old('url') ?? ($banner->url ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>TYPE</label>
                                            <select id="type" name="type" class="form-control">
                                                <option value="">None</option>
                                                <option value="product" {{ ($banner->type ?? '') == 'product' ? 'selected' : '' }}>Product</option>
                                                <option value="equipment" {{ ($banner->type ?? '') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="display: {{ !empty($banner->product_id ?? null) ? '' : 'none' }};">
                                            <label>PRODUCT</label>
                                            <select id="product_id" name="product_id" class="form-control">
                                                <option value="">Select</option>
                                                @if (!empty($products) && count($products) > 0)
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}" {{ ($banner->product_id ?? '') == $product->id ? 'selected' : '' }}>{{ $product->product_name }}</option>                                                        
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group" style="display: {{ !empty($banner->equipment_id ?? null) ? '' : 'none' }};">
                                            <label>EQUIPMENT</label>
                                            <select id="equipment_id" name="equipment_id" class="form-control">
                                                <option value="">Select</option>
                                                @if (!empty($equipments) && count($equipments) > 0)
                                                    @foreach ($equipments as $equipment)
                                                        <option value="{{ $equipment->id }}" {{ ($banner->equipment_id ?? '') == $equipment->id ? 'selected' : '' }}>{{ $equipment->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>BANNER ENABLE/DISABLE</label>
                                            <div
                                                class="custom-control custom-switch custom-switch-primary mr-2 mb-1 text-left">
                                                <input type="checkbox" class="custom-control-input"
                                                    {{ ($banner->status ?? 0) == 1 ? 'checked' : '' }} name="status" id="status" value="1">
                                                <label class="custom-control-label" for="status">
                                                    <span class="switch-text-left"></span>
                                                    <span class="switch-text-right"></span>
                                                </label>
                                            </div>
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
                            <h4 class="card-title">BANNER IMAGE</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <div class="add-new-banner-div">
                                        <input type="file" name="image_url" id="image_url" class="file-thard d-none" accept="image/*">
                                        <div div class="enable-img d-flex align-items-center" onclick="$('#image_url').click()">
                                            <img src="{{ asset($banner->image_url ?? 'assets/images/add-new-banner.jpg') }}"
                                                id="preview-thard" class="browse-thard">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-end">
                <div class="col-md-6">
                    <button type="submit"
                        class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light mb-1"
                        data-dismiss="modal">SAVE & REQUEST</button>
                        @if(!empty($banner->id ?? ''))
                    <button type="button"
                        class="btn btn-light  font-weight-bold btn-lg w-100 waves-effect waves-light text-dark" onclick="deleteBanner()">DELETE BANNER</button>
                        @endif
                </div>
            </div>
        </form>
    </section>
@endsection


@section('scripts')
    <script type="text/javascript">
    $("#type").change(function() {
        $("#product_id").val('');
        $("#equipment_id").val('');
        $("#product_id").parents('.form-group').hide();
        $("#equipment_id").parents('.form-group').hide();
        if($(this).val().toString().length > 0) {
            $("#" + $(this).val() + '_id').parents('.form-group').show();
        }
    });
        $('#image_url').change(function(e) {
            var fileName = e.target.files[0].name;

            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview-thard").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });

    function deleteBanner(t) {
        let banner_id = '{{ $banner->id ?? 0 }}';

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
                formData.append('banner_id', banner_id);
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/banners/delete') }}",
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
                                location.href = '{{ url("admin/banners") }}';
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
    </script>
@endsection
