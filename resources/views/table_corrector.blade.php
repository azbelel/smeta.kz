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
                            <th>Цена</th>
                            <th width="100px">Действие</th>
                        </tr>
                        @foreach($recognitionData as $line)
                            <tr>
                                <td><a href="" class="update" data-name="name" data-type="select" @if(!empty($line[2])) data-source="{{json_encode($line[2])}}" @endif  data-pk="{{ $line[0] }}" >{{ $line[0] }}</a></td>
                                <td><a href="" class="update" data-name="name"  data-type="select" data-pk="{{ $line[1] }}" >{{ $line[1] }}</a></td>
                                <td><div id="price"></div></td>
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
        window.onload=(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.update').editable({
                mode:'inline',
                showbuttons:false,
                // url: '/update-user',
            });
            $('.update').on('save', function(e, params) {
                console.log(params.newValue);
            });
        });
    </script>
@endsection
