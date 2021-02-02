@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">USERS<br><span class="gray">{{ $total_users ?? 0 }} REGISTERD USERS</p>
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
                            <table class="table table-borderless table-striped" id="tblUsers">
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
                                        <th>USER NO.</th>
                                        <th>FIRST NAME</th>
                                        <th>LAST NAME</th>
                                        <th>EMAIL ADDRESS</th>
                                        <th>REWARD POINTS</th>
                                        <th>ORDERS</th>
                                        <th>REVENUE</th>
                                        <th>CREATED AT</th>
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
    $(document).ready(function() {
            $("#search_user").keyup(function() {
                usersTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                usersTable.ajax.reload();
            });
        });
        let usersTable = $('#tblUsers').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": BASE_URL + "users",
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
                {
                    "data": "id"
                },
                {
                    "data": "first_name",
                },
                {
                    "data": "last_name",
                },
                {
                    "data": "email",
                },
                {
                    "data": "reward_points",
                },
                {
                    "data": "orders_count"
                },
                {
                    "data": "revenue"
                },
                {
                    "data": "created_at",
                    orderable: false
                },
                {
                    "data": "action",
                    orderable: false
                }
            ]
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
            location.href = BASE_URL + 'users/export?user_ids=' + ids.join(',');
        });
</script>
@endsection
