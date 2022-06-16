<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Beneficiario\BulkDestroyBeneficiario;
use App\Http\Requests\Admin\Beneficiario\DestroyBeneficiario;
use App\Http\Requests\Admin\Beneficiario\IndexBeneficiario;
use App\Http\Requests\Admin\Beneficiario\StoreBeneficiario;
use App\Http\Requests\Admin\Beneficiario\UpdateBeneficiario;
use App\Models\Beneficiario;
use App\Models\Bamper;
use App\Models\Proyecto;
use App\Models\Resolucion;
use App\Models\Ctacte;
use App\Models\Programa;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;




class BeneficiarioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexBeneficiario $request
     * @return array|Factory|View
     */
    public function index($PerCod)
    {
        //menor a 3 cuotas 1000222
        //mayor a 3 cuotas 1018717
        //$PerCod='1000222';


        $prmcli = Beneficiario::where('PerCod', $PerCod)->first();


        if (!empty($prmcli)) { //Si exite beneficiario

            $beneficiario = Beneficiario::where('CliEsv', 1)
            ->where('CliCMor','<=', 3)
            ->where('PerCod', $PerCod)->first();

            //$proyecto =

            if (!empty($beneficiario)) { //Si beneficiario cumple con los requisitos

                $bamper = Bamper::where('PerCod', $PerCod)->select('PerNom', 'PerCod')->first();

                $proyecto = Proyecto::where('PylCod', $beneficiario['PylCod'])->first();

                $resolucion = Resolucion::where('PerCod', $beneficiario['PerCod'])
                                        ->where('PylCod', $beneficiario['PylCod'])
                                        ->where('CliNop', $beneficiario['CliNop'])
                                        ->where('CliSec', $beneficiario['CliSec'])
                                        ->select('CliFRes', 'CliNrs', 'CliNac')->first();

                $cuenta = Ctacte::where('PylCod', $beneficiario['PylCod'])
                                  ->where('ManCod', $beneficiario['ManCod'])
                                  ->where('VivLote', $beneficiario['VivLote'])
                                  ->where('VivBlo', $beneficiario['VivBlo'])
                                  ->first();

                $contrato =Resolucion::where('PerCod', $beneficiario['PerCod'])
                                    ->where('PylCod', $beneficiario['PylCod'])
                                    ->where('CliNop', $beneficiario['CliNop'])
                                    ->where('CliSec', $beneficiario['CliSec'])
                                    ->where('CliTMov', 1)
                                    ->where('CliElaCon' ,'=', 'S')
                                    ->select('CliFchCon')->first();

                $programa = Programa::where('PylTip', $proyecto['PylTip'])
                                    ->first();

                return [
                    //'prmcli' => $prmcli,
                    'message' => 'Exito!!!',
                    'cedula' => $bamper['PerCod'] ? trim($bamper['PerCod']) : 'No tiene beneficiario Asociado',
                    'titular' => $bamper['PerNom'] ? trim($bamper['PerNom']) : 'No tiene beneficiario Asociado',
                    'codigo' => trim($proyecto['PylCod']),
                    'proyecto' => trim($proyecto['PylNom']),
                    'resolucion' => $resolucion ? trim($resolucion['CliNrs']) : 'No tiene nro de resolución asociada',
                    // 'resolucion' => '105',
                    'fresolucion' => $resolucion ? date('d/m/Y', strtotime($resolucion['CliFRes'])) : 'No tiene fecha de resolución',
                    // 'fresolucion' => '25/08/2011',
                    'actanro' => $resolucion ? trim($resolucion['CliNac']) : 'No tiene nro acta asociado',
                    // 'actanro' => '1200',
                    'cuenta' => $cuenta ? trim($cuenta['VivCtaCte']) : 'No tiene dato en cuenta corriente catastral',
                    // 'cuenta' => 'KL/07',
                    'manzana' => $cuenta ? trim($cuenta['ManCod']) : 'No tiene dato en manzana',
                    // 'manzana' => '10',
                    'lote' => $cuenta ? trim($cuenta['VivLote']) : 'No tiene dato en lote',
                    // 'lote' => '32',
                    'contrato' => $contrato ? date('d/m/Y', strtotime($contrato['CliFchCon'])) : 'No tiene Fecha de contrato',
                    // 'contrato' => '16/02/2010',
                    'programa' => trim($programa['PylTipDes']),
                    'imprimir' => true

                ];

            }elseif($prmcli['CliEsv'] != 1){

                return [
                    'message' => 'No cumple con los requisitos para la impresión de constancia',
                    'error' => 'No cumple con los requisitos para la impresión de constancia'

                ];



            }else
            { //Si es beneficiario y no cumple con los requisitos

                 $mensaje =  $prmcli['CliCMor'] > 3 && $prmcli['CliEsv'] != 1 ? 'Cuota Vencida y Estado No Vigente'  : ($prmcli['CliCMor'] > 3 ? 'Cuota Vencida' : 'Estado No Vigente');
                 $bamper = Bamper::where('PerCod', $PerCod)->select('PerCod','PerNom')->first();
                 $proyecto = Proyecto::where('PylCod', $prmcli['PylCod'])->first();

                $resolucion = Resolucion::where('PerCod', $prmcli['PerCod'])
                                         ->where('PylCod', $prmcli['PylCod'])
                                         ->where('CliNop', $prmcli['CliNop'])
                                         ->where('CliSec', $prmcli['CliSec'])
                                         ->select('CliFRes', 'CliNrs', 'CliNac')->first();

                 $cuenta = Ctacte::where('PylCod', $prmcli['PylCod'])
                                   ->where('ManCod', $prmcli['ManCod'])
                                   ->where('VivLote', $prmcli['VivLote'])
                                   ->where('VivBlo', $prmcli['VivBlo'])
                                   ->first();

                 $contrato =Resolucion::where('PerCod', $prmcli['PerCod'])
                                     ->where('PylCod', $prmcli['PylCod'])
                                     ->where('CliNop', $prmcli['CliNop'])
                                     ->where('CliSec', $prmcli['CliSec'])
                                     ->where('CliTMov', 1)
                                     ->where('CliElaCon' ,'=', 'S')
                                     ->select('CliFchCon')->first();

                 $programa = Programa::where('PylTip', $proyecto['PylTip'])
                                     ->first();
                return [


                    'message' => $mensaje,
                    'cedula' => $bamper['PerCod'] ? trim($bamper['PerCod']) : 'No tiene beneficiario Asociado',
                    'titular' => $bamper['PerNom'] ? trim($bamper['PerNom']) : 'No tiene beneficiario Asociado',
                    'codigo' => trim($proyecto['PylCod']),
                    'proyecto' => trim($proyecto['PylNom']),
                    'resolucion' => $resolucion ? trim($resolucion['CliNrs']) : 'No tiene nro de resolución asociada',
                    // 'resolucion' => '105',
                    'fresolucion' => $resolucion ? date('d/m/Y', strtotime($resolucion['CliFRes'])) : 'No tiene fecha de resolución',
                    // 'fresolucion' => '25/08/2011',
                    'actanro' => $resolucion ? trim($resolucion['CliNac']) : 'No tiene nro acta asociado',
                    // 'actanro' => '1200',
                    'cuenta' => $cuenta ? trim($cuenta['VivCtaCte']) : 'No tiene dato en cuenta corriente catastral',
                    // 'cuenta' => 'KL/07',
                    'manzana' => $cuenta ? trim($cuenta['ManCod']) : 'No tiene dato en manzana',
                    // 'manzana' => '10',
                    'lote' => $cuenta ? trim($cuenta['VivLote']) : 'No tiene dato en lote',
                    // 'lote' => '32',
                    'contrato' => $contrato ? date('d/m/Y', strtotime($contrato['CliFchCon'])) : 'No tiene Fecha de contrato',
                    // 'contrato' => '16/02/2010',
                    'programa' => trim($programa['PylTipDes']),
                    'imprimir' => false,

                ];
            }

        }else{ //Si no exite beneficiario, lanza mensaje, sin datos
            return [
                'message' => 'No es beneficiario',
                'error' => 'No es beneficiario'

            ];
        }

    }

    public function verificacion($cedula)
    {

        //return $cedula;
        /*$task = Task::where('certificate_pin', $key)
            //->select('name', 'last_name', 'government_id', 'farm', 'account', 'amount', 'state_id', 'city_id', 'created_at')
            ->first();*/
        $bamper = Bamper::where('PerCod', $cedula)->first();
        $cas = Bamper::where('PerCod', $cedula)->select('PerApeCas')->first();
        $casada = $cas ? trim($cas['PerApeCas']) : 'No tiene apellido de casada/o';
        $beneficiario = Beneficiario::where('CliEsv', 1)
            ->where('CliCMor','<=', 3)
            ->where('PerCod', $cedula)->first();
        $proyecto = Proyecto::where('PylCod', $beneficiario['PylCod'])->first();


                $resolucion = Resolucion::where('PerCod', $beneficiario['PerCod'])
                                        ->where('PylCod', $beneficiario['PylCod'])
                                        ->where('CliNop', $beneficiario['CliNop'])
                                        ->where('CliSec', $beneficiario['CliSec'])
                                        ->select('CliFRes', 'CliNrs', 'CliNac')->first();

                $cuenta = Ctacte::where('PylCod', $beneficiario['PylCod'])
                                  ->where('ManCod', $beneficiario['ManCod'])
                                  ->where('VivLote', $beneficiario['VivLote'])
                                  ->where('VivBlo', $beneficiario['VivBlo'])
                                  ->first();

                $contrato =Resolucion::where('PerCod', $beneficiario['PerCod'])
                                    ->where('PylCod', $beneficiario['PylCod'])
                                    ->where('CliNop', $beneficiario['CliNop'])
                                    ->where('CliSec', $beneficiario['CliSec'])
                                    ->where('CliTMov', 1)
                                    ->where('CliElaCon' ,'=', 'S')
                                    ->select('CliFchCon')->first();

                $programa = Programa::where('PylTip', $proyecto['PylTip'])
                                    ->first();

        //return $bamper;
        return view('verification', compact('bamper', 'casada', 'proyecto', 'resolucion', 'cuenta', 'contrato', 'programa'));
    }




    public function createPDF($PerCod)
    {

        $beneficiario = Beneficiario::where('PerCod', $PerCod)
        ->where('CliEsv', 1)
        ->where('CliCMor','<=', 3)
        ->where('PerCod', $PerCod)->first();

        $bamper = Bamper::where('PerCod', $PerCod)->select('PerNom', 'PerNomPri','PerNomSeg', 'PerApePri', 'PerApeSeg', 'PerApeCas', 'PerCod')->first();

                $proyecto = Proyecto::where('PylCod', $beneficiario['PylCod'])->first();

                $resolucion = Resolucion::where('PerCod', $beneficiario['PerCod'])
                                        ->where('PylCod', $beneficiario['PylCod'])
                                        ->where('CliNop', $beneficiario['CliNop'])
                                        ->where('CliSec', $beneficiario['CliSec'])
                                        ->select('CliFRes', 'CliNrs', 'CliNac')->first();

                $cuenta = Ctacte::where('PylCod', $beneficiario['PylCod'])
                                  ->where('ManCod', $beneficiario['ManCod'])
                                  ->where('VivLote', $beneficiario['VivLote'])
                                  ->where('VivBlo', $beneficiario['VivBlo'])
                                  ->first();
                $contrato =Resolucion::where('PerCod', $beneficiario['PerCod'])
                                    ->where('PylCod', $beneficiario['PylCod'])
                                    ->where('CliNop', $beneficiario['CliNop'])
                                    ->where('CliSec', $beneficiario['CliSec'])
                                    ->where('CliTMov', 1)
                                    ->where('CliElaCon' ,'=', 'S')
                                    ->select('CliFchCon')->first();
                $programa = Programa::where('PylTip', $proyecto['PylTip'])
                                    ->first();
        $codigoQr = QrCode::size(150)->generate(env('APP_URL') . '/' . $PerCod);
        //$codigoQr = QrCode::size(150)->generate($bamper);
        $pdf = PDF::loadView('admin.beneficiario.pdf.constancia',
            [
                'beneficiario' => $beneficiario,
                'bamper' => $bamper,
                'cas' => trim($bamper->PerApeCas),
                'proyecto' => $proyecto,
                'resolucion' => $resolucion,
                'cuenta' => $cuenta,
                'contrato' => $contrato,
                'programa' => $programa,
                'valor' => $codigoQr

            ]
        );
        return $pdf->download('Constancia.pdf');

    }





    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.beneficiario.create');

        return view('admin.beneficiario.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBeneficiario $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreBeneficiario $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Beneficiario
        $beneficiario = Beneficiario::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/beneficiarios'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/beneficiarios');
    }

    /**
     * Display the specified resource.
     *
     * @param Beneficiario $beneficiario
     * @throws AuthorizationException
     * @return void
     */
    public function show(Beneficiario $beneficiario)
    {
        $this->authorize('admin.beneficiario.show', $beneficiario);

        return view('admin.beneficiario.show');

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Beneficiario $beneficiario
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Beneficiario $beneficiario)
    {
        $this->authorize('admin.beneficiario.edit', $beneficiario);


        return view('admin.beneficiario.edit', [
            'beneficiario' => $beneficiario,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBeneficiario $request
     * @param Beneficiario $beneficiario
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateBeneficiario $request, Beneficiario $beneficiario)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Beneficiario
        $beneficiario->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/beneficiarios'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/beneficiarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyBeneficiario $request
     * @param Beneficiario $beneficiario
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyBeneficiario $request, Beneficiario $beneficiario)
    {
        $beneficiario->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBeneficiario $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyBeneficiario $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Beneficiario::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
