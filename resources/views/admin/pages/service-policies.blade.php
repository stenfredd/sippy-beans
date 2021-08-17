@extends('layouts.app')

@section('styles')
<style type="text/css">
    .ck-content {
        height: 300px;
    }
</style>
@endsection
@section('content')
<form action="{{ url('admin/service-policies') }}" method="POST">
    @csrf
    <input type="hidden" name="page" value="contact-us">
    <input type="hidden" name="title" value="Contact US">
    <section class="snow-editor">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">Contact US</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            {{-- <textarea id="editor-container" name="description" style="width: 100%;">{{ $contact_us->description }}</textarea>
                            --}}
                            <textarea id="contact_us_editor" class="editor_cls" name="description"
                                row="5">{{ $contact_us->description }}</textarea>
                            <div class="text-right">
                                <button type="submit"
                                    class="btn btn-primary font-weight-bold btn-lg mt-1 waves-effect waves-light px-1"
                                    data-dismiss="modal">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<form action="{{ url('admin/service-policies') }}" method="POST">
    @csrf
    <input type="hidden" name="page" value="privacy-policies">
    <section class="snow-editor">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">PRIVACY POLICY</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            {{-- <div id="editor-container-a">
                                {{ $privacy_policy->description ?? '-' }}
                        </div> --}}
                        <textarea id="privacy_policy_editor" class="editor_cls" name="description"
                            row="5">{{ $privacy_policy->description }}</textarea>
                        <div class="text-right">
                            <button type="submit"
                                class="btn btn-primary font-weight-bold btn-lg mt-1 waves-effect waves-light px-1"
                                data-dismiss="modal">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</form>
<form action="{{ url('admin/service-policies') }}" method="POST">
    @csrf
    <input type="hidden" name="page" value="terms-conditions">
    <section class="snow-editor">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">TERMS & CONDITIONS</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            {{-- <div id="editor-container-b">
                                {{ $terms_conditions->description ?? '-' }}
                        </div> --}}
                        <textarea id="terms_conditions_editor" class="editor_cls" name="description"
                            row="5">{{ $terms_conditions->description }}</textarea>
                        <div class="text-right">
                            <button type="submit"
                                class="btn btn-primary font-weight-bold btn-lg mt-1 waves-effect waves-light px-1"
                                data-dismiss="modal">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</form>
<form action="{{ url('admin/service-policies') }}" method="POST">
    @csrf
    <input type="hidden" name="page" value="faq">
    <section class="snow-editor">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-1 border-bottom">
                        <h4 class="card-title">FAQs</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                        <textarea id="faq_editor" class="editor_cls" name="description"
                            row="5">{{ $faqs->description }}</textarea>
                        <div class="text-right">
                            <button type="submit"
                                class="btn btn-primary font-weight-bold btn-lg mt-1 waves-effect waves-light px-1"
                                data-dismiss="modal">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</form>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
<script type="text/javascript">
    ClassicEditor.create( document.querySelector( '#contact_us_editor' ), {
    })
    .catch(error => {
        console.error( error );
    });
    ClassicEditor.create( document.querySelector( '#privacy_policy_editor' ), {
    })
    .catch(error => {
        console.error( error );
    });
    ClassicEditor.create( document.querySelector( '#terms_conditions_editor' ), {
    })
    .catch(error => {
        console.error( error );
    });
    ClassicEditor.create( document.querySelector( '#faq_editor' ), {
    })
    .catch(error => {
    console.error( error );
    });
</script>
@endsection
