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


        if (!empty($prmcli)) {

            $beneficiario = Beneficiario::where('CliEsv', 1)
            ->where('CliCMor','<=', 3)
            ->where('PerCod', $PerCod)->first();

            //$proyecto =

            if (!empty($beneficiario)) {

                $bamper = Bamper::where('PerCod', $PerCod)->select('PerNom')->first();

                $proyecto = Proyecto::where('PylCod', $beneficiario['PylCod'])->first();

                $resolucion = Resolucion::where('PerCod', $beneficiario['PerCod'])
                                        ->where('PylCod', $beneficiario['PylCod'])
                                        ->where('CliNop', $beneficiario['CliNop'])
                                        ->where('CliSec', $beneficiario['CliSec'])
                                        ->select('CliFRes', 'CliNrs')->first();

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
                    'titular' => $bamper['PerNom'] ? $bamper['PerNom'] : 'No tiene beneficiario Asociado',
                    'proyecto' => $proyecto['PylNom'],
                    'resolucion' => $resolucion ? $resolucion : 'No tiene resolución asociada',
                    'cuenta' => $cuenta['VivCtaCte'],
                    'contrato' => $contrato['CliFchCon'] ? $contrato['CliFchCon'] : 'No tiene Fecha de contrato',
                    'programa' => $programa['PylTipDes'],
                    'imprimir' => true

                ];
            }else {

                $mensaje =  $prmcli['CliCMor'] >= 3 && $prmcli['CliEsv'] != 1 ? 'Cuota Vencida y Estado No Vigente'  : ($prmcli['CliCMor'] >= 3 ? 'Cuota Vencida' : 'Estado No Vigente');
                $bamper = Bamper::where('PerCod', $PerCod)->select('PerNom')->first();
                $proyecto = Proyecto::where('PylCod', $prmcli['PylCod'])->first();

                $resolucion = Resolucion::where('PerCod', $prmcli['PerCod'])
                                        ->where('PylCod', $prmcli['PylCod'])
                                        ->where('CliNop', $prmcli['CliNop'])
                                        ->where('CliSec', $prmcli['CliSec'])
                                        ->select('CliFRes', 'CliNrs')->first();

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
                    //'prmcli' => $prmcli,
                    'titular' => $bamper ? $bamper['PerNom'] : 'No tiene beneficiario Asociado',
                    'message' => $mensaje,
                    'proyecto' => $proyecto['PylNom'],
                    'cuenta' => $cuenta['VivCtaCte'],
                    'contrato' => $contrato ? $contrato['CliFchCon'] : 'No tiene Fecha de contrato',
                    'resolucion' => $resolucion ? $resolucion : 'No tiene resolución asociada',
                    'programa' => $programa['PylTipDes'],
                    'imprimir' => false,


                ];
            }

        }else{
            return [
                'message' => 'No existe Registro',
                'error' => 'No existe Registro'

            ];
        }

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
