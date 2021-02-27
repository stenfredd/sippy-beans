@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{-- <div class="row"> --}}
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h4 class="card-title">
                                SUBSCRIPTIONS<br>
                                <span class="gray">{{ count($subscriptions) }} FOUND</span>
                            </h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="{{ url('admin/subscription/users') }}"
                                class="float-right btn btn-primary font-weight-bold btn-lg waves-effect waves-light px-1">
                                MANAGE USERS SUBSCRIPTIONS
                            </a>
                        </div>
                    {{-- </div> --}}
                </div>
                <div>
                    <div class="card-body card-dashboard">

                        <div id="ecommerce-searchbar">
                            <div class="row mt-1 justify-content-between align-items-top">
                                <div class="col-lg-8 col-md-8">
                                    <form>
                                        <fieldset class="form-group position-relative has-icon-right mb-1">
                                            <input type="text" class="form-control form-control-lg" id="search_subscription"
                                                placeholder="Search by product name, product#, brand, seller" onkeyup="searchSubscription()">
                                            <div class="form-control-position">
                                                <i class="feather icon-search px-1"></i>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="d-flex justify-content-between align-items-top w-100">
                                        <button type="button"
                                            class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg" id="search_btn">SEARCH</button>
                                        {{-- <a href="http://3.6.128.23/sippy-beans-dashboard/index.php/add-products-subscriptions" type="button"
                                            class="btn btn-outline-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD NEW
                                            PRODUCT</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive pagenation-row beans-tabal">
                            <table class="table table-borderless table-striped" id="tblSubscriptions">
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
                                        <th class="no_sorting_asc text-center w-12">IMAGE</th>
                                        <th class="w-15">PRODUCT</th>
                                        <th>BRAND</th>
                                        <th>SELLER</th>
                                        <th>STATUS</th>
                                        <th>QTY</th>
                                        <th>PRICE</th>
                                        <th>CREATED AT</th>
                                        <th class="no_sorting_asc"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($subscriptions as $subscription)
                                    <tr>
                                        <td class="text-bold-500">#{{ $subscription->id }}</td>
                                        <td class="beans-product-img">
                                            <img
                                                src="{{ asset($subscription->image_url ?? 'assets/images/subscription-box.png')}}">
                                        </td>
                                        <td class="text-bold-500">{{ $subscription->title }}</td>
                                        <td class="text-bold-500">SIPPY</td>
                                        <td class="text-bold-500">SIPPY LTD</td>
                                        <td class="text-bold-500">
                                            {{ $subscription->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                        <td class="text-bold-500">{{ $subscription->quantity ?? 0 }}</td>
                                        <td class="text-bold-500">
                                            {{ $app_settings['currency_code'] .' '. number_format($subscription->price,2) }}</td>
                                        <td class="text-bold-500">
                                            {{ $subscription->created_at->timezone($app_settings['timezone'])->format("M d, Y") }}
                                            <br>
                                            <span
                                                class="time">{{ $subscription->created_at->timezone($app_settings['timezone'])->format("g:iA") }}</span>
                                        </td>
                                        <td class="text-bold-500">
                                            <a href="{{ url('admin/subscription/1') }}">
                                                <i class="feather icon-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr colspan="10"></tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                </tfoot>
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
        function searchSubscription() {
            var input, filter, table, tbody, tr, td, i, txtValue;
            input = document.getElementById("search_subscription");
            filter = input.value.toLowerCase();
            table = document.getElementById("tblSubscriptions");
            tbody = table.getElementsByTagName("tbody")[0];
            tr = tbody.getElementsByTagName("tr");

            $("#tblSubscriptions tfoot").html('');

            for (i = 0; i < tr.length; i++) {
                td1=tr[i].getElementsByTagName("td")[2];
                td2=tr[i].getElementsByTagName("td")[3];
                td3=tr[i].getElementsByTagName("td")[4];
                td4=tr[i].getElementsByTagName("td")[7];

                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValue3 = td3.textContent || td3.innerText;
                txtValue4 = td4.textContent || td4.innerText;

                if (
                    txtValue1.toLowerCase().indexOf(filter)> -1
                    || txtValue2.toLowerCase().indexOf(filter)> -1
                    || txtValue3.toLowerCase().indexOf(filter)> -1
                    || txtValue4.toLowerCase().indexOf(filter)> -1
                ) {
                    tr[i].style.display = "";
                }
                else {
                    tr[i].style.display = "none";
                }
            }

            if($("#tblSubscriptions tbody tr:visible").length === 0) {
                $("#tblSubscriptions tfoot").html('<tr><td colspan="10" class="text-center">No records found.</td></tr>');
                $("#tblSubscriptions tfoot").show();
            }
            else {
                $("#tblSubscriptions tfoot").hide();
            }
        }

        $(document).ready(function() {
            $("#chk_all").change(function() {
                $(".user-chk").prop("checked", $(this).prop("checked"));
            });

            setTimeout(() => {
                $(".user-chk").change(function() {
                    if($(".user-chk").length === $(".user-chk:checked").length) {
                        $("#chk_all").prop("checked", true);
                    }
                    else {
                        $("#chk_all").prop("checked", false);
                    }
                });
            }, 1000);
        });
    </script>
@endsection
