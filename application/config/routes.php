<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['inicio'] = 'frontend/c_principal';
$route['aplicaciones'] = 'frontend/c_principal/apps';

$route['acceso'] = 'backend/private/c_login';
$route['ingresar'] = 'backend/private/c_login/logIn';
$route['recuperar'] = 'backend/private/c_login/recoverPass';
$route['salir'] = 'backend/private/c_login/logOut';

$route['perfil'] = 'backend/private/c_profile';
$route['perfil/ver'] = 'backend/private/c_profile/viewProfile';
$route['perfil/modificar'] = 'backend/private/c_profile/editProfile';
$route['perfil/guardarClave'] = 'backend/private/c_profile/savePassword';
$route['perfil/guardarFoto'] = 'backend/private/c_profile/saveAvatar';

$route['convertidor'] = 'backend/apps/c_converter';
$route['convertidor/subir'] = 'backend/apps/c_converter/uploadFileExcel';
$route['convertidor/descargar'] = 'backend/apps/c_converter/downloadFileTxt';
$route['convertidor/lista'] = 'backend/apps/c_converter/listHistoryXT';
$route['convertidor/eliminar'] = 'backend/apps/c_converter/deleteRecordHistory';

$route['cronogramas'] = 'backend/apps/c_schedules';
$route['cronogramas/ver'] = 'backend/apps/c_schedules/viewScheduleId';
$route['agenda'] = 'backend/apps/c_agenda';
$route['agenda/cargarEventos'] = 'backend/apps/c_agenda/listEvents';
$route['agenda/nuevoEvento'] = 'backend/apps/c_agenda/newEvent';
$route['agenda/editarEvento'] = 'backend/apps/c_agenda/editEvent';
$route['agenda/editarFecha'] = 'backend/apps/c_agenda/editDateEvent';
$route['agenda/eliminarEvento'] = 'backend/apps/c_agenda/deleteEvent';
$route['agenda/actualizarEventos'] = 'backend/apps/c_agenda/updateEvents';
$route['agenda/eliminarEventos'] = 'backend/apps/c_agenda/deleteEvents';


$route['clientes'] = 'backend/tables/c_customers';
$route['clientes/nuevaEmpresa'] = 'backend/tables/c_customers/newCompany';
$route['clientes/verEmpresa'] = 'backend/tables/c_customers/viewCompany';
$route['clientes/modificarEmpresa'] = 'backend/tables/c_customers/editCompany';
$route['clientes/eliminarEmpresa'] = 'backend/tables/c_customers/deleteCompany';
$route['clientes/nuevaPerNatural'] = 'backend/tables/c_customers/newPerNatural';
$route['clientes/verPerNatural'] = 'backend/tables/c_customers/viewPerNatural';
$route['clientes/modificarPerNatural'] = 'backend/tables/c_customers/editPerNatural';
$route['clientes/eliminarPerNatural'] = 'backend/tables/c_customers/deletePerNatural';

$route['proveedores'] = 'backend/tables/c_suppliers';
$route['proveedores/nuevoProveedor'] = 'backend/tables/c_suppliers/newSupplier';
$route['proveedores/verProveedor'] = 'backend/tables/c_suppliers/viewSupplier';
$route['proveedores/modificarProveedor'] = 'backend/tables/c_suppliers/editSupplier';
$route['proveedores/eliminarProveedor'] = 'backend/tables/c_suppliers/deleteSupplier';

$route['productos'] = 'backend/tables/c_products';
$route['productos/nuevoProducto'] = 'backend/tables/c_products/newProduct';
$route['productos/verProducto'] = 'backend/tables/c_products/viewProduct';
$route['productos/modificarProducto'] = 'backend/tables/c_products/editProduct';
$route['productos/eliminarProducto'] = 'backend/tables/c_products/deleteProduct';
$route['productos/verCosto'] = 'backend/tables/c_products/viewCost';
$route['productos/guardarCosto'] = 'backend/tables/c_products/newEditCost';
$route['productos/eliminarCosto'] = 'backend/tables/c_products/deleteCost';
$route['productos/verPVenta'] = 'backend/tables/c_products/viewSale';
$route['productos/guardarPVenta'] = 'backend/tables/c_products/editPSale';

$route['admClientes'] = 'backend/admin/c_customers';
$route['admClientes/nuevo'] = 'backend/admin/c_customers/newCustomer';
$route['admClientes/ver'] = 'backend/admin/c_customers/viewCustomer';
$route['admClientes/modificar'] = 'backend/admin/c_customers/editCustomer';
$route['admClientes/eliminar'] = 'backend/admin/c_customers/deleteCustomer';

