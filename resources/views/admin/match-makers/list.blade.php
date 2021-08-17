@extends('layouts.app')
@section('content')
<section id="horizontal-vertical" class="user-section">
    <form action="{{ url('admin/match-makers/save') }}" method="POST">
        @csrf
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
                                                <img src="{{ asset($item->image_url ?? 'assets/images/coffee-cup-icon.svg')}}"
                                                    width="60" height="60">
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <input name="match_maker[{{$k}}][id]" value="{{ $item->id }}" type="hidden" />
                                                            <input type="text" class="form-control" name="match_maker[{{$k}}][question]"
                                                                placeholder="Enter you question here.."
                                                                value="{{ $item->question }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 col-mb-6">
                                                        <div class="form-group">
                                                            <label>ATTRIBUTE LINK</label>
                                                            <select class="ui search dropdown w-100" name="match_maker[{{$k}}][type]">
                                                                <option value="origin"
                                                                    {{ $item->type == 'origin' ? 'selected' : '' }}>
                                                                    Origin</option>
                                                                <option value="type"
                                                                    {{ $item->type == 'type' ? 'selected' : '' }}>
                                                                    Roaster Type</option>
                                                                <option value="level"
                                                                    {{ $item->type == 'level' ? 'selected' : '' }}>
                                                                    Roaster Level</option>
                                                                <option value="process"
                                                                    {{ $item->type == 'process' ? 'selected' : '' }}>
                                                                    Process</option>
                                                                <option value="characteristic"
                                                                    {{ $item->type == 'characteristic' ? 'selected' : '' }}>
                                                                    Characteristic</option>
                                                                <option value="coffee_type"
                                                                    {{ $item->type == 'coffee_type' ? 'selected' : '' }}>
                                                                    Product Type</option>
                                                                <option value="best_for"
                                                                    {{ $item->type == 'best_for' ? 'selected' : '' }}>
                                                                    Best For</option>
                                                                <option value="brand"
                                                                    {{ $item->type == 'brand' ? 'selected' : '' }}>Brand
                                                                </option>
                                                                <option value="seller"
                                                                    {{ $item->type == 'seller' ? 'selected' : '' }}>
                                                                    Seller</option>
                                                                <option value="price"
                                                                    {{ $item->type == 'price'? 'selected' : '' }}>Price
                                                                </option>
                                                                <option value="weight"
                                                                    {{ $item->type == 'weight'? 'selected' : '' }}>
                                                                    Weight</option>

                                                                {{-- <option value="coffee_flavor" {{ $item->type == 'coffee_flavor' ? 'selected' : '' }}>Coffee
                                                                flavor</option>
                                                                <option value="grind"
                                                                    {{ $item->type == 'grind' ? 'selected' : '' }}>Grind
                                                                </option>
                                                                <option value="price"
                                                                    {{ $item->type == 'price'? 'selected' : '' }}>Price
                                                                </option> --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-mb-6">
                                                        <div class="form-group">
                                                            <label>MIN SELECTION</label>
                                                            <select class="ui search dropdown w-100" name="match_maker[{{$k}}][min_select]">
                                                                <option value="0">Select</option>
                                                                @for ($i = 1; $i <= 4; $i++) <option value="{{ $i }}"
                                                                    {{ $item->min_select == $i ? 'selected' : '' }}>
                                                                    {{ $i }}</option>
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
        <div class="row justify-content-end">
            <div class="col-md-6">
                <button type="submit"
                    class="btn btn-primary font-weight-bold btn-lg w-100 waves-effect waves-light">SAVE</button>
            </div>
        </div>
    </form>
</section>
@endsection
