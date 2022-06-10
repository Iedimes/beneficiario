<table style="width:100%; border:0px; text-align:center;">
    <tr>

        <td style="font-size:10px;font-weight:bold;">MISIÓN. Somos la institución rectora de las políticas públicas de vivienda, urbanismo y del hábitat, gestionando planes, programas
    y acciones que contribuyan a mejorar la calidad de vida de los habitantes de la República del Paraguay.</td>

    </tr>

</table><br>

<p style="text-align:center;font-size:20px;"><b>DIRECCION GENERAL SOCIAL</b><hr/></p>
<p style="text-align:center;font-size:25px;"><b>CONSTANCIA</b></p>
<br>

<p style="text-align: justify;"><b>El Ministerio de Urbanismo, Vivienda y Hábitat</b> certifica que el <b>Sr./Sra. {{ $bamper ? $bamper->PerNom : 'sin dato' }}</b> con <b>C.I. No. {{ $beneficiario ? $beneficiario->PerCod: 'sin dato' }}</b> es adjudicatario/a de la
 vivienda individualizada como manzana <b>{{ $cuenta ? $cuenta->ManCod: 'sin dato' }}</b>, <b>lote {{ $cuenta ? $cuenta->VivLote: 'sin dato' }}</b> del proyecto <b> {{ $proyecto ? $proyecto->PylNom: 'sin dato' }}</b>, con
 <b>Cuenta Corriente Catastral No. {{ $cuenta ? $cuenta->VivCtaCte: 'sin dato' }}</b>, de conformidad a la <b>Resolución No. {{$resolucion ? $resolucion->CliNrs : 'sin dato' }}</b>, <b>Acta {{ $resolucion ? $resolucion->CliNac: 'sin dato' }}</b> de fecha <b>{{ date('d/m/Y', strtotime($resolucion ? $resolucion->CliFRes: 'sin dato'))}} </b>,
  contrato de compra venta de fecha <b>{{ date('d/m/Y', strtotime($contrato ? $contrato->CliFchCon: 'sin dato'))}}</b> y Estado de cuenta de la Dirección de Administración y Recuperación de Cartera de fecha <b>{{ date('d/m/Y') }}</b></p>

<p style="text-align: justify;">Esta constancia es gratuita, válida por 90 días, para su presentación exclusiva ante <strong>ANDE/ESSAP</strong></p>



<br><br>
<p style="text-align: justify;">Fecha de Impresión: {{ date('d/m/Y') }}</p>
<img src="data:image/png;base64, {{ base64_encode($valor) }}" style="position: relative; left:550px;" alt="">
<br><br><br><br><br><br><br><br><br><br>

