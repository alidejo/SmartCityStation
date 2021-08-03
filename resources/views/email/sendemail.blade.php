<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table,tr,td,th{
            border: 1px solid;
            padding: 15px;
        }
        table{
            border-collapse: collapse;
            
        }
    </style>
</head>
<body>
    <div class=" w-auto">
        <h1></h1>
        <table class="table ">
          <thead>
            <tr>
                <th scope="col">Dispositivo</th>
                <th>Fecha de Registro</th>
                <th>Hora de registro</th>
                <th scope="col">Tipo de variables</th>
                <th scope="col">Dato</th>
                <th scope="col">Umbral</th>
                <th scope="col">Diferencia</th>
            </tr>
        </thead>
        <tbody>
                {{-- if is array the variable measuresAlerts make continue... --}}
                @if (is_array($measuresAlerts))
                {{-- travels array this position 1 --}}
                    @for ($row = 1; $row < count($measuresAlerts); $row++)
                    <tr>
                        {{-- echo content this array --}}
                        @for ($col = 0; $col < 7; $col++)
                    
                            <td>{{$measuresAlerts[$row][$col]}}</td>
                
                        @endfor
                    </tr>
                    @endfor
                @endif

            
        </tbody>
        </table>
    </div>
   
</body>
</html>