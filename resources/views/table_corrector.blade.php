@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row col-md-12">
                @if(session()->get('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>Данные из загруженного файла</th>
                            <th>Данные из прайса</th>
                            <th width="100px">Действие</th>
                        </tr>

                        @foreach($recognitionData as $line)
                            <tr>
                                @foreach($line as $cell)
                                    <td><a href="" class="update" data-name="name" data-type="text" data-pk="{{ $cell }}" data-title="Enter name">{{ $cell }}</a></td>
                                @endforeach
                                <td><button class="btn btn-danger btn-sm">Delete</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.update').editable({
            url: '/update-user',
            type: 'text',
            pk: 1,
            name: 'name',
            title: 'Enter name'
        });

    </script>
@endsection
