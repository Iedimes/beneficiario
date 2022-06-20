<template>
    <div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> CONSTANCIAS ANDE - ESSAP

                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control" ref="search" v-model="inputSat" @keyup.enter="getPostulante()" placeholder="Ingrese Documento del Beneficiario"  />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" @click="getPostulante()"><i class="fa fa-search"></i>&nbsp; Buscar</button>

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div v-if="error">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <p class="alert alert-danger"><strong>{{ this.error }}</strong></p>
                                    </div>
                                </div>
                            </div>

            <div v-if="visible">
            <hr>
            <h2 style="color: #4273FA; font-weight: bolder;">Beneficiario</h2><hr><br>
           <div class="row">

                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>NOMBRE:</strong> {{ this.Titular }}  </p>
                </div>
                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>CEDULA:</strong> {{ this.Cedula }}  </p>
                </div>
                <div class="form-group col-sm-3" v-if="this.Estado=='1'">
                    <p class="card-text"><strong>ESTADO:</strong> Vigente  </p>
                </div>
                <div class="form-group col-sm-3" v-else-if="this.Estado=='9'">
                    <p class="card-text"><strong>ESTADO:</strong> Cancelado  </p>
                </div>
                <div class="form-group col-sm-3" v-else-if="this.Estado=='13'">
                    <p class="card-text"><strong>ESTADO:</strong> Transferido  </p>
                </div>
                <div class="form-group col-sm-3" v-else-if="this.Estado=='23'">
                    <p class="card-text"><strong>ESTADO:</strong> Con Resolución Transferencia  </p>
                </div>
                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>ESTADO:</strong></p>
                </div>
                <div class="form-group col-sm-3" v-if="this.Imprimir==false">
                    <p style="color:red;"><strong>{{ this.Message }} </strong>  </p>
                </div>
                <div class="form-group col-sm-3" v-else-if="this.Imprimir==true">
                    <p style="color:red;"><strong>{{ this.Message }} -  </strong>  </p>
                </div>

            </div>
            <hr>
            <h2 style="color: #4273FA; font-weight: bolder;">Información del proyecto</h2>
            <hr>
            <div class="row">

                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>PROGRAMA:</strong> {{ this.Programa }}  </p>
                </div>
                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>CODIGO PROYECTO:</strong> {{ this.Codigo }} </p>
                </div>
                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>PROYECTO:</strong> {{ this.Proyecto }} </p>
                </div>
                 <div class="form-group col-sm-3" v-if="this.Cuenta==''">
                    <p class="card-text"><strong>CTA. CTE. CTRAL.:</strong><b  style="color:red;"> No tiene cta. cte. ctral</b></p>
                </div>
                <div class="form-group col-sm-3" v-else-if="this.Cuenta=='No tiene dato en cuenta corriente catastral'">
                    <p class="card-text"><strong>CTA. CTE. CTRAL.:</strong><b  style="color:red;"> No tiene cta. cte. ctral</b></p>
                </div>
                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>CTA. CTE. CTRAL.:</strong>  {{ this.Cuenta  }} </p>
                </div>

            </div>
            <br>
            <div class="row">


                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>MANZANA:</strong> {{ this.Manzana  }} </p>
                </div>
                <div class="form-group col-sm-3">
                    <p class="card-text"><strong>LOTE:</strong> {{ this.Lote }}  </p>
                </div>

                <div class="form-group col-sm-3" v-if="this.Contrato=='No tiene Fecha de contrato'">
                    <p class="card-text"><strong>FECHA CONTRATO:</strong><b  style="color:red;"> No tiene Fecha de contrato</b></p>
                </div>
                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>FECHA CONTRATO:</strong>  {{ this.Contrato  }} </p>
                </div>


                <div class="form-group col-sm-3" v-if="this.Actanro=='No tiene nro acta asociado'">
                    <p class="card-text"><strong>NRO ACTA:</strong><b  style="color:red;"> No tiene nro acta asociado</b></p>
                </div>

                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>NRO ACTA:</strong> {{ this.Actanro }}  </p>
                </div>

            </div>

            <br>

            <div class="row">


                <div class="form-group col-sm-3" v-if="this.Resolucion=='No tiene nro de resolución asociada'">
                    <p class="card-text"><strong>NRO RESOLUCION:</strong><b  style="color:red;"> No tiene nro de resolución asociada </b></p>
                </div>
                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>NRO RESOLUCION:</strong> {{ this.Resolucion }}  </p>
                </div>
                <div class="form-group col-sm-3" v-if="this.Fresolucion=='No tiene fecha de resolución'">
                    <p class="card-text"><strong>FECHA RESOLUCION:</strong> <b  style="color:red;">No tiene fecha de resolución</b></p>
                </div>
                <div class="form-group col-sm-3" v-else>
                    <p class="card-text"><strong>FECHA RESOLUCION:</strong> {{ this.Fresolucion }}  </p>
                </div>

                <div class="form-group col-sm-1.5" v-if="this.Contrato=='No tiene Fecha de contrato'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Cuenta=='No tiene dato en cuenta corriente catastral'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Cuenta==''">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Cuenta==''">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Manzana=='No tiene dato en manzana'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Lote=='No tiene dato en lote'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Resolucion=='No tiene nro de resolución asociada'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Fresolucion=='No tiene fecha de resolución'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Actanro=='No tiene nro acta asociado'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else-if="this.Message=='Cuota Vencida'">
                        <!-- <a class="btn btn-sm btn-danger pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;GENERAR PDF Contrato</a> -->
                </div>
                <div class="form-group col-sm-1.5" v-else>
                        &nbsp;&nbsp;&nbsp;<a class="btn btn-sm btn-primary pull-right m-b-0 rounded-pill" :href="'/admin/beneficiarios/' + this.Cedula + '/constanciapdf/'"><i class="fa fa-file-pdf-o "></i>&nbsp;<b>GENERAR PDF</b></a>
                </div>


            </div>
            <br>

                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary"><strong>Error!</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-primary">
                <p><strong>El numero de documento del beneficiario es requerido.</strong></p>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary bg-primary text-white" data-dismiss="modal">Salir</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
