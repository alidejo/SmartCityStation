@extends('frontend.layouts.app')

@section('title', __('Query Measures'))

@section('content')
    <div class="container py-4">
        <div  style="margin-top: 35px; margin-left: 240px;">
            <!-- <div class="row justify-content-center"> -->
            <div class="row">
                <div class="col-12 col-sm-4 col-md-2">
                    <label>Tipo Variable: </label>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col-12 col-sm-4 col-md-2">
                    <div>
                        <select id="variables_type"></select>
                    </div>
                </div>
            </div><!--row--> 
            <div class="row">
                <div class="col-12 col-sm-4 col-md-2">
                    <button type="button" id="show_measures" class="btn btn-primary" style="margin-top: -71px;margin-left: 390px;position: relative;" onclick="showMeasures()">Ver Medida</button>
                </div>
            </div><!--row--> 
        </div>
    </div><!--container-->
@endsection



@section('script')
<script>

    function getVariableType(){

    console.log("Llego a getVariableType ... ");

    $.ajax({
        type: 'GET',
        url: "{{ route('frontend.variabletype.getvariabletype') }}",
        data: {
        _token: '{!! csrf_token() !!}',
        }, 
        contentType: 'application/json', 
        success: function(variablesType_json){

            var variablesType = JSON.parse(variablesType_json); // Parsing the json string.

            var variables_type = document.getElementById("variables_type");
            var nameType = '';
            var idType = 0;

            $.each(variablesType, function( index, value ) { 
            nameType = value.name;
            idType = index;
            var itemVariableType = document.createElement("option");
            itemVariableType.textContent = nameType;
            itemVariableType.value = nameType;
            variables_type.appendChild(itemVariableType);
            }); 
        },
        error: function (xhr, status, error) {
        var errorMessage = xhr.status + ': ' + xhr.statusText
        alert('Error - ' + errorMessage + ' status: ' + status + '  error: ' + error);
    }
    });
    }

    function showMeasures() {
    console.log("Click Sobre el Botón ...");
    }

    $(document).ready(function() {
        getVariableType();
    });
</script>
@endsection