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
        <h5 class="card-header text-center">CONSTANCIA BENEFICIARIOS</h5>
            <div class="card-body">
                <div class="card-body">
                    <h5 class="card-title text-center">TITULAR: {{  $bamper->PerNomPri  }} {{ $bamper->PerNomSeg }} {{ $bamper->PerApePri }} {{ $bamper->PerApeSeg }}
                        @if (empty($casada))
                            {{ $bamper->PerApeCas }}
                        @else
                            DE {{ $bamper->PerApeCas }}
                        @endif
                    </h5>
                    <h5 class="card-title text-center"> CEDULA: {{ $bamper->PerCod }}</h3>
                    <h5 class="card-title text-center">CONYUGE: {{  $nomconyuge->PerNomPri  }} {{ $nomconyuge->PerNomSeg }} {{ $nomconyuge->PerApePri }} {{ $nomconyuge->PerApeSeg }}
                    <h5 class="card-title text-center"> CEDULA: {{ $conyuge->SolPerCge }}</h3>

                    </h5>

                </div>
                <ul class="list-group list-group-flush text-center">
                    <li class="list-group-item"></li>
                    <li class="list-group-item">PROYECTO: {{ trim($proyecto->PylNom) }}</li>
                    <li class="list-group-item">MANZANA: {{ trim($cuenta->ManCod) }}</li>
                    <li class="list-group-item">LOTE: {{ trim($cuenta->VivLote) }}</li>
                    <li class="list-group-item">CTA. CTE CTRAL: {{ trim($cuenta->VivCtaVer) }}</li>
                    <li class="list-group-item">RESOLUCION: {{ trim($resolucion->CliNrs) }}</li>
                    <li class="list-group-item">FECHA RESOLUCION: {{ date('d/m/Y', strtotime(trim($resolucion->CliFRes)))}}</li>
                    <li class="list-group-item">ACTA: {{ $resolucion->CliNac ? trim($resolucion->CliNac): '' }}</li>
                    <li class="list-group-item">FECHA CONTRATO: {{ date('d/m/Y', strtotime(trim($contrato->CliFchCon)))}}</li>
                    <li class="list-group-item">FECHA IMPRESION: {{ date('d/m/Y', strtotime(trim($impresion->fecha_impresion)))}}</li>
                    <li class="list-group-item"></li>
                </ul>
                <div class="card-body">
                    <h5 class="card-title text-center">VALIDO 90 DIAS</h5>
                </div>
                {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}

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