// Import component
//import Loading from "vue-loading-overlay";
// Import stylesheet
//import "vue-loading-overlay/dist/vue-loading.css";
//import { mask } from "vue-the-mask";
//import VModal from "vue-js-modal/dist/index.nocss.js";
import "vue-js-modal/dist/styles.css";
//import fab from "vue-fab";
//Vue.use(VModal);

export default {
    props: ["data"],
    data() {
        return {
            isLoading: false,
            fullPage: true,
            Cedula: "",
            Titular: "",
            Proyecto: "",
            Programa: "",
            Cuenta: "",
            Contrato: "",
            Resolucion: "",
            Fresolucion: "",
            Actanro:"",
            Lote:"",
            Manzana:"",
            Codigo:"",
            Estado:"",
            Imprimir:"",
            Message:"",
            error: "",
            infoBeneficiario: null,
            inputSat: "",
            visible: false,
            bgColor: "#3B82F6",
            position: "bottom-right",
            fabActions: [
                {
                    name: "cache",
                    icon: "keyboard_backspace",
                    tooltip: "Volver al Inicio"
                }
            ]
        };
    },
    //directives: { mask },
    components: {
        //Loading,
        //fab
    },
    methods: {
        cache() {
            window.location = "/";
        },
        alert() {
            alert("Clicked on alert icon");
        },
        getPostulante() {
            //let me = this;

            if (!this.inputSat) {
                //alert('Ingrese Cedula')
                $('#myModal').modal('show');
            } else {
                let me = this;
                var url = "/admin/beneficiarios/" + this.inputSat;
                this.isLoading = true;
                this.clearData();

                //me.isLoading = true;
                axios
                    .get(url)
                    .then(function(response) {
                        var respuesta = response.data;
                        console.log(respuesta);

                        if (!respuesta.error) {
                            me.Cedula = respuesta.cedula;
                            me.Titular = respuesta.titular;
                            me.Programa = respuesta.programa;
                            me.Proyecto = respuesta.proyecto;
                            me.Codigo = respuesta.codigo;
                            me.Contrato = respuesta.contrato;
                            me.Resolucion = respuesta.resolucion;
                            me.Fresolucion = respuesta.fresolucion;
                            me.Cuenta = respuesta.cuenta;
                            me.Actanro = respuesta.actanro;
                            me.Lote = respuesta.lote;
                            me.Manzana = respuesta.manzana;
                            me.Estado = respuesta.estado;
                            me.Message = respuesta.message;
                            me.Imprimir = respuesta.imprimir;
                            me.visible = true;
                            me.error = "";

                        } else {
                            console.log('vacio');
                            me.visible = false;
                            me.error = respuesta.error;
                            me.ErrorCedula = me.inputSat;
                            me.isLoading = false;
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        me.isLoading = false;
                    });
            }
        },
        clearData() {
            let me = this;

            me.Cedula = "";
            me.Titular = "";
            me.Programa = "";
            me.Proyecto = "";
            me.Codigo = "";
            me.Contrato = "";
            me.Resolucion = "";
            me.Fresolucion = "";
            me.Cuenta = "";
            me.Actanro = "";
            me.Lote = "";
            me.Manzana = "";
            me.Estado = "";
            me.Imprimir = "";
            me.Message = "";
        },
        doAjax() {
            this.isLoading = true;

            setTimeout(() => {
                this.isLoading = false;
            }, 5000);
        },
        onCancel() {
            console.log("User cancelled the loader.");
        }
    },
    mounted() {

        this.$refs.search.focus();
    }
};
</script>
