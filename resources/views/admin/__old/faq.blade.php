@extends('layouts.app')
@section('styles')
    <style type="text/css">
        .ck-content {
            height: 300px;
        }
    </style>
@endsection
@section('content')
<div class="content-wrapper pt-1">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">FAQ</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:">Pages</a>
                            </li>
                            <li class="breadcrumb-item">FAQ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-body">
        <section id="horizontal-vertical">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <h3>FAQ</h3>
                                <form class="form" method="post" id="faqForm">
                                    @csrf
                                    <input type="hidden" name="page" id="page" value="{{ $page->page }}">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" id="title" class="form-control" placeholder="Title" name="title" value="<?= $page->title ?? null ?>">
                                        </div>
                                    </div>
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" row="5">{{ $page->description }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    ClassicEditor.create( document.querySelector( '#description' ), {
    })
    .catch(error => {
        console.error( error );
    });
</script>
@endsection
