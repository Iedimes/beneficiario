<br>
<p style="text-align:center;font-size:18px;"><b>Dirección General Social</b></p>
<hr>
<p style="text-align:center;font-size:30px; font-family:Arial, Helvetica, sans-serif;"><b>CONSTANCIA</b></p>
<p style="text-align: justify;"><b>El Ministerio de Urbanismo, Vivienda y Hábitat</b> certifica que el <b>Sr./Sra. {{ $bamper ? $bamper->PerNomPri : 'sin dato' }} {{ $bamper ? $bamper->PerNomSeg : 'sin dato' }} {{ $bamper ? $bamper->PerApePri : 'sin dato' }} {{ $bamper ? $bamper->PerApeSeg : 'sin dato' }} @if (empty($cas))
    {{ $bamper ? $bamper->PerApeCas : 'sin dato' }}
@else
 DE {{ $bamper ? $bamper->PerApeCas : 'sin dato' }}
@endif</b> con <b>C.I. N°. {{ $beneficiario ? $beneficiario->PerCod: 'sin dato' }} </b> es adjudicatario/a de la
 vivienda individualizada como manzana <b>{{ $cuenta ? trim($cuenta->ManCod): 'sin dato' }}</b>, <b>lote {{ $cuenta ? trim($cuenta->VivLote): 'sin dato' }}</b> del proyecto <b> {{ $proyecto ? trim($proyecto->PylNom): 'sin dato' }}</b>, con
 <b>Cuenta Corriente Catastral N°. {{ $cuenta ? trim($cuenta->VivCtaCte): 'sin dato' }}</b>, de conformidad a la <b>Resolución N°. {{$resolucion ? trim($resolucion->CliNrs): 'sin dato' }}</b>, <b>Acta {{ $resolucion ? trim($resolucion->CliNac): 'sin dato' }}</b> de fecha <b>{{ date('d/m/Y', strtotime($resolucion ? trim($resolucion->CliFRes): 'sin dato'))}} </b>,
  contrato de compra venta de fecha <b>{{ date('d/m/Y', strtotime($contrato ? trim($contrato->CliFchCon): 'sin dato'))}}</b> y Estado de cuenta de la Dirección de Administración y Recuperación de Cartera de fecha <b>{{ date('d/m/Y') }}</b></p>

<p style="text-align: justify;">Esta constancia es gratuita, válida por 90 días, para su presentación exclusiva ante <strong>ANDE/ESSAP</strong></p>



<br><br>
<p style="text-align: justify;">Fecha de Impresión: {{ date('d/m/Y') }}</p>
<img src="data:image/png;base64, {{ base64_encode($valor) }}" style="position: relative; left:550px;" alt="">
<br><br><br><br><br><br><br><br><br><br>

