@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-search">
                        <h4 class="card-title pb-2">
                            <b>ATTRIBUTES</b><br>
                            <span class="gray">{{ count($db_attributes)}} ATTRIBUTES FOUND</span>
                            <div id="ecommerce-searchbar">
                                {{-- <div class="row mt-1 justify-content-between align-items-top">
                                    <div class="col-lg-8 col-md-8">
                                        <form>
                                            <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                                <input type="text" class="form-control form-control-lg" id="searchbar"
                                                    placeholder="Search by first/last name, user no, phone number…">
                                                <div class="form-control-position">
                                                    <i class="feather icon-search px-1"></i>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="d-flex justify-content-between align-items-top w-100">
                                            <button type="button"
                                                class="btn btn-orange mr-1 mb-1 waves-effect waves-light px-2 btn-lg">SEARCH</button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </h4>
                    </div>
                </div>
                <div class="card-content mt-1">
                    <div class="table-responsive pagenation-row">
                        <table class="table table-borderless table-striped table-pagenation-section" id="myTable">
                            <thead>
                                <th class="w-25 font-small-3 text-bold-700">ATTRIBUTE TITLE</th>
                                <th class="font-small-3 text-bold-700">PRODUCT LINK</th>
                                <th class="font-small-3 text-bold-700 w-15">ATTRIBUTES</th>
                                <th class="font-small-3 text-bold-700 w-10">STATUS</th>
                                <th class="font-medium-3 text-bold-700 w-5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($db_attributes as $attribute)
                                <tr id="1">
                                    <td class="font-small-3 text-bold-700">
                                        {{ $attribute['title'] }}
                                    </td>
                                    <td class="font-small-3 text-bold-700">
                                        Beans
                                    </td>
                                    <td class="font-small-3 text-bold-700">
                                        {{ $attribute['counts'] }}
                                    </td>
                                    <td class="font-small-3 text-bold-700">
                                        Enabled
                                    </td>
                                    <td class="font-medium-3 text-bold-500 no_sorting_asc sorting">
                                        <a href="{{ url('admin/attributes/' . $attribute['key']) }}"
                                            class="font-medium-5">
                                            <i class="feather icon-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="font-small-3 text-bold-700 text-center" colspan="4">
                                        No details found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
