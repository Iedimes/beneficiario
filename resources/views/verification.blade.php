<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>MUVH - VALIDACION CONSTANCIA</title>
  </head>
  <body>
      <div class="container">
          <img src="{{url('img/logofull.jpg')}}" class="img-fluid mx-auto d-block" alt="Image"/>
        @if (isset($bamper))
        <div class="card">
        <h5 class="card-header text-center">CONSTANCIA BENEFICIARIO</h5>
            <div class="card-body">
                <div class="card-body">
                    <h5 class="card-title text-center">BENEFICIARIO: {{  $bamper->PerNomPri  }} {{ $bamper ? $bamper->PerNomSeg : 'sin dato' }} {{ $bamper ? $bamper->PerApePri : 'sin dato' }} {{ $bamper ? $bamper->PerApeSeg : 'sin dato' }} @if (empty($casada))
                        {{ $bamper ? $bamper->PerApeCas : 'sin dato' }}@else DE {{ $bamper ? $bamper->PerApeCas : 'sin dato' }}@endif
                    </h5>
                </div>
                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item">CEDULA: {{ $bamper ? $bamper->PerCod: 'sin dato' }}</li>
                    <li class="list-group-item">PROYECTO: {{ $proyecto ? trim($proyecto->PylNom): 'sin dato' }}</li>
                    <li class="list-group-item">MANZANA: {{ $cuenta ? trim($cuenta->ManCod): 'sin dato' }}</li>
                    <li class="list-group-item">LOTE: {{ $cuenta ? trim($cuenta->VivLote): 'sin dato' }}</li>
                    <li class="list-group-item">CTA. CTE CTRAL: {{ $cuenta ? trim($cuenta->VivCtaCte): 'sin dato' }}</li>
                    <li class="list-group-item">RESOLUCION: {{$resolucion ? trim($resolucion->CliNrs): 'sin dato' }}</li>
                    <li class="list-group-item">FECHA RESOLUCION: {{ date('d/m/Y', strtotime($resolucion ? trim($resolucion->CliFRes): 'sin dato'))}}</li>
                    <li class="list-group-item">ACTA: {{ $resolucion ? trim($resolucion->CliNac): 'sin dato' }}</li>
                    <li class="list-group-item">FECHA CONTRATO: {{ date('d/m/Y', strtotime($contrato ? trim($contrato->CliFchCon): 'sin dato'))}}</li>


                </ul>
                <div class="card-body">
                    <h5 class="card-title text-center">VALIDO 90 DIAS</h5>
                </div>
                <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->

            </div>
        </div>
        @else
            <div class="card">
                <h5 class="card-header text-center">No existe el registro</h5>
            </div>
        @endif

      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

  </body>
</html>
