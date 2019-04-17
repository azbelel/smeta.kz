@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session()->get('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">File Upload</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('file.upload') }}" aria-label="{{ __('Upload') }}">
                            @csrf
                            <div class="form-group row ">
                                <label for="title" class="col-sm-4 col-form-label text-md-right">{{ __('File Upload') }}</label>
                                <div class="col-md-6">
                                    <div id="file" class="dropzone"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pages" class="col-sm-4 col-form-label text-md-right">{{__('Номера страниц')}}</label>
                                <input type="radio" class="" name="pages" value="0" checked>Все</input>
                                <input type="radio" class="" name="pages" value="1">Номер</input>
                                 c <input type="text" class="" size="2" maxlength="2" disabled> по <input type="text" class="" size="2" maxlength="2" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Проверка') }}
                                    </button>
                                    <input type="hidden" name="file_toParse" id="file_toParse" value="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.onload=(function(){
            var drop = new Dropzone('#file', {
                createImageThumbnails: false,
                addRemoveLinks: true,
                url: "{{ route('upload') }}",
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
            });
            drop.on("success", function(file, response) {
                $('#file_toParse').val(response.filename);
            });

        });
    </script>
@endsection