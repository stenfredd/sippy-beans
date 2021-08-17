@extends('layouts.app')
@section('content')
<div class="service-requests">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-search">
                        <h4 class="card-title">
                            <b>PROMO/OFFERS</b><br>
                            <span class="gray">{{ $active_promocodes ?? 0 }} ACTIVE PROMO(S)</span>
                        </h4>
                        <div id="ecommerce-searchbar">
                            <div class="row mt-1 justify-content-between align-items-top">
                                <div class="col-lg-7 col-md-6">
                                    <form>
                                        <fieldset class="form-group position-relative has-icon-right mb-1 mr-0">
                                            <input type="text" class="form-control form-control-lg" id="search_promocode"
                                                placeholder="Search by first/last name, user no, phone number…">
                                            <div class="form-control-position">
                                                <i class="feather icon-search px-1"></i>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-lg-5 col-md-6">
                                    <div class="d-flex justify-content-between align-items-top w-100">
                                        <button type="button"
                                            class="btn btn-orange mr-1 mb-1 waves-effect waves-light btn-block btn-lg" id="search_btn">SEARCH</button>
                                        <a href="{{ url('admin/promo-offers/create') }}" type="button"
                                            class="btn btn-outline-orange mr-0 mb-1 waves-effect waves-light btn-block btn-lg mt-0">ADD
                                            NEW PROMO</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="user-profile" class="mt-1">
                    <div class="card-content service-requests-tab">
                        <div>
                            <ul class="nav nav-tabs nav-fill" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="new-requests-justified" data-toggle="tab"
                                        href="#new-requests" role="tab" aria-controls="new-requests"
                                        aria-selected="true">
                                        ACTIVE
                                        <sapn>({{ $active_promocodes ?? 0 }})</sapn>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="in-progress-justified" data-toggle="tab" href="#in-progress"
                                        role="tab" aria-controls="in-progress" aria-selected="true">UPCOMING
                                        <span>({{ $upcoming_promocodes ?? 0 }})</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="upcoming-tab-justified" data-toggle="tab" href="#upocoming"
                                        role="tab" aria-controls="upcoming" aria-selected="false">EXPIRED</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="completed-tab-justified" data-toggle="tab" href="#completed"
                                        role="tab" aria-controls="completed" aria-selected="false">VIEW ALL</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active active-promocodes" id="active-promocodes" role="tabpanel"
                                    aria-labelledby="active-promocodes-justified">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless table-striped" id="tblActivePromocodes">
                                            <thead>
                                                <tr>
                                                    <th class="w-3 font-small-3">#</th>
                                                    <th class="w-15 font-small-3">PROMO TITLE</th>
                                                    <th class="w-12 font-small-3">PROMO CODE</th>
                                                    <th class="font-small-3">VALUE</th>
                                                    <th class="font-small-3">TYPE</th>
                                                    <th class="w-5 font-small-3">USER(S)</th>
                                                    <th class="w-10 font-small-3">USE COUNT</th>
                                                    <th class="font-small-3">STATUS</th>
                                                    <th class="w-12 font-small-3">START DATE</th>
                                                    <th class="w-12 font-small-3">END DATE</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- <tr>
                                                                                    <td class="font-small-2">#1</td>
                                                                                    <td class="font-small-2">Weekend Discount</td>
                                                                                    <td class="font-small-2">WKND20
                                                                                    </td>
                                                                                    <td class="font-small-2">20</td>
                                                                                    <td class="font-small-2">Percentage</td>
                                                                                    <td class="font-small-2">All</td>
                                                                                    <td class="font-small-2">10</td>
                                                                                    <td>
                                                                                        <div class="status-options">
                                                                                            <div class="status-options">
                                                                                                <div class="d-inline-block selected mr-25">
                                                                                                    <div class="color-option border-success">
                                                                                                        <div class="filloption bg-success"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <span
                                                                                                    class="font-small-2 text-success font-weight-bold d-inline-block">
                                                                                                    Active</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="font-small-2">Sept 5, 2020<br><span
                                                                                            class="gray">11:30AM</span></td>
                                                                                    <td class="font-small-2">Sept 5, 2020<br><span
                                                                                            class="gray">11:30AM</span></td>
                                                                                    <td class="font-small-2"><a href="{{ url('admin/promo-offers/1') }}"
                                                class="font-large-1"><i class="feather icon-eye"></i></a>
                                                </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane upcoming-promocodes" id="upcoming-promocodes" role="tabpanel"
                                    aria-labelledby="upcoming-promocodes-justified">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless table-striped" id="tblUpcomingPromocodes">
                                            <thead>
                                                <tr>
                                                    <th class="w-3 font-small-3">#</th>
                                                    <th class="w-15 font-small-3">PROMO TITLE</th>
                                                    <th class="w-12 font-small-3">PROMO CODE</th>
                                                    <th class="font-small-3">VALUE</th>
                                                    <th class="font-small-3">TYPE</th>
                                                    <th class="w-5 font-small-3">USER(S)</th>
                                                    <th class="w-10 font-small-3">USE COUNT</th>
                                                    <th class="font-small-3">STATUS</th>
                                                    <th class="w-12 font-small-3">START DATE</th>
                                                    <th class="w-12 font-small-3">END DATE</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane expired-promocodes" id="expired-promocodes" role="tabpanel"
                                    aria-labelledby="expired-promocodes-justified">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless table-striped" id="tblExpiredPromocodes">
                                            <thead>
                                                <tr>
                                                    <th class="w-3 font-small-3">#</th>
                                                    <th class="w-15 font-small-3">PROMO TITLE</th>
                                                    <th class="w-12 font-small-3">PROMO CODE</th>
                                                    <th class="font-small-3">VALUE</th>
                                                    <th class="font-small-3">TYPE</th>
                                                    <th class="w-5 font-small-3">USER(S)</th>
                                                    <th class="w-10 font-small-3">USE COUNT</th>
                                                    <th class="font-small-3">STATUS</th>
                                                    <th class="w-12 font-small-3">START DATE</th>
                                                    <th class="w-12 font-small-3">END DATE</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane all-promocodes" id="all-promocodes" role="tabpanel" aria-labelledby="all-promocodes-justified">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless table-striped" id="tblAllPromocodes">
                                            <thead>
                                                <tr>
                                                    <th class="w-3 font-small-3">#</th>
                                                    <th class="w-15 font-small-3">PROMO TITLE</th>
                                                    <th class="w-12 font-small-3">PROMO CODE</th>
                                                    <th class="font-small-3">VALUE</th>
                                                    <th class="font-small-3">TYPE</th>
                                                    <th class="w-5 font-small-3">USER(S)</th>
                                                    <th class="w-10 font-small-3">USE COUNT</th>
                                                    <th class="font-small-3">STATUS</th>
                                                    <th class="w-12 font-small-3">START DATE</th>
                                                    <th class="w-12 font-small-3">END DATE</th>
                                                    <th></th>
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
            $("#search_promocode").keyup(function() {
                activePromocodesTable.ajax.reload();
                upcomingPromocodesTable.ajax.reload();
                expiredPromocodesTable.ajax.reload();
                allPromocodesTable.ajax.reload();
            });
            $("#search_btn").click(function() {
                activePromocodesTable.ajax.reload();
                upcomingPromocodesTable.ajax.reload();
                expiredPromocodesTable.ajax.reload();
                allPromocodesTable.ajax.reload();
            });
        });
        let activePromocodesTable = $('#tblActivePromocodes').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "pageLength": 30,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/promo-offers') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.promo_type = '1';
                    data.search = $("#search_promocode").val();
                }
            },
            "columns": [{
                    "data": "id",
                    "class": "font-small-2",
                    orderable: false,
                },
                {
                    "data": "title",
                    "class": "font-small-2",
                },
                {
                    "data": "promocode",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_amount",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_type",
                    "class": "font-small-2",
                },
                {
                    "data": "user_ids",
                    "class": "font-small-2",
                },
                {
                    "data": "used_limit",
                    "class": "font-small-2",
                },
                {
                    "render": function(meta, type, row) {
                        return '<div class="status-options">\
                                             <div class="status-options">\
                                                <div class="d-inline-block selected mr-25">\
                                                   <div class="color-option border-'+(parseInt(row.status) === 1 ? 'success' : 'danger')+'">\
                                                      <div class="filloption bg-'+(parseInt(row.status) === 1 ? 'success' : 'danger')+'"></div>\
                                                   </div>\
                                                </div>\
                                                <span class="font-small-2 text-'+(parseInt(row.status) === 1 ? 'success' : 'danger')+' font-weight-bold d-inline-block">\
                                                '+(parseInt(row.status) === 1 ? 'Active' : 'Inactive')+'</span>\
                                             </div>\
                                          </div>';
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_start_date
                        } else {
                            return row.start_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_end_date
                        } else {
                            return row.end_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "data": "action",
                    orderable: false,
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            }
        });
        let upcomingPromocodesTable = $('#tblUpcomingPromocodes').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/promo-offers') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.promo_type = '2';
                    data.search = $("#search_promocode").val();
                }
            },
            "columns": [{
                    "data": "id",
                    "class": "font-small-2",
                    orderable: false,
                },
                {
                    "data": "title",
                    "class": "font-small-2",
                },
                {
                    "data": "promocode",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_amount",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_type",
                    "class": "font-small-2",
                },
                {
                    "data": "user_ids",
                    "class": "font-small-2",
                },
                {
                    "data": "used_limit",
                    "class": "font-small-2",
                },
                {
                    "render": function(meta, type, row) {
                        return '<div class="status-options">\
                                             <div class="status-options">\
                                                <div class="d-inline-block selected mr-25">\
                                                   <div class="color-option border-warning">\
                                                      <div class="filloption bg-warning"></div>\
                                                   </div>\
                                                </div>\
                                                <span class="font-small-2 text-warning font-weight-bold d-inline-block">\
                                                Upcoming</span>\
                                             </div>\
                                          </div>';
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_start_date
                        } else {
                            return row.start_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_end_date
                        } else {
                            return row.end_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "data": "action",
                    orderable: false,
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            }
        });
        let expiredPromocodesTable = $('#tblExpiredPromocodes').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/promo-offers') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.promo_type = '3';
                    data.search = $("#search_promocode").val();
                }
            },
            "columns": [{
                    "data": "id",
                    "class": "font-small-2",
                    orderable: false,
                },
                {
                    "data": "title",
                    "class": "font-small-2",
                },
                {
                    "data": "promocode",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_amount",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_type",
                    "class": "font-small-2",
                },
                {
                    "data": "user_ids",
                    "class": "font-small-2",
                },
                {
                    "data": "used_limit",
                    "class": "font-small-2",
                },
                {
                    "render": function(meta, type, row) {
                        return '<div class="status-options">\
                                             <div class="status-options">\
                                                <div class="d-inline-block selected mr-25">\
                                                   <div class="color-option border-danger">\
                                                      <div class="filloption bg-danger"></div>\
                                                   </div>\
                                                </div>\
                                                <span class="font-small-2 text-danger font-weight-bold d-inline-block">\
                                                Expired</span>\
                                             </div>\
                                          </div>';;
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_start_date
                        } else {
                            return row.start_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_end_date
                        } else {
                            return row.end_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "data": "action",
                    orderable: false,
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            }
        });
        let allPromocodesTable = $('#tblAllPromocodes').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthChange": false,
            "searching": false,
            "order": [],
            "ajax": {
                "url": "{{ url('admin/promo-offers') }}",
                "type": "POST",
                "data": function(data) {
                    data._token = '{{ csrf_token() }}';
                    data.search = $("#search_promocode").val();
                }
            },
            "columns": [{
                    "data": "id",
                    "class": "font-small-2",
                    orderable: false,
                },
                {
                    "data": "title",
                    "class": "font-small-2",
                },
                {
                    "data": "promocode",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_amount",
                    "class": "font-small-2",
                },
                {
                    "data": "discount_type",
                    "class": "font-small-2",
                },
                {
                    "data": "user_ids",
                    "class": "font-small-2",
                },
                {
                    "data": "used_limit",
                    "class": "font-small-2",
                },
                {
                    "render": function(meta, type, row) {
                        let status = '-';
                        let cls = 'Info';
                        if(row.promo_type === 1) {
                            status = 'Active';
                            cls = 'success';
                        }
                        else if(row.promo_type === 2) {
                            status = 'Upcoming';
                            cls = 'warning';
                        }
                        else if(row.promo_type === 2) {
                            status = 'Expired';
                            cls = 'danger';
                        }
                        // return (row.status === 1 ? 'Active' : 'Inactive');
                        return '<div class="status-options">\
                                             <div class="status-options">\
                                                <div class="d-inline-block selected mr-25">\
                                                   <div class="color-option border-'+cls+'">\
                                                      <div class="filloption bg-'+cls+'"></div>\
                                                   </div>\
                                                </div>\
                                                <span class="font-small-2 text-'+cls+' font-weight-bold d-inline-block">\
                                                '+status+'</span>\
                                             </div>\
                                          </div>';
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_start_date
                        } else {
                            return row.start_date;
                        }
                    },
                },
                {
                    "class": "font-small-2",
                    "render": function(data, type, row) {
                        if (type == 'display') {
                            return row.display_end_date
                        } else {
                            return row.end_date;
                        }
                    },
                },
                {
                    "data": "action",
                    "class": "font-small-2",
                    orderable: false,
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-id', data.id);
            }
        });

</script>
@endsection
