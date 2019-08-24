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
                            <th>Позиция</th>
                            <th>Наименование и техническая характеристика</th>
                            <th>Тип, марка, обозначение документа, опросного листа</th>
                            <th>Производитель</th>
                            <th>Единица измерения</th>
                            <th>Количество</th>
                            <th>Масса единицы</th>
                            <th>Цена единицы</th>
                            <th>Сумма</th>
                            <th>Цена монтажа(единицы)</th>
                            <th>Сумма за монтаж</th>
                            <th>Общая сумма</th>
                            <th>Примечание</th>
                            <th width="100px">Действие</th>
                        </tr>
                        @for($i=1;$i<=count($recognitionData);$i++)
                            <tr id="{{'userProductRow_'.$recognitionData[$i][0]}}">
                                <td id="productPozition">{{$i}}</td>
                                <td id="productName"><a href="" class="update" data-name="pName" data-type="select" @if(!empty($recognitionData[$i][2])) data-source="{{json_encode($recognitionData[$i][2])}}" @endif  data-pk="{{ $recognitionData[$i][0] }}" >{{ $recognitionData[$i][0] }}</a></td>
                                <td id="productType"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productMaker"><input type="text" class="form-control text-center" value=""></td>
                                <td id="productPrice"><input type="text" class="form-control text-center" value=""></td>
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
                mode:'inline',
                showbuttons:false,
                // url: '/update-user',
                display: function(value, sourceData) {
                    if (value) {
                        $(this).html(sourceData[value].text.substr(0,sourceData[value].text.indexOf('|')));

                        var selectedType = document.createElement("input");
                        selectedType.setAttribute("type","text");
                        selectedType.setAttribute("class","form-control text-left");
                        var typeText=sourceData[value].text.substr(sourceData[value].text.indexOf('|')+1,sourceData[value].text.lastIndexOf('|')-(sourceData[value].text.indexOf('|')+1));
                        typeText=typeText.substr(0,typeText.indexOf('|'));
                        selectedType.setAttribute("value",typeText.toString());
                        this.parentElement.parentElement.childNodes[4].childNodes[0].replaceWith(selectedType);

                        var selectedMaker = document.createElement("input");
                        selectedMaker.setAttribute("type","text");
                        selectedMaker.setAttribute("class","form-control text-left");
                        var makerText=typeText.substr(0,typeText.indexOf('|'));
                        selectedMaker.setAttribute("value",makerText.toString());
                        this.parentElement.parentElement.childNodes[6].childNodes[0].replaceWith(selectedMaker);

                        var selectedPrice= document.createElement("input");
                        selectedPrice.setAttribute("type","text");
                        selectedPrice.setAttribute("class","form-control text-center");
                        selectedPrice.setAttribute("value",sourceData[value].text.substr(sourceData[value].text.indexOf('|')+1,sourceData[value].text.lastIndexOf('|')-(sourceData[value].text.indexOf('|')+1)));
                        this.parentElement.parentElement.childNodes[8].nextSibling.childNodes[0].replaceWith(selectedPrice);


                    }
                }
            });
            $('.update').on('save', function(e, params) {
            });
        });
    </script>
@endsection
