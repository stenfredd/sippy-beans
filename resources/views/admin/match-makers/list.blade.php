@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom pb-1">
                    <h4 class="card-title">MatchMakers</span>
                </div>
                <div>
                    <div class="card-content">
                        <div class="table-responsive beans-tabal pagenation-row">
                            <table class="table table-borderless table-striped table-pagenation">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center w-20">IMAGE</th>
                                        <th>QUESTION & SELECTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($match_makers as $k => $item)
                                        <tr>
                                            <td class="font-medium-4">{{ $k + 1 }}</td>
                                            <td class="service-category-img text-center">
                                                <img src="{{ asset($item->image_url ?? 'assets/images/coffee-cup-icon.svg')}}" width="60"
                                                    height="60">
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="question"
                                                                placeholder="Enter you question here.." value="{{ $item->question }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-mb-6">
                                                        <div class="form-group">
                                                            <label>ATTRIBUTE LINK</label>
                                                            <select class="ui search dropdown w-100">
                                                                <option value="brand" {{ $item->type == 'brand' ? 'selected' : '' }}>Brand</option>
                                                                <option value="characteristic" {{ $item->type == 'characteristic' ? 'selected' : '' }}>Characteristic</option>
                                                                <option value="coffee_flavor" {{ $item->type == 'coffee_flavor' ? 'selected' : '' }}>Coffee flavor</option>
                                                                <option value="grind" {{ $item->type == 'grind' ? 'selected' : '' }}>Grind</option>
                                                                <option value="level" {{ $item->type == 'level' ? 'selected' : '' }}>Level</option>
                                                                <option value="origin" {{ $item->type == 'origin' ? 'selected' : '' }}>Origin</option>
                                                                <option value="process" {{ $item->type == 'process' ? 'selected' : '' }}>Process</option>
                                                                <option value="seller" {{ $item->type == 'seller' ? 'selected' : '' }}>Seller</option>
                                                                <option value="price" {{ $item->type == 'price'? 'selected' : '' }}>Price</option>
                                                                <option value="type" {{ $item->type == 'type' ? 'selected' : '' }}>Roaster Type</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-mb-6">
                                                        <div class="form-group">
                                                            <label>MIN SELECTION</label>
                                                            <select class="ui search dropdown w-100">
                                                                <option value="0">Select</option>
                                                                @for ($i = 1; $i <= 4; $i++)
                                                                    <option value="{{ $i }}" {{ $item->min_select == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
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