$route['admCronograma'] = 'backend/admin/c_schedules';
$route['admCronograma/subir'] = 'backend/admin/c_schedules/uploadScheduleExcel';
$route['admCronograma/lista'] = 'backend/admin/c_schedules/listSchedules';
$route['admCronograma/ver'] = 'backend/admin/c_schedules/viewSchedule';
$route['admCronograma/cambiaEstado'] = 'backend/admin/c_schedules/changeStatusSchedule';
$route['admCronograma/eliminar'] = 'backend/admin/c_schedules/deleteSchedule';

$route['admUsuarios'] = 'backend/admin/c_users';
$route['admUsuarios/nuevo'] = 'backend/admin/c_users/newUser';
$route['admUsuarios/ver'] = 'backend/admin/c_users/viewUser';
$route['admUsuarios/modificar'] = 'backend/admin/c_users/editUser';
$route['admUsuarios/eliminar'] = 'backend/admin/c_users/deleteUser';
$route['admUsuarios/nuevoCliente'] = 'backend/admin/c_users/redirectCustomers';
$route['admUsuarios/verRolesUsuario'] = 'backend/admin/c_users/viewRolesUser';
$route['admUsuarios/guardarRolesUsuario'] = 'backend/admin/c_users/saveRolesUser';

$route['admPermisos'] = 'backend/admin/c_permits';
$route['admPermisos/nuevoModulo'] = 'backend/admin/c_permits/newModule';
$route['admPermisos/verModulo'] = 'backend/admin/c_permits/viewModule';
$route['admPermisos/modificarModulo'] = 'backend/admin/c_permits/editModule';
$route['admPermisos/eliminarModulo'] = 'backend/admin/c_permits/deleteModule';
$route['admPermisos/cambiarModuloActivo'] = 'backend/admin/c_permits/changeStatusModule';
$route['admPermisos/nuevoRol'] = 'backend/admin/c_permits/newRole';
$route['admPermisos/verRol'] = 'backend/admin/c_permits/viewRole';
$route['admPermisos/modificarRol'] = 'backend/admin/c_permits/editRole';
$route['admPermisos/eliminarRol'] = 'backend/admin/c_permits/deleteRole';
$route['admPermisos/cambiarRolActivo'] = 'backend/admin/c_permits/changeStatusRole';
$route['admPermisos/nuevoPerfil'] = 'backend/admin/c_permits/newProfile';
$route['admPermisos/verPerfil'] = 'backend/admin/c_permits/viewProfile';
$route['admPermisos/modificarPerfil'] = 'backend/admin/c_permits/editProfile';
$route['admPermisos/eliminarPerfil'] = 'backend/admin/c_permits/deleteProfile';
$route['admPermisos/cambiarPerfilActivo'] = 'backend/admin/c_permits/changeStatusProfile';
$route['admPermisos/verModulosPerfil'] = 'backend/admin/c_permits/viewModulesProfile';
$route['admPermisos/guardarModulosPerfil'] = 'backend/admin/c_permits/saveModulesProfile';
$route['admPermisos/guardarRolesModulo'] = 'backend/admin/c_permits/saveRolesModule';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*$route['cronogramaEmpresas'] = 'backend/apps/c_schedule_companies';
$route['cronogramaEmpresas/nuevo'] = 'backend/apps/c_schedule_companies/newCompany';
$route['cronogramaEmpresas/ver'] = 'backend/apps/c_schedule_companies/viewCompany';
$route['cronogramaEmpresas/modificar'] = 'backend/apps/c_schedule_companies/editCompany';
$route['cronogramaEmpresas/eliminar'] = 'backend/apps/c_schedule_companies/deleteCompany';

$route['admClientesCliente'] = 'backend/admin/c_customersCustomer';
$route['admClientesCliente/nuevaEmpresa'] = 'backend/admin/c_customersCustomer/newCompany';
$route['admClientesCliente/verEmpresa'] = 'backend/admin/c_customersCustomer/viewCompany';
$route['admClientesCliente/modificarEmpresa'] = 'backend/admin/c_customersCustomer/editCompany';
$route['admClientesCliente/eliminarEmpresa'] = 'backend/admin/c_customersCustomer/deleteCompany';
$route['admClientesCliente/nuevaPerNatural'] = 'backend/admin/c_customersCustomer/newPerNatural';
$route['admClientesCliente/verPerNatural'] = 'backend/admin/c_customersCustomer/viewPerNatural';
$route['admClientesCliente/modificarPerNatural'] = 'backend/admin/c_customersCustomer/editPerNatural';
$route['admClientesCliente/eliminarPerNatural'] = 'backend/admin/c_customersCustomer/deletePerNatural';*/
