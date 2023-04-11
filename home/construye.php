<?php
	require_once('lista.php');
	require_once('cuenta.php');
	require_once('cazador.php');
	require_once('campana.php');
	require_once('arraylist.php');
	class Construye
	{
		public function __construct()
		{
			 	
		}

		public function devuelveSitio($correo)
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($correo);
			if($cuenta->ifExiste($correo))
			{
				$perf = $cuenta->retornaPerfil($correo);
				if($perf != false)
				{
					if($perf == 1)
					{
						return $this->plantilla();
					}
					else
					{
						//Construye ADMIN
					}
				}
				else
				{
					//NO EXISTE EL CORREO
				}
			}
			else 
			{
			 	//CERRAR SESION
			}
		}

		public function plantilla()
		{
			$retornar = "
				<!DOCTYPE html>
					<html lang='es'>
					  <head>
					  	<meta charset='utf-8'>
					    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
					    <meta name='viewport' content='width=device-width, initial-scale=1'>
					    
					    <link rel='icon' type='image/png' href='../img/Logo-Airpost-Final-05.jpg' />
					    <title>AIRPOST</title>

					    <!-- Bootstrap -->
					    <link rel='stylesheet' href='../css/bootstrap.min.css'>
					    <link rel='stylesheet' href='../css/estilos.css'>

					    <link href='https://fonts.googleapis.com/css?family=Open+Sans|Roboto' rel='stylesheet' type='text/css'>

					    <style>
					        body {
					          font-family: 'Roboto', sans-serif;
					        }
					    </style>

					    <!-- FontAwesome -->
					    <link rel='stylesheet' href='../css/font-awesome.min.css'>

					    <link rel='stylesheet' type='text/css' href='../css/styles.css'>

					    <!--[if lt IE 9]>
					      <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
					      <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
					    <![endif]-->

					    
					  </head>
					  <body>

					    <section id='top'>
					      <div class='container-fluid'>
					        <ul>
					          <li><a href=''><i class='fa fa-info-circle fa-lw'></i> Airpost Help!</a></li>
					          <li><a href=''><i class='fa fa-cog fa-lw'></i> Cuenta y configuración</a></li>
					          <li><a href='skype:airpost?call'><i class='fa fa-skype fa-lw'></i> Skype: AirpostHelp</a></li>
					          <li><a href='tel:+5622344566'><i class='fa fa-phone fa-lw'></i> Help Phone:(+56) 2 234 45 66</a></li>
					        </ul>
					      </div>
					    </section>

					    <section id='header'>
					      <div class='container-fluid'>

					        <!--
					        ====================
					                LOGO
					        ====================

					        * En dispositivos medianos o superiores se encontrará al medio, utilizando las 4 columnas centrales
					        * En dispositivos pequeños utilizará las primeras 6 columnas

					        En su interior se encuentra la imágen con la característica 'Responsive' además de estar centrada, se recomienda a futuro implementar algún jQuery capaz de adaptar las imágenes a retina.
					        -->
					        <div class='col-md-4 col-md-offset-4 col-xs-6'>
					          <img src='../img/logo-airpost-header.png' class='img-responsive center-block'>
					        </div>

					        <!--
					        ====================
					               USUARIO
					        ====================

					        * En dispositivos medianos o superiores se encontrará en las ultimas 4 columnas.
					        -->
					        <div class='col-md-4 col-xs-6'>

					          <div class='row'> 
					            <div class='col-xs-6 col-xs-offset-6 logo-cog-icon-container'>
					              <a href='cierrasession.php'><i class='fa fa-cog text-right bottom-align nolink-cog'></i></a>
					              <img src='../img/Logo-cliente.png' class='img-responsive'>
					            </div>
					          </div>  
					        </div>
					      </div>
					    </section>
					    <section class='linear'></section>

					    <!--
					    ======================
					        SECCION - MENU
					    ======================
					    -->
					    <nav class='navbar navbar-default'>
					      <div class='container-fluid'>

					 
					        <!--
					        ==============================
					                MENU - ENCABEZADO
					        ==============================

					        * En dispositivos XS se contraerá el menu permitiendo el menu responsive.
					        -->

					        <div class='navbar-header'>
					          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false'>
					            <span class='sr-only'>Toggle navigation</span>
					            <span class='icon-bar'></span>
					            <span class='icon-bar'></span>
					            <span class='icon-bar'></span>
					          </button>
					        </div>

					        <!-- 
					        =============================
					                MENU - ELEMENTOS
					        =============================
					        -->
					        <div class='collapse navbar-collapse' id='navbar'>
					          <ul class='nav navbar-nav'>
					            <li id='linkGetInicio'      class='active' ><a href='../home/'><i class='fa fa-home'></i> INICIO</a></li>
					            <li id='linkGetCampana'     class='manitolink'><a><i class='fa fa-envelope'></i> CARGAR CAMPAÑA</a></li>
					            <li id='linkReporteCampana' class='manitolink'><a><i class='fa fa-pie-chart'></i> REPORTES DE CAMPAÑAS</a></li>
					            <li id='linkBases'          class='manitolink'><a><i class='fa fa-users'></i> BASES</a></li>
					            <li id='linkCazador'        class='manitolink'><a><i class='fa fa-crosshairs'></i> CAZADOR</a></li>
					            <li style='display:none;' id='linkSms'            class='manitolink'><a><i class='fa fa-comment'></i> SMS</a></li>
					            <li id='linkPlantillas'     class='manitolink'><a><i class='fa fa-pencil'></i> PLANTILLAS</a></li>
					          </ul>
					        </div>


					      </div>
					    </nav>

					    <!-- 
					    ===========================
					        SECCION - PANELES
					    ===========================
					    -->
					    <section id='tabs'>
					      <div class='container-fluid'> 
					        <div id='panelCentralUsoGeneal'>

					          %panelCentralUsoGeneal%

					        </div>
					      </div>
					    </section>

					    <!-- Borde degradado -->
					    <section class='linear' style='margin-top: 20px;'></section>

					    <!-- 
					    =======================
					            FOOTER
					    =======================
					    -->
					    <section id='footer'>
					      <div class='container'>
					        <div class='row'>
					          <div class='col-md-6'>
					            <img src='../img/Icon-footer-Airpost.png'>
					          </div>
					          <div class='col-md-6'>
					            <ul id='footer-menu'>
					              <li><a href='#'><i class='fa fa-info-circle fa-lw'></i> Airpost Help!</a></li>
					              <li><a href='#'><i class='fa fa-cog fa-lw'></i> Cuenta y configuración</a></li>
					              <li><a href='skype:airpost?call'><i class='fa fa-skype fa-lw'></i> Skype: AirpostHelp</a></li>
					              <li><a href='tel:+5622344566'><i class='fa fa-phone fa-lw'></i> Help Phone:(+56) 2 234 45 66</a></li>
					            </ul>
					          </div> 
					        </div>  
					      </div>  
					    </section>

					    <div id='lightbox'></div>
					    <div class='container-fluid' id='lightbox-content'></div>
					    <div id='lightbox-content-mensaje' class='col-sm-12 col-sm-offset-4'></div>

					    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src='../js/jquery-1.12.3.min.js'></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src='../js/bootstrap.min.js'></script>
					    <script src='../js/funciones.js'></script>

					    <!-- Editor HTML -->
					    <link rel='stylesheet' href='../latest/minified/themes/default.min.css' />
						<script src='../latest/minified/jquery.sceditor.xhtml.min.js'></script>
						<script src='../latest/languages/es.js'></script>

					    <script type='text/javascript'>
					    	$('#linkGetCampana').click(function(){
					    		cambiaPagina(2);
					    	});
					    	$('#linkReporteCampana').click(function(){
					    		cambiaPagina(3);
					    	});
					    	$('#linkBases').click(function(){
					    		cambiaPagina(4);
					    	});
					    	$('#linkCazador').click(function(){
					    		cambiaPagina(5);
					    	});
					    	$('#linkSms').click(function(){
					    		cambiaPagina(6);
					    	});
					    	$('#linkPlantillas').click(function(){
					    		cambiaPagina(7);
					    	});
					    	$('#lightbox').click(function(){
					    		closelightbox();
					    	});
					    	$('body').keyup(function(e) {
						    	if(e.keyCode == 13 && $('#buscarbd').is(':focus')) {
						    		buscarbddesdetexto();
						    	}
							});

							$(document).ready(function(){
								barraCarga(porcentajeCumplido%);
							});
						</script>
					  </body>
					</html>
			";
			$retornar = str_replace("%panelCentralUsoGeneal%", $this->home(), $retornar);
			$retornar = str_replace("porcentajeCumplido%", $this->calculaPorcentaje(), $retornar);
			return $retornar;
		}

		public function campaign()
		{
			$plantilla ="
				<!--
          ===============================
                PANELES - MENU
          ===============================
          -->
          <ul class='nav nav-tabs' role='tablist'>

            <!-- Menu asociado con el panel 'cargarbase' -->
            <li id='cargarc1' role='presentation' class='active' onclick='cambiaPaso(1)'>
             <a href='#cargarbase' aria-controls='cargarbase'>
              <i class='fa fa-users'></i> PASO 1: CARGAR BASE
             </a>
            </li>

            <!-- Menu asociado con el panel 'cargargrafica' -->
            <li id='cargarc2' class='desactivado'>
              <a href='#cargargrafica' aria-controls='cargargrafica'>
                <i class='fa fa-pencil'></i> PASO 2: CARGAR GRÁFICA
              </a>
            </li>

            <!-- Menu asociado con el panel 'testyenviar' -->
            <li id='cargarc3' class='desactivado'>
              <a href='#testyenviar' aria-controls='testyenviar'>
                <i class='fa fa-paper-plane'></i> PASO 3: ENVIAR CAMPAÑA
              </a>
            </li>

            <!-- Menu asociado a las notificaciones -->
            <li id='notifications' style='float: right;'>
              <a href='#notifications'>
                Tienes 
                <!-- Cantidad de notificaciones -->
                <span class='label label-danger'>%cantidadNotificaciones%</span> 
                notificaciones
              </a>
            </li>
          </ul>

          <!--
          ==============================
              PANELES - CONTENIDO
          ==============================

          * Paneles de contenido variable
          -->

          <br>
          <div class='tab-content'>
            <!-- Panel de bienvenida -->
            <div role='tabpanel' class='tab-pane active' id='cargarpaso1'>
              <!-- Empieza aquí -->
                <div class='container'>
                  <div class='row'>
                    <div class='col-sm-8 col-sm-offset-2'>
                      
                      <div class='panel panel-default panel-blue' id='replace-table-blue'>
                        <div class='panel-heading'>
                          <i class='fa fa-users'></i> CARGAR BASE
                        </div>
                        <table class='table table-striped' id='tablaListas'>
                          <tbody>
                          	<tr>
                              <td><div id='nombrebasesubir'>Subir base</div></td>
                              <td class='text-right'>
                              	<div style='display:none;'>
                              		<form name='formuploadbd' id='formuploadbd'>
                              			<input type='file' name='archivo1' id='archivo1' onchange='subearchivo()'>
                              		</form>
                              	</div>
                                <fa class='fa fa-folder-open'></fa> <label class='manitolink textoPesoLiviano' for='archivo1'>Examinar
                              </td>
                            </tr>
                          	<tr>
                              <td><div id='textoListaSeleccionada'>No hay lista seleccionada...</div></td>
                              <td class='text-right'>
                              	<div class='manitolink' onclick='openlightbox(1)'><fa class='fa fa-search'></fa> Buscar</div>
                              </td>
                            </tr>


                            
                            
                          </tbody>
                        </table>
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight-nopadding pull-left' onclick='openlightbox(2)'>
                            <i class='fa fa-minus fa-minus-mine'></i>
                          </a>
                          <a class='btn btn-primary btn-highlight-nopadding pull-left' onclick='openlightbox(1)'>
                            <i class='fa fa-plus fa-plus-mine'></i>
                          </a>	

                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i id='checkCampanasSeleccionadas' class='fa fa-times fa-danger'></i> Seleccionar
                          </a>
                         
                        </div>
                      </div>

                    </div>

                    <div class='col-sm-8 col-sm-offset-2'>
                      
                      <div class='panel panel-default panel-blue'>
                        <div class='panel-heading'>
                          <i class='fa fa-users'></i> CONTACTOS CARGADOS
                        </div>
                        <table class='table table-striped'>
                          <tbody>
                            <tr>
                              <td><i class='fa fa-search'></i> Contactos cargados</td>
                              <td class='text-right'>
                                <div id='cantidadContactosCorrectos'></div>
                              </td>
                            </tr>
                            <tr>
                              <td><i class='fa fa-search'></i> Contactos no cargados o con error</td>
                              <td class='text-right'>
                                <div id='cantidadContactosErroneos'></div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i id='totalContactosEnviar' class='fa fa-times fa-danger'></i>
                            TOTAL A ENVIAR
                            <span class='btn-total' id='cantidadContactosEnviar'></span>
                          </a>
                         
                        </div>
                      </div>

                      <a class='btn btn-confirm btn-success pull-right desactivado' id='step1confirm' href='#cargargrafica'  aria-controls='cargargrafica' role='tab' data-toggle='tab'>
                      <i class='fa fa-pencil fa-success'></i>
                      IR AL PASO 2: CARGAR GRÁFICA
                      </a>

                    </div>
                  </div>  
                </div>


              <!-- Termina aquí -->
            </div>

            
            <!-- Panel de estado de la cuenta -->
            <div role='tabpanel' class='tab-pane' id='cargarpaso2'>
              <!-- Empieza aquí -->
              

                <div class='container'>
                  <div class='row'>
                    <div class='col-sm-5'>
                      
                      <!-- Panel azul -->
                      <div class='panel panel-default panel-blue'>
                        <!-- Encabezado del panel -->
                        <div class='panel-heading'>
                          <i class='fa fa-pencil'></i> CARGAR GRÁFICA
                        </div>

                        <!-- Table del panel -->
                        <table class='table table-striped'>
                          <tbody>
                            <tr>
                              <td>No hay gráfica cargada... </td>
                              <td class='text-right'>
                              	<div style='display:none;'>
                              		<form name='formuploadgraphic' id='formuploadgraphic' enctype='multipart/form-data'>
                              			<input type='file' name='archivo2' id='archivo2' onchange='subegraphic()'>
                              		</form>
                              	</div>
                                <fa class='fa fa-folder-open'></fa> <label class='manitolink textoPesoLiviano' for='archivo2'>Examinar
                              </td>
                            </tr>
                            <tr>
                              <td>No hay lista seleccionada...</td>
                              <td class='text-right'>
                                <fa class='fa fa-search'></fa> Buscar
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <!-- Pie del panel -->
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i class='fa fa-close fa-danger'></i> Seleccionar
                          </a>
                        </div>
                      </div>

                      <!-- Panel azul -->
                      <div class='panel panel-default panel-blue'>
                        <!-- Encabezado del panel -->
                        <div class='panel-heading'>
                          <i class='fa fa-scissors'></i> EDITAR CAMPAÑA
                        </div>

                        <!-- Tabla del panel -->
                        <table class='table table-striped'>
                          <tbody>
                            <tr>
                              <td>No hay campaña cargada</td>
                            </tr>
                          </tbody>
                        </table>

                        <!-- Pie el panel -->
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i class='fa fa-close fa-danger'></i> Editar Campaña
                          </a>
                        </div>
                      </div>

                      <!-- Panel azul -->
                      <div class='panel panel-default panel-blue'>
                        <!-- Encabezado del panel -->
                        <div class='panel-heading'>
                          <i class='fa fa-wrench'></i> DETALLES DE ENVIO
                        </div>

                        <!-- Tabla del panel -->
                        <table class='table table-striped'>
                          <tbody>
                            <tr>
                              <td>Ingresar asunto de la campaña (subject lines)</td>
                              <td class='text-right'>
                                
                              </td>
                            </tr>
                            <tr>
                              <td>Ingresar email de reenvío</td>
                              <td class='text-right'>
                                <fa class='fa fa-cogs'></fa>
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <!-- Pie del panel -->
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i class='fa fa-close fa-danger'></i> GUARDAR
                          </a>
                        </div>
                      </div>

                      <!-- Panel azul -->
                      <div class='panel panel-default panel-blue'>
                        <!-- Encabezado del panel -->
                        <div class='panel-heading'>
                          <i class='fa fa-flask'></i> ENVIAR TEST
                        </div>

                        <!-- Tabla del panel -->
                        <table class='table table-striped'>
                          <tbody>
                            <tr>
                              <td>Ingresa un email para mandar un test</td>
                              <td class='text-right'>
                                <fa class='fa fa-plus-circle'></fa> Examinar
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <!-- Pie del panel -->
                        <div class='panel-footer'>
                          <a class='btn btn-primary btn-highlight pull-right'>
                            <i class='fa fa-paper-plane fa-danger'></i> Enviar Test
                          </a>
                         
                        </div>
                      </div>
                    </div>

                    <!-- Columna 7-12 -->
                    <div class='col-sm-7'>
                      <!-- Contenedor oscuro -->
                      <div class='well col-sm-12'>
                        <textarea id='editorhtml'></textarea><br />
                        <input type='button' name='mostrar' value='Mostrar HTML' onclick='mostrarhtml()'>	
                      </div>  

                      <!-- Enviar campaña -->
                      <a class='btn btn-danger btn-block col-sm-12'><i class='fa fa-paper-plane'></i> IR AL PASO 3:  ENVIAR CAMPAÑA</a>
                    </div>

                  </div>  
                </div>



              <!-- Termina aquí -->
            </div>

            <!-- Panel del estado financiero -->
            <div role='tabpanel' class='tab-pane' id='cargarpaso3'>
              <!-- Empieza aquí -->
                

              <!-- Termina aquí -->
            </div>
          </div>
			";
			
			$plantilla = str_replace("%cantidadNotificaciones%", $this->getNotificaciones(), $plantilla);
			return $plantilla;
		}

		public function campaignDesign()
		{
			$plantilla = "
				
			";
		}

		public function cazador()
		{
			$plantilla = "
				<!--
		          ===============================
		                PANELES - MENU
		          ===============================
		          -->
		          <ul class='nav nav-tabs' role='tablist'>

		            

		            <!-- Menu asociado a las notificaciones -->
		            <li id='notifications' style='float: right;'>
		              <a href='#notifications'>
		                Tienes 
		                <!-- Cantidad de notificaciones -->
		                <span class='label label-danger'>%cantidadNotificaciones%</span> 
		                notificaciones
		              </a>
		            </li>
		          </ul>

		          <br>

		          <!-- Columna 1-6 -->
                    <div class='col-sm-6 col-lg-offset-3'>
                      <div class='panel panel-default panel-orange'>
                      	<div class='panel-heading'>
					      <i class='fa fa-crosshairs'></i> CAZADOR
					    </div>
					    <div class='panel-body-cazador' id='panel-naranjo-body'>
					      %cazadorActivado%
					    </div>
					    <div class='panel-footer'>
					      <!-- creditos disponibles -->
					        <i class='fa fa-crosshairs fa-white pull-right'></i>
					    </div>
                      </div>
                    </div>  
			";
			$plantilla = str_replace("%cantidadNotificaciones%", $this->getNotificaciones(), $plantilla);
			$generadas = $this->revisaKey();
			$mostrar = "";
			if($generadas == 0)
			{
				$mostrar = $this->noGenerada();
			}
			else
			{
				$key = $this->obtieneKey();
				$mostrar = $this->generada($key);
			}
			$plantilla = str_replace("%cazadorActivado%", $mostrar, $plantilla);
			return $plantilla;
		}

		public function home()
		{
			$plantilla = "
						<!--
					          ===============================
					                PANELES - MENU
					          ===============================
					          -->
					          <ul class='nav nav-tabs' role='tablist'>

					            <!-- Menu asociado con el panel 'welcome' -->
					            <li role='presentation'>
					             <a aria-controls='welcome' role='tab'>
					              BIENVENIDO %nombreEmpresa%
					             </a>
					            </li>

					            <!-- Menu asociado con el panel 'account-status' -->
					            <li role='presentation' class='active'>
					              <a href='#account' aria-controls='account' role='tab' data-toggle='tab'>
					                <i class='fa fa-cog'></i> ESTADO GENERAL DE CUENTA
					              </a>
					            </li>

					            <!-- Menu asociado con el panel 'billing' -->
					            <li role='presentation'>
					              <a href='#billing' aria-controls='billing' role='tab' data-toggle='tab'>
					                <i class='fa fa-credit-card'></i> BILLING
					              </a>
					            </li>

					            <!-- Menu asociado a las notificaciones -->
					            <li id='notifications' style='float: right;'>
					              <a href='#notifications'>
					                Tienes 
					                <!-- Cantidad de notificaciones -->
					                <span class='label label-danger'>%cantidadNotificaciones%</span> 
					                notificaciones
					              </a>
					            </li>
					          </ul>

					          <!--
					          ==============================
					              PANELES - CONTENIDO
					          ==============================

					          * Paneles de contenido variable

					          - welcome : contiene el contenido inicial de bienvenida
					          - account-status : contiene el contenido del estado de las cuentas
					          - billing : contiene el contenido del estado financiero

					          -->

					          <br>
					          <div class='tab-content'>
					            <!-- Panel de bienvenida -->
					            <div role='tabpanel' class='tab-pane' id='welcome'>
					              <!-- Empieza aquí -->
					                


					              <!-- Termina aquí -->
					            </div>

					            

					            <!-- Panel de estado de la cuenta -->
					            <div role='tabpanel' class='tab-pane active' id='account'>
					              <!-- Empieza aquí -->
					                <div class='container'>
					                  <div class='row'>

					                    <!-- Columna 1-6 -->
					                    <div class='col-sm-6'>
					                      
					                      <!-- Panel naranjo -->
					                      <div class='panel panel-default panel-orange'>
					                        <!-- Encabezado del panel -->
					                        <div class='panel-heading'>
					                          <i class='fa fa-credit-card'></i> mensajeCreditosPlan%
					                        </div>
					                        <!-- Cuerpo del panel -->
					                        <div class='panel-body'>
					                          <!-- Barra de progresos -->
					                          <div class='progress'>
					                            <!-- 
					                            ================
					                            indicador de uso
					                            ================
					                            
					                            Por lo que pude entender, el primer indicador es una cifra numérica relacionada a la cantidad de creditos que han sido usados.

					                            parametros a configurar:

					                            ======================================================
					                            aria-valuenow='[x]'                                 ||
					                            ======================================================
					                            debe modificar [x] por la cantidad de creditos usados


					                            ======================================================
					                            style='width: [0-100]%'                             ||
					                            ======================================================
					                            debe cambiar [0-100] por el porcentaje representativo de dicha cantidad

					                            ======================================================
					                            aria-valuemax='[x]'                                 ||
					                            ======================================================
					                            debe cambiar [x] por la cantidad total de creditos
					                             -->

					                            <div id='barracargaanimar1' class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='gastadoActual' aria-valuemin='0' aria-valuemax='cienPorcientoTotal' style='width: 0%'>
					                              <!-- Primera barra contiene la cantidad de creditos usados, fondo verde -->
					                              gastadoActual
					                            </div>


					                            <div id='barracargaanimar2' class='progress-bar progress-bar-blank' role='progressbar' aria-valuenow='porcentajeCumplido%' aria-valuemin='0' aria-valuemax='100' style='width: porcentajeCumplido%'>
					                              <!-- Segunda barra contiene la cantidad total de creditos, fondo blanco, black letters -->
					                              cienPorcientoTotal
					                            </div>
					                          </div>
					                        </div>

					                        <!-- Pie del panel -->
					                        <div class='panel-footer'>
					                          <!-- creditos disponibles -->
					                          mensajeCreditosRestantes%
					                          <i class='fa fa-arrow-circle-right fa-white pull-right'></i>
					                        </div>
					                      </div>
					                      <!-- Fin Panel de creditos de plan -->

					                    </div>
					                    <!-- Fin Columna 1-6 -->

					                    <!-- Columna 7-12 -->
					                    <div class='col-sm-6'>

					                      <!-- Panel rojo -->
					                      <div class='panel panel-default panel-red'>

					                        <!-- Encabezado del panel -->
					                        <div class='panel-heading'>
					                          <i class='fa fa-envelope'></i> Últimas campañas
					                        </div>

					                        <!-- Contenido del panel -->
					                        <div class='panel-body'>
					                          
					                          <img src='../img/Body-Home-Inicio-cargarcampana.png' class='img-responsive center-block'>

					                        </div>

					                        <!-- Pie del panel -->
					                        <div class='panel-footer text-center'>
					                          %mensajeUltimasCamapañas%
					                          <a href='%linkVerCampanas%'><i class='fa fa-search-plus fa-white pull-right'></i></a>
					                        </div>

					                      </div>
					                      <!-- Fin Panel rojo -->
					                    </div>
					                    <!-- Fin Columna 7-12 -->
					                  </div>  
					                </div>
					              <!-- Termina aquí -->
					            </div>

					            <!-- Panel de billing -->
					            <div role='tabpanel' class='tab-pane' id='billing'>
					              <!-- Empieza aquí -->
					                

					              <!-- Termina aquí -->
					            </div>
					          </div>
						";
			
			$plantilla = str_replace("porcentajeCumplido%", $this->calculaPorcentaje()."%", $plantilla);
			$plantilla = str_replace("cienPorcientoTotal", $this->totalPlan(), $plantilla);
			$plantilla = str_replace("gastadoActual", $this->gastadoActual(), $plantilla);
			$restantes = $this->creditosRestantes();
			$plantilla = str_replace("mensajeCreditosPlan%", $restantes[0], $plantilla);
			$plantilla = str_replace("mensajeCreditosRestantes%", $restantes[1], $plantilla);
			$plantilla = str_replace("%nombreEmpresa%", $this->nombreEmpresa(), $plantilla);
			$plantilla = str_replace("%cantidadNotificaciones%", $this->getNotificaciones(), $plantilla);
			$msjCampana = "";
			
			if($this->getCampanas() == "tiene")
			{
				$msjCampana = "<a href='#' class='nolink'>Revisa tus campañas</a>";
				$plantilla = str_replace("%linkVerCampanas%", "#", $plantilla);
			}
			else
			{
				$msjCampana = "<a href='#' class='nolink'>Necesitas crear una campaña</a>";
				$plantilla = str_replace("%linkVerCampanas%", "#", $plantilla);
			}
			$plantilla = str_replace("%mensajeUltimasCamapañas%", $msjCampana, $plantilla);
			return $plantilla;
		}

		public function bases()
		{
			$plantilla = "
				<ul class='nav nav-tabs' role='tablist'>

	            <!-- Menu asociado con el panel 'cargarbaseb' -->
	            <li id='cargarb1' role='presentation' class='active manitolink' onclick='cambiaPasoBase(1)'>
	             <a href='#cargarbaseb' aria-controls='cargarbase'>
	              <i class='fa fa-users'></i> CARGAR, BORRAR Y<br /> VER BASES
	             </a>
	            </li>

	            <!-- Menu asociado con el panel 'cargarcontactosb' -->
	            <li id='cargarb2' class='desactivado'>
	              <a href='#cargarcontactosb' aria-controls='cargargrafica'>
	                <i class='fa fa-user'></i> CARGAR, BORRAR Y<br /> VER CONTACTOS
	              </a>
	            </li>

	            <!-- Menu asociado con el panel 'alimentarzadorb' -->
	            <li id='cargarb3' class='' onclick='cambiaPasoBase(3)'>
	              <a href='#alimentarzadorb' aria-controls='testyenviar'>
	                <i class='fa fa-crosshairs'></i> ALIMENTAR CAZADOR<br /> &nbsp;
	              </a>
	            </li>

	            <!-- Menu asociado a las notificaciones -->
	            <li id='notifications' style='float: right;'>
	              <a href='#notifications'>
	                Tienes 
	                <!-- Cantidad de notificaciones -->
	                <span class='label label-danger centrarY-div'>%cantidadNotificaciones%</span> 
	                notificaciones
	              </a>
	            </li>
	          </ul>

	          <!-- Inicio del panel con el contenido de 'BASES' -->
	          <br />
	          <div class='tab-content'>
	          	<div id='paginabases' class='tab-pane active' role='tabpanel'>
	          		<div class='container'>
		          		<div class='row'>
		          			<div id='panel-ocultar-bd1'>
			          			<div class='col-sm-8 col-sm-offset-2'>
			          				<div id='panel-carga-bd1' class='panel panel-default panel-blue'>
			          					<div class='panel-heading'>
			          						<i class='fa fa-users'></i>
			          						CARGAR BASE
			          					</div>
			          					<table id='tabla-carga-bd' class='table table-striped'>
			          						<tr>
			          							<td>
			          								<div id='nombrebaseexaminar'>Cargar base</div>
			          							</td>
			          							<td class='text-right'>
			          								<div style='display:none;'>
			          									<input id='archivo1' name='archivo1' onchange='muestrafile2()' type='file'>
			          								</div>
			          								<fa class='fa fa-folder-open'></fa>
			          								<label class='manitolink textoPesoLiviano' for='archivo1'>Examinar</div>
			          							</td>
			          						</tr>
			          					</table>
			          					<div class='panel-footer'>
			          						<a class='btn btn-primary btn-highlight pull-left' onclick='limpiafilesubir()' style='display:none;' id='botonlimpiarbasesubir'>
			          							<i class='fa fa-minus fa-minus-mine fa-danger'></i>
			          							LIMPIAR
			          						</a>
			          						<a class='btn btn-primary btn-highlight pull-right'>
			          							<i id='checkBDSeleccionada' class='fa fa-times fa-danger'></i>
			          							SUBIR BASE
			          						</a>
			          					</div>	
			          				</div>
	 		          			</div>

			          			<br />

			          			<div id='misbases' class='col-sm-8 col-sm-offset-2'>
			          				<div class='col-xs-2 mipanel miborde'>
			          					<i class='fa fa-cloud-download fa-2x grisoscuro manitolink' onclick='bdaccionescargarbd(1)'></i>
			          					<i class='fa fa-search-plus fa-2x grisoscuro margin-left-3px manitolink' onclick='bdaccionescargarbd(2)'></i>
			          					<i class='fa fa-trash fa-2x grisoscuro margin-left-3px manitolink' onclick='bdaccionescargarbd(3)'></i>
			          				</div>

			          				<div class='col-xs-4 pull-right mipanel miborde'>
			          					<i class='fa fa-search fa-2x grisoscuro'></i>
			          					<input type='text' name='buscarbd' id='buscarbd' value='BUSCAR' class='col-xs-10 pull-right'>
			          				</div>
			          			</div>

			          			<div id='mipanel-tabla-bases' class='col-sm-8 col-sm-offset-2 margin-top-5px'>
			          				<table class='col-xs-12 miborde grisoscuro'>
			          					<tr>
			          						<td class='col-xs-1 mi-padding-11px'>
			          							<div class='col-xs-10'><i class='fa fa-users'></i></div>
			          						</td>
			          						<td>
			          							CARGAR BASE
			          						</td>
			          					</tr>
			          					%listasusuariototable%
			          				</div>
			          				
			          			</div>
			          		</div>
			          		
			          		<div id='panel-ocultar-bd2' style='display:none'>
			          			<div id='panel-carga-bd2' class='panel panel-default panel-blue'>
		          					Panel 2
		          				</div>
			          		</div>

			          		<div id='panel-ocultar-bd3' style='display:none'>
			          			<div id='panel-carga-bd3' class='panel panel-default panel-blue'>
		          					Panel 3
		          				</div>
			          		</div> 	
		          		</div>
		          	</div> 
	          	</div>	
	          </div>

	          <script type='text/javascript'>
	          	$('#buscarbd').focus(function(){
		    		textoInputBuscarBDFocusOn();
		    	});
		    	$('#buscarbd').focusout(function(){
		    		textoInputBuscarBDFocusOff();
		    	});
	          </script>
	          <!-- Fin 'tab-content' -->
			";

			$plantilla = str_replace("%cantidadNotificaciones%", $this->getNotificaciones(), $plantilla);
			$plantilla .= "<script src='../js/bases.js'></script>";
			$plantilla = str_replace("%listasusuariototable%", $this->getListasToTableFondoBlanco(), $plantilla);

			return $plantilla;
		}

		public function reportes()
		{
			$plantilla = "";
		}

		public function lista($plantilla)
		{
			$reemplazar = '
			Nombra tu lista: &nbsp;<input type="text" name="txtNombreLista" id="txtNombreLista"><br>
			<form action="file.php" method="post" enctype="multipart/form-data" id="formuploadajax">
				<input type="file" name="archivo1" id="archivo1" value="Buscar">
				<input type="button" value="Subir archivo" onclick="subearchivo()">
			</form>
			<div id="mensaje"></div>';
			$plantilla = str_replace("areaTrabajo", $reemplazar, $plantilla);
			$plantilla = str_replace("dashboard_replace", "", $plantilla);
			return $plantilla;
		}

		private function calculaPorcentaje()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			$datos = $cuenta->porcentajeCumplido();
			if($datos[0] != "sinvalores")
			{
				$cumplido = -1;
				if($datos[0] == "contactos")
				{
					$cumplido = $datos[1] * 100 / $datos[2];
					$cumplido = explode('.', $cumplido);
				}
				else
				{
					$cumplido = $datos[3] * 100 / $datos[4];
					$cumplido = explode('.', $cumplido);
				}
			}
			else
			{
				$cumplido = 0;
			}
			return $cumplido[0];
		}

		private function totalPlan()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			$datos = $cuenta->porcentajeCumplido();
			if($datos[0] != "sinvalores")
			{
				$cumplido = -1;
				if($datos[0] == "contactos")
				{
					$cumplido = $datos[2];
				}
				else
				{
					$cumplido = $datos[4];
				}
			}
			else
			{
				$cumplido = 0;
			}
			
			return $cumplido;
		}

		private function gastadoActual()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			$datos = $cuenta->porcentajeCumplido();
			if($datos[0] != "sinvalores")
			{
				$cumplido = -1;
				if($datos[0] == "contactos")
				{
					$cumplido = $datos[1];
				}
				else
				{
					$cumplido = $datos[3];
				}
			}
			else
			{
				$cumplido = 0;
			}
			
			return $cumplido;
		}

		private function creditosRestantes()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			$datos = $cuenta->porcentajeCumplido();
			$cumplido = array();
			if($datos[0] != "sinvalores")
			{
				if($datos[0] == "contactos")
				{
					$cumplido[0] = "Envíos del plan";
					$cumplido[1] = "Te quedan ".($datos[2] - $datos[1])." envíos en tu plan, de un total de ".$datos[2];
				}
				else
				{
					$cumplido = "Días de tu plan";
					$termino = explode('-', $datos[2]);
					$cumplido[1] = "Te quedan ".$datos[3]." días de tu plan, el cual vence el ".$termino[2]."-".$termino[1]."-".$termino[0];
				}
			}
			else
			{
				$cumplido[0] = "Sin plan";
				$cumplido[1] = "Aún no puedes realizar envíos";
			}
			
			return $cumplido;
		}

		private function nombreEmpresa()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			$cuenta = $cuenta->buscaUnaPorCorreo();
			return $cuenta->getNombre();
		}

		private function getCampanas()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			return $cuenta->tieneCampanas();
		}

		private function getNotificaciones()
		{
			return 0;
		}

		private function getCorrectos()
		{
			session_start();
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			return $cuenta->totalCorrectos();
		}

		private function getIncorrectos()
		{
			$cuenta = new Cuenta();
			$cuenta->setCorreo($_SESSION["correo"]);
			return $cuenta->totalErroneos();
		}

		private function getListasToTableFondoBlanco()
		{
			session_start();
			$lista = new Lista();
			$listas = $lista->buscalistas($_SESSION["correo"]);
			$retornar = "";
			for($i=0; $i<$listas->size(); $i++)
			{
				$retornar .= "<tr class='miborde grisoscuro'>";
				$retornar .= "<td class='mi-padding-11px col-xs-2'>";
				$retornar .= "	<div class='pull-left'><input onclick='agregaestabase(".$listas->get($i)->getId().")' type='checkbox' name='bdcheckbd".$listas->get($i)->getId()."' id='bdcheckbd".$listas->get($i)->getId()."'>".$listas->get($i)->getNombre()."</div>";
				$retornar .= "<td>";
				$retornar .= "<div class='pull-right margin-right-15px'>".$listas->get($i)->getCantidad()."</div>";
				$retornar .= "</td>";
				$retornar .= "</td>";
				$retornar .= "</tr>";
			}
			return $retornar;
		}

		private function revisaKey()
		{
			session_start();
			$cazador = new Cazador();
			$cazador->setCuenta($_SESSION["correo"]);
			return $cazador->revisaKey();
		}

		private function noGenerada()
		{
			$retornar = "Aún no tienes clave para usar tu Airpost Cazador<br>";
			$retornar .= "<button type='button' class='btn btn-success' name='botonGeneraKey' id='botonGeneraKey' onclick='generaKeyCazador()'>Generar Clave</button>";
			return $retornar;
		}

		public function generada($key)
		{
			$retornar = "En tu sitio web debes copiar y pegar el siguiente código, justo antes del texto &lt;/head&gt;<br>";
			$retornar .= "<pre><code>&lt;script type='text/javascript'&gt;<br>";
			$retornar .= "var airpost_cazador_public_key='".$key."';<br>";
			$retornar .= "var airpost_cazador_public_validation='".md5($_SESSION["correo"])."';<br>";
			$retornar .= "&lt;/script&gt;</code><br>";
			$retornar .= "<code>&lt;script type='text/javascript' src='http://localhost/airpost/cazador/airpost-cazador.js'&gt;&lt;/script&gt;</code></pre><br><br>";
			$retornar .= "Si por alguna razón tu clave no funciona, puedes generar una nueva";
			$retornar .= "<button type='button' class='btn btn-success' name='botonGeneraKey' id='botonGeneraKey' onclick='generaKeyCazador()'>Generar Nueva Clave</button>";
			return $retornar;
		}

		private function obtieneKey()
		{
			$cazador = new Cazador();
			$cazador->setCuenta($_SESSION["correo"]);
			return $cazador->retornaKey();
		}
	}	
?>