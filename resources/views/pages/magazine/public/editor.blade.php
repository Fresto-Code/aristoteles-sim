@extends('layouts.app_magazine', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container bg-white p-5 rounded">
            <form id="editor_form" onsubmit="return upload(this);" method="POST" action="{{ route('magazine/inline/editor') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                    <div class="input-group mb-3">
                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} border-1"
                            placeholder="{{ __('judul') }}" type="text" name="title" value="{{ old('title') }}"
                            required autofocus>
                    </div>
                    @if ($errors->has('title'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                    <div class="input-group mb-3">
                        <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('deskripsi') }}"
                            name="description" value="{{ old('description') }}" required rows="7"></textarea>
                    </div>
                    @if ($errors->has('description'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-label" for="customFile">Pilih Cover</label>
                    <input type="file" class="form-control" id="customFile" name="cover_file" />
                </div>
                <div class="form-group">
                    <input name="writenMagazine" type="hidden">
                    <div class="bg-white" id="editor" style="height: 700px;"></div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-success" type="submit">Tambahkan</button>
                </div>
            </form>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>

    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>

    <!-- Initialize Quill editor -->

    <!-- Initialize editor with toolbar
                                                        -->
    <script>
        function upload(scope) {
            // Populate hidden form on submit
            var writenMagazine = document.querySelector('input[name=writenMagazine]');
            writenMagazine.value = quill.root.innerHTML

            console.log("Submitted", $(form).serialize(), $(form).serializeArray());

        }
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],

            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction

            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],

            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            ['image', 'formula'], // add's image support
        ];

        var quill = new Quill('#editor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    </script>
@endsection
