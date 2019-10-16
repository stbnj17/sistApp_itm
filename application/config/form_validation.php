<?php
	$config = array(
		'c_login/logIn' => array(
			array(
				'field' => 'user', 
				'label' => 'Usuario', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'pass', 
				'label' => 'Contraseña', 
				'rules' => 'trim|required|max_length[255]|xss_clean'
			)
		), 

		'c_login/recoverPass' => array(
			array(
				'field' => 'email', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|xss_clean'
			)
		), 

		'c_profile/editProfile' => array(
			array(
				'field' => 'eName', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eSurname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdoc', 
				'label' => 'N° de Documento', 
				'rules' => 'trim|required|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eOccupation', 
				'label' => 'Ocupación', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhone', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_profile/savePassword' => array(
			array(
				'field' => 'user', 
				'label' => 'Usuario', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'pass', 
				'label' => 'Contraseña Actual', 
				'rules' => 'trim|required|max_length[255]|xss_clean'
			), 
			array(
				'field' => 'nPass', 
				'label' => 'Nueva Contraseña', 
				'rules' => 'trim|required|max_length[255]|xss_clean'
			), 
			array(
				'field' => 'rNpass', 
				'label' => 'Repita Contraseña', 
				'rules' => 'trim|required|matches[nPass]|max_length[255]|xss_clean'
			)
		), 

		'c_customers/newCustomer' => array(
			array(
				'field' => 'name', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'surname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDoc', 
				'label' => 'N° de Documento', 
				'rules' => 'trim|required|numeric|max_length[20]|is_unique[customers.num_doc]|xss_clean'
			), 
			array(
				'field' => 'occupation', 
				'label' => 'Ocupación', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|is_unique[customers.email]|xss_clean'
			), 
			array(
				'field' => 'phone', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_customers/editCustomer' => array(
			array(
				'field' => 'eName', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eSurname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdoc', 
				'label' => 'N° de Documento', 
				'rules' => 'trim|required|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eOccupation', 
				'label' => 'Ocupación', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhone', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_users/newUser' => array(
			array(
				'field' => 'customer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|is_unique[users.customer_id]|xss_clean'
			), 
			array(
				'field' => 'user', 
				'label' => 'Usuario', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9]*$/u]|max_length[100]|is_unique[users.username]|xss_clean'
			), 
			array(
				'field' => 'pass', 
				'label' => 'Contraseña', 
				'rules' => 'trim|required|max_length[255]|xss_clean'
			), 
			array(
				'field' => 'rPass', 
				'label' => 'Repita Contraseña', 
				'rules' => 'trim|required|matches[pass]|max_length[255]|xss_clean'
			)
		), 

		'c_users/editUser' => array(
			array(
				'field' => 'eCustomer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'eUser', 
				'label' => 'Usuario', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePass', 
				'label' => 'Contraseña', 
				'rules' => 'trim|max_length[255]|xss_clean'
			), 
			array(
				'field' => 'eRpass', 
				'label' => 'Repita Contraseña', 
				'rules' => 'trim|matches[ePass]|max_length[255]|xss_clean'
			)
		), 

		'c_customers/newCompany' => array(
			array(
				'field' => 'nameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'direccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'telfOtro', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'contacto', 
				'label' => 'Contacto (1°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => 'Correo (1°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'phone', 
				'label' => 'Teléfono (1°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'contactoOtro', 
				'label' => 'Contacto (2°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'emailOtro', 
				'label' => 'Correo (2°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'phoneOther', 
				'label' => 'Teléfono (2°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_customers/editCompany' => array(
			array(
				'field' => 'eNameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'eDireccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eTelfOtro', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eContacto', 
				'label' => 'Contacto (1°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo (1°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhone', 
				'label' => 'Teléfono (1°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eContactoOtro', 
				'label' => 'Contacto (2°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmailOtro', 
				'label' => 'Correo (2°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhoneOther', 
				'label' => 'Teléfono (2°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_customers/newPerNatural' => array(
			array(
				'field' => 'name', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'surname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de DNI / RUC', 
				'rules' => 'trim|required|numeric|min_length[8]|max_length[11]|xss_clean'
			), 
			array(
				'field' => 'direccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => '1° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'telfOtro', 
				'label' => '2° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => '1° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'emailOtro', 
				'label' => '2° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		), 

		'c_customers/editPerNatural' => array(
			array(
				'field' => 'eName', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eSurname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de DNI / RUC', 
				'rules' => 'trim|required|numeric|min_length[8]|max_length[11]|xss_clean'
			), 
			array(
				'field' => 'eDireccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => '1° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eTelfOtro', 
				'label' => '2° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => '1° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmailOtro', 
				'label' => '2° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		),

		'c_schedules/uploadScheduleExcel' => array(
			array(
				'field' => 'date', 
				'label' => 'Periodo', 
				'rules' => 'trim|required|xss_clean'
			)
		), 

		'c_converter/uploadFileExcel' => array(
			array(
				'field' => 'nameFile', 
				'label' => 'Nombre del Archivo de Texto', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			),
			array(
				'field' => 'nameSheet', 
				'label' => 'Nombre de la Hoja', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'startCol', 
				'label' => 'Inicio de Columna', 
				'rules' => 'trim|alpha|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'endCol', 
				'label' => 'Fin de Columna', 
				'rules' => 'trim|alpha|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'startRow', 
				'label' => 'Inicio de Fila', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'endRow', 
				'label' => 'Fin de Fila', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_suppliers/newSupplier' => array(
			array(
				'field' => 'proveedor', 
				'label' => 'Proveedor', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'direccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'web', 
				'label' => 'Sitio Web', 
				'rules' => 'trim|valid_url|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => 'Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		), 

		'c_suppliers/editSupplier' => array(
			array(
				'field' => 'eProveedor', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'eDireccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'web', 
				'label' => 'Sitio Web', 
				'rules' => 'trim|valid_url|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		), 

		'c_products/newProduct' => array(
			array(
				'field' => 'tipo', 
				'label' => 'Tipo', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'marca', 
				'label' => 'Marca', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'codigo', 
				'label' => 'Código', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9-]*$/u]|max_length[50]|xss_clean'
			), 
			array(
				'field' => 'modelo', 
				'label' => 'Modelo', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúü A-ZÑÁÉÍÓÚÜ_0-9#-\/]*$/u]|max_length[50]|xss_clean'
			), 
			array(
				'field' => 'producto', 
				'label' => 'Producto', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 :+"().,_-]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => "trim|max_length[200]|xss_clean"
			)
		), 

		'c_products/editProduct' => array(
			array(
				'field' => 'eTipo', 
				'label' => 'Tipo', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'eMarca', 
				'label' => 'Marca', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'eCodigo', 
				'label' => 'Código', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9-]*$/u]|max_length[50]|xss_clean'
			), 
			array(
				'field' => 'eModelo', 
				'label' => 'Modelo', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúü A-ZÑÁÉÍÓÚÜ_0-9#-\/]*$/u]|max_length[50]|xss_clean'
			), 
			/*array(
				'field' => 'ePrecioVenta', 
				'label' => 'Precio Venta', 
				'rules' => 'trim|decimal|xss_clean'
			), */
			array(
				'field' => 'eProducto', 
				'label' => 'Producto', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 :+"().,_-]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => 'trim|max_length[200]|xss_clean'
			)
		), 

		'c_products/newEditCost' => array(
			array(
				'field' => 'producto', 
				'label' => 'Producto', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'proveedor', 
				'label' => 'Proveedor', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'cMoneda', 
				'label' => 'Moneda', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'precioCosto', 
				'label' => 'Precio Costo', 
				'rules' => array('trim', 'required', 'greater_than_equal_to[0]', 'regex_match[/^[[0-9]+|[0-9]+.[0-9]+]*$/u]', 'xss_clean')
			)
		), 

		'c_products/viewSale' => array(
			array(
				'field' => 'producto', 
				'label' => 'Producto', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'comision', 
				'label' => 'Comisión', 
				'rules' => 'trim|numeric|greater_than_equal_to[0]|less_than_equal_to[100]|required|xss_clean'
			)
		), 

		'c_products/editPSale' => array(
			array(
				'field' => 'comision', 
				'label' => 'Comisión', 
				'rules' => 'trim|numeric|greater_than_equal_to[0]|less_than_equal_to[100]|required|xss_clean'
			), 
			array(
				'field' => 'producto', 
				'label' => 'Producto', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'vMoneda', 
				'label' => 'Moneda', 
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'precioVenta', 
				'label' => 'Precio Venta', 
				'rules' => array('trim', 'required', 'greater_than_equal_to[0]', 'regex_match[/^[[0-9]+|[0-9]+.[0-9]+]*$/u]', 'xss_clean')
			)
		), 

		'c_permits/newModule' => array(
			array(
				'field' => 'modulo', 
				'label' => 'Módulo', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[50]|is_unique[u_modules.module]|xss_clean'
			), 
			array(
				'field' => 'ruta', 
				'label' => 'Ruta', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ\/]*$/u]|max_length[100]|xss_clean'
			)
		), 

		'c_permits/editModule' => array(
			array(
				'field' => 'modulo', 
				'label' => 'Módulo', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[50]|xss_clean'
			), 
			array(
				'field' => 'ruta', 
				'label' => 'Ruta', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ\/]*$/u]|max_length[100]|xss_clean'
			)
		), 

		'c_permits/newRole' => array(
			array(
				'field' => 'rol', 
				'label' => 'Rol', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[20]|is_unique[u_roles.role]|xss_clean'
			)
		), 

		'c_permits/editRole' => array(
			array(
				'field' => 'rol', 
				'label' => 'Rol', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[20]|xss_clean'
			)
		), 

		'c_permits/newProfile' => array(
			array(
				'field' => 'perfil', 
				'label' => 'Perfil', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[50]|is_unique[u_profiles.profile]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => 'trim|max_length[200]|xss_clean'
			)
		), 

		'c_permits/editProfile' => array(
			array(
				'field' => 'perfil', 
				'label' => 'Perfil', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[50]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => 'trim|max_length[200]|xss_clean'
			)
		), 

		'c_agenda/newEvent' => array(
			array(
				'field' => 'titulo', 
				'label' => 'Título', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 \/.,_-]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => 'trim|max_length[500]|xss_clean'
			)
		), 

		'c_agenda/editEvent' => array(
			array(
				'field' => 'titulo', 
				'label' => 'Título', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 \/.,_-]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'descripcion', 
				'label' => 'Descripción', 
				'rules' => 'trim|max_length[500]|xss_clean'
			)
		), 

		/*'c_schedule_companies/newCompany' => array(
			array(
				'field' => 'nameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_schedule_companies/editCompany' => array(
			array(
				'field' => 'eNameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo', 
				'rules' => 'trim|required|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		)*/

		/*'c_customersCustomer/newCompany' => array(
			array(
				'field' => 'customer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'nameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'direccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'telfOtro', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'contacto', 
				'label' => 'Contacto (1°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => 'Correo (1°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'phone', 
				'label' => 'Teléfono (1°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'contactoOtro', 
				'label' => 'Contacto (2°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'emailOtro', 
				'label' => 'Correo (2°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'phoneOther', 
				'label' => 'Teléfono (2°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_customersCustomer/editCompany' => array(
			array(
				'field' => 'eCustomer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'eNameEmpresa', 
				'label' => 'Razón Social', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 .]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de RUC', 
				'rules' => 'trim|required|numeric|exact_length[11]|xss_clean'
			), 
			array(
				'field' => 'eDireccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eTelfOtro', 
				'label' => 'Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eContacto', 
				'label' => 'Contacto (1°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => 'Correo (1°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhone', 
				'label' => 'Teléfono (1°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eContactoOtro', 
				'label' => 'Contacto (2°)', 
				'rules' => 'trim|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmailOtro', 
				'label' => 'Correo (2°)', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'ePhoneOther', 
				'label' => 'Teléfono (2°)', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			)
		), 

		'c_customersCustomer/newPerNatural' => array(
			array(
				'field' => 'pnCustomer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'name', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'surname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'nDocumento', 
				'label' => 'N° de DNI / RUC', 
				'rules' => 'trim|required|numeric|min_length[8]|max_length[11]|xss_clean'
			), 
			array(
				'field' => 'direccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'telf', 
				'label' => '1° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'telfOtro', 
				'label' => '2° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'email', 
				'label' => '1° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'emailOtro', 
				'label' => '2° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		), 

		'c_customersCustomer/editPerNatural' => array(
			array(
				'field' => 'ePnCustomer', 
				'label' => 'Cliente', 
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'eName', 
				'label' => 'Nombre', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eSurname', 
				'label' => 'Apellidos', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eNdocumento', 
				'label' => 'N° de DNI / RUC', 
				'rules' => 'trim|required|numeric|min_length[8]|max_length[11]|xss_clean'
			), 
			array(
				'field' => 'eDireccion', 
				'label' => 'Dirección', 
				'rules' => 'trim|required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ_0-9 °.,_-]*$/u]|max_length[200]|xss_clean'
			), 
			array(
				'field' => 'eTelf', 
				'label' => '1° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eTelfOtro', 
				'label' => '2° Teléfono', 
				'rules' => 'trim|numeric|max_length[20]|xss_clean'
			), 
			array(
				'field' => 'eEmail', 
				'label' => '1° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			), 
			array(
				'field' => 'eEmailOtro', 
				'label' => '2° Correo', 
				'rules' => 'trim|valid_email|max_length[100]|xss_clean'
			)
		),*/
	);