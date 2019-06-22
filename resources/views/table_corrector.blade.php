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
                            <th>Наименование и техническая характеристика</th>
                            <th>Тип, марка, обозначение документа, опросного листа</th>
                            <th width="100px">Действие</th>
                        </tr>
                        @foreach($recognitionData as $line)
                            <tr>
                                <td><a href="" class="update" data-name="name" data-type="text" data-pk="{{ $line[0] }}" data-title="Enter name">{{ $line[0] }}</a></td>
                                <td><a href="" class="update" data-name="name" data-type="text" data-pk="{{ $line[1] }}" data-title="Enter name">{{ $line[1] }}</a></td>
{{--                                @foreach($line as $cell)--}}

{{--                                @endforeach--}}
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
