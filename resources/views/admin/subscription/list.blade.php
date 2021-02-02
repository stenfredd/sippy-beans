@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SUBSCRIPTIONS<br><span class="gray">{{ count($subscriptions) }} FOUND</p>
                        </span>
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

<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Subscribed Customers<br><span class="gray">{{ $total_active_subscription ?? 0 }} Active subscription</p>
                        </span>
                </div>
                <div>
                    <div class="card-body card-dashboard pb-50 pt-0 border-bottom">

                        <div id="ecommerce-searchbar">
                            <div class="row mt-1 justify-content-between align-items-top">
                                <div class="col-lg-7 col-md-7">
                                    <form>
                                        <fieldset class="form-group position-relative has-icon-right mb-1">
                                            <input type="text" class="form-control form-control-lg" id="search_user"
                                                placeholder="Search by first/last name, user no, phone number…">
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
                                        <a href="javascript:"
                                            class="btn btn-outline-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg mt-0"
                                            id="exportBtn">EXPORT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-content last-row">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped" id="tblSubscriptionUsers">
                                <thead>
                                    <tr>
                                        <th class="no_sorting_asc">
                                            <fieldset>
                                                <div class="vs-checkbox-con vs-checkbox-primary">
                                                    <input type="checkbox" value="false" id="chk_all">
                                                    <span class="vs-checkbox">
                                                        <span class="vs-checkbox--check">
                                                            <i class="vs-icon feather icon-check"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </fieldset>
                                        </th>
                                        <th>NAME</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th>TOTAL BILLS</th>
                                        <th>NEXT BILLING ON</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
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

        let subscriptionUsersTable = $('#tblSubscriptionUsers').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "subscription/subscribers",
                "type": "POST",
                "data": function (data) {
                    data._token = '{{ csrf_token() }}';
                    data.search = $("#search_user").val();
                },
            },
            "columns": [{
                    "render": function(meta, type, row) {
                        return '<fieldset>\
                                <div class="vs-checkbox-con vs-checkbox-primary">\
                                    <input type="checkbox" class="user-chk" name="user_ids[]" value="'+row.id+'">\
                                    <span class="vs-checkbox">\
                                        <span class="vs-checkbox--check">\
                                            <i class="vs-icon feather icon-check"></i>\
                                        </span>\
                                    </span>\
                                </div>\
                            </fieldset>';
                    },
                    'orderable': false
                },
                // {
                //     "data": "id"
                // },
                {
                    "data": "name",
                },
                {
                    "data": "email",
                },
                {
                    "data": "subscriptions_count"
                },
                {
                    "data": "next_billing_date",
                },
                {
                    "data": "subscription_status_text"
                },
                {
                    "data": "pause_subscription"
                    // "render": function(meta, type, row) {
                    //     return parseInt(row.subscription_status) === 1 ? 'Pause' : '-';
                    // }
                },
                {
                    "data": "action",
                    orderable: false
                }
            ]
        });
        $(document).ready(function() {
            $("#search_user").keyup(function() {
                subscriptionUsersTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                subscriptionUsersTable.ajax.reload();
            });

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

            $("#exportBtn").click(function() {
                let ids = [];
                $(".user-chk:checked").each(function(){
                    ids.push(this.value);
                });
                location.href = BASE_URL + 'subscription/export?user_ids=' + ids.join(',');
            });
        });

        function pauseSubscription(sub_id, user_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to enable this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Pause it!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
            })
            .then(function(result) {
                if (result.value) {
                    let formData = new FormData();
                    formData.append('sub_id', sub_id);
                    formData.append('_token', "{{ csrf_token() }}");
                    $.ajax({
                        url: "{{ url('admin/subscription/pause') }}",
                        type: "post",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === true) {
                                subscriptionUsersTable.ajax.reload();
                                Swal.fire({
                                    type: "success",
                                    title: 'Success!',
                                    text: response.message,
                                    confirmButtonClass: 'btn btn-success',
                                });
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
                else {
                    $("#user-status-" + user_id).prop('checked', true);
                }
            });
        }
    </script>
@endsection
