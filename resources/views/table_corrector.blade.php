@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row col-md-12">
                @if(session()->get('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row col-md-12">
                    <table class="table table-bordered">
                        <tr class="text-center align-middle">
                            <th>Позиция</th>
                            <th>Наименование и техническая характеристика</th>
                            <th>Тип, марка, обозначение документа, опросного листа</th>
                            <th>Производитель</th>
                            <th>Единица измерения</th>
                            <th>Количество</th>
                            <th>Масса единицы</th>
                            <th>Цена единицы</th>
                            <th>Сумма</th>
                            <th>Цена монтажа (единицы)</th>
                            <th>Сумма за монтаж</th>
                            <th>Общая сумма</th>
                            <th>Примечание</th>
                            <th width="100px">Действие</th>
                        </tr>
                        @for($i=1;$i<=count($recognitionData);$i++)
                            <tr id="{{'userProductRow_'.$recognitionData[$i][0]}}">
                                <td id="productPozition" class="text-center">{{$i}}</td>
                                <td id="productName"><a href="" class="update" data-name="pName" data-type="select" @if(!empty($recognitionData[$i][2])) data-source="{{json_encode($recognitionData[$i][2])}}" @endif  data-pk="{{ $recognitionData[$i][0] }}" >{{ $recognitionData[$i][0] }}</a></td>
                                <td id="productType"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productMaker"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productUnit"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productAmount"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productUnitWeight"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productPrice"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productSumm"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productInstallPrice"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productInstallSumm"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productAllSumm"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productAdditionals"><input type="text" class="form-control text-center" value=""></td>
                                <td class="text-center" id="productRowDelete"><button class="btn btn-danger btn-sm">Delete</button></td>
                            </tr>
                        @endfor
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
                mode:'popup',
                showbuttons:false,
                // url: '/update-user',
                display: function(value, sourceData) {
                    if (value) {
                        $(this).html(sourceData[value].text.split('|')[0]);
                        this.parentElement.parentElement.children[2].children[0].value=sourceData[value].text.split('|')[1];
                        this.parentElement.parentElement.children[3].children[0].value=sourceData[value].text.split('|')[2];
                        this.parentElement.parentElement.children[7].children[0].value=sourceData[value].text.split('|')[3];
                    }
                },
                width:350
            });
            $('.update').on('save', function(e, params) {
            });
        });
    </script>
@endsection
