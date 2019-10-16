<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo de Productos - Tablas
 */
class M_products extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}

	function __listTypes($customer_id) {
		$this->db->select('id, type_product');
		$this->db->where('customer_id', $customer_id);
		$this->db->where('status', '1');
		$qListTypes = $this->db->get('types_product');
		return $qListTypes->result_array();
	}

	function __listBrands($customer_id) {
		$this->db->select('id, brand');
		$this->db->where('customer_id', $customer_id);
		$this->db->where('status', '1');
		$qListBrands = $this->db->get('brands');
		return $qListBrands->result_array();
	}

	function __listSuppliers($customer_id) {
		$this->db->select('id, supplier');
		/*$this->db->where('customer_id', $customer_id); // Proveedor por Cliente*/
		$this->db->where('status', '1');
		$qListSuppliers = $this->db->get('suppliers');
		return $qListSuppliers->result_array();
	}

	function __getComission($customer_id) {
		$this->db->select('comission');
		$this->db->where('id', $customer_id);
		$qComission = $this->db->get('customers');
		return $qComission->result_array();
	}

	function __listProducts($customer_id) {
		$this->db->select('p.id, b.brand, t.type_product, p.model, p.code, p.product, p.price_sale');
		$this->db->join('brands b', 'p.brand_id = b.id');
		$this->db->join('types_product t', 'p.type_product_id = t.id');
		$this->db->where('p.customer_id', $customer_id);
		$this->db->where('p.status', '1');
		$this->db->order_by('p.id', 'ASC');
		$qListProducts = $this->db->get('products p');
		return $qListProducts->result_array();
	}

	function __newProduct($postData) {
		$this->db->trans_begin();
		$data = array(
			'customer_id' => $postData['customer'], 
			'model' => $postData['modelo'], 
			'code' => $postData['codigo'], 
			'product' => $postData['producto'], 
			'description' => $postData['descripcion'], 
			'status' => 1
		);
		/*Agregar Tipo de Producto*/
		if (is_numeric($postData['tipo'])) {
			$data['type_product_id'] = $postData['tipo'];
		} else {
			$dataType = array(
				'customer_id' => $postData['customer'], 
				'type_product' => $postData['tipo'], 
				'status' => 1
			);

			$this->db->insert('types_product', $dataType);

			$this->db->select('id');
			$this->db->where('customer_id', $postData['customer']);
			$this->db->where('type_product', $postData['tipo']);
			$this->db->where('status', '1');
			$qidType = $this->db->get('types_product');

			if ($row = $qidType->row()) {
				$data['type_product_id'] = $row->id;
			}
		}
		/*Agregar Marca*/
		if (is_numeric($postData['marca'])) {
			$data['brand_id'] = $postData['marca'];
		} else {
			$dataBrand = array(
				'customer_id' => $postData['customer'], 
				'brand' => $postData['marca'], 
				'status' => 1
			);

			$this->db->insert('brands', $dataBrand);

			$this->db->select('id');
			$this->db->where('customer_id', $postData['customer']);
			$this->db->where('brand', $postData['marca']);
			$this->db->where('status', '1');
			$qidBrand = $this->db->get('brands');

			if ($row = $qidBrand->row()) {
				$data['brand_id'] = $row->id;
			}
		}

		$this->db->set('modified', 'NOW()', FALSE);
		$this->db->insert('products', $data);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __viewProduct($postData) {
		$this->db->select('id AS codP, type_product_id AS tipo, brand_id AS marca, model AS modelo, code AS codigo, product AS producto, description AS descripcion');
		$this->db->where('id', $postData['id']);
		$qverCustomer = $this->db->get('products');
		return $qverCustomer->result_array();
	}

	function __editProduct($postData) {
		$dataCustomer = array(
			'type_product_id' => $postData['eTipo'], 
			'brand_id' => $postData['eMarca'], 
			'code' => $postData['eCodigo'], 
			'model' => $postData['eModelo'], 
			'product' => $postData['eProducto'], 
			'description' => $postData['descripcion']
		);

		$this->db->trans_begin();
		$this->db->set('modified', 'NOW()', FALSE);
		$this->db->update('products', $dataCustomer, array('id' => $postData['eCodP']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __deleteProduct($postData) {
		$this->db->trans_begin();
		$this->db->delete('products', array('id' => $postData['id']));

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __viewCost($postData) {
		$this->db->select('id AS codPP, coin AS moneda, price_cost AS costo');
		$this->db->where('supplier_id', $postData['proveedor']);
		$this->db->where('product_id', $postData['producto']);
		$this->db->where('status', '1');
		$qcost = $this->db->get('supp_prod_prices');
		return $qcost->result_array();
	}

	function __newEditCost($postData) {
		$this->db->trans_begin();
		$data = array(
			'product_id' => $postData['producto'], 
			'supplier_id' => $postData['proveedor'], 
			'coin' => $postData['cMoneda'], 
			'price_cost' => $postData['precioCosto'], 
			'status' => 1
		);

		$this->db->set('modified', 'NOW()', FALSE);

		if ($postData['eCodPP'] == '') {
			$this->db->insert('supp_prod_prices', $data);
		} else {
			$resCambios = $this->__verifChangeCost($this->input->post());
			if ($resCambios > 0) {
				return 'warning';
			} else {
				$this->db->update('supp_prod_prices', $data, array('id' => $postData['eCodPP']));
			}
		}

		/*Actualizando Precio de Venta*/
		$resComision = $this->__getComission($postData['customer']);
		$this->__updatePVenta($resComision[0]['comission'], $postData['producto']);

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __deleteCost($postData) {
		$this->db->trans_begin();
		if ($postData['id'] != '' && $postData['id'] > 0) {
			$this->db->delete('supp_prod_prices', array('id' => $postData['id']));
		} else {
			return 'Error: Not found.';
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __verifChangeCost($postData) {
		$this->db->from('supp_prod_prices');
		$this->db->where('id', $postData['eCodPP']);
		$this->db->where('supplier_id', $postData['proveedor']);
		$this->db->where('product_id', $postData['producto']);
		$this->db->where('coin', "BINARY '".$postData['cMoneda']."'", FALSE);
		$this->db->where('price_cost', $postData['precioCosto']);
		$this->db->where('status', '1');

		return $this->db->count_all_results();
	}

	public function __updatePVenta($comision, $product_id) {
		$this->db->trans_begin();
		
		if (!is_null($comision)) {
			$this->db->select('spp.coin, spp.price_cost, p.price_sale');
			$this->db->join('products p', 'spp.product_id = p.id');
			$this->db->where('spp.product_id', $product_id);
			$this->db->where('spp.status', '1');
			$this->db->order_by('spp.price_cost', 'DESC');
			$qmaxCost = $this->db->get('supp_prod_prices spp', 1);
			$dataSale = '';
			if ($qmaxCost->num_rows() > 0) {
				if ($comision != 0 && !empty($comision)) {
					foreach ($qmaxCost->result() as $row) {
						$newPSale = $row->price_cost * (1 + $comision / 100);
						$dataSale = array(
							'price_sale' => $newPSale, 
							'coin' => $row->coin
						);
					}
				} else {
					$dataSale = array(
						'price_sale' => 0, 
						'coin' => ''
					);
				}
				$this->db->update('products', $dataSale, array('id' => $product_id));
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __viewSale($postData) {
		$this->db->select('coin, price_sale');
		$this->db->where('id', $postData['producto']);
		$qsale = $this->db->get('products');
		return $qsale->result_array();
	}

	function __costProv($postData) {
		$this->db->select('s.supplier, spp.coin, spp.price_cost');
		$this->db->join('suppliers s', 'spp.supplier_id = s.id');
		$this->db->where('spp.product_id', $postData['producto']);
		$this->db->where('spp.status', '1');
		$qCosts = $this->db->get('supp_prod_prices spp');
		return $qCosts->result_array();
	}

	function __changePricesSale($postData) {
		$this->db->trans_begin();
		
		$this->db->from('customers');
		$this->db->where('id', $postData['customer']);
		$this->db->where('comission', $postData['comision']);
		$totalReg = $this->db->count_all_results();

		if ($totalReg == 0) {
			$this->db->update('customers', array('comission' => $postData['comision']), array('id' => $postData['customer']));

			$this->db->select('id');
			$this->db->where('customer_id', $postData['customer']);
			$this->db->where('status', '1');
			$qProducts = $this->db->get('products');

			foreach ($qProducts->result() as $row) {
				$this->__updatePVenta($postData['comision'], $row->id);
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
	}

	function __editPSale($postData) {
		$this->db->trans_begin();

		$data = array(
			'price_sale' => $postData['precioVenta'], 
			'coin' => $postData['vMoneda'], 
		);


		$this->db->from('products');
		$this->db->where('id', $postData['producto']);
		$this->db->where('price_sale', $postData['precioVenta']);
		$this->db->where('coin', "BINARY '".$postData['vMoneda']."'", FALSE);
		$resCambios = $this->db->count_all_results();

		if ($resCambios > 0) {
			return 'warning';
		} else {
			$this->db->set('modified', 'NOW()', FALSE);
			$this->db->update('products', $data, array('id' => $postData['producto']));
		}

		if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
		} else {
      $this->db->trans_commit();
		}
	}

	function __verifChanges($postData) {
		$this->db->from('products');
		$this->db->where('id', $postData['eCodP']);
		$this->db->where('customer_id', $postData['eCustomer']);
		$this->db->where('type_product_id', $postData['eTipo']);
		$this->db->where('brand_id', $postData['eMarca']);
		$this->db->where('model', "BINARY '".$postData['eModelo']."'", FALSE);
		$this->db->where('code', "BINARY '".$postData['eCodigo']."'", FALSE);
		$this->db->where('product', "BINARY '".$postData['eProducto']."'", FALSE);
		$this->db->where('description', "BINARY '".$postData['descripcion']."'", FALSE);

		return $this->db->count_all_results();
	}

	function __verifUnique($postData, $op) {
		$resError = '';
		if ($op == 'edit') {
			$data = array(
				array('table' => 'products', 'id' => $postData['eCodP'], 'customer_id' => $postData['eCustomer'], 'type_id' => $postData['eTipo'], 'brand_id' => $postData['eMarca'], 'field' => 'code', 'value' => $postData['eCodigo'], 'label' => 'El Código'),
				/*array('table' => 'products', 'id' => $postData['eCodP'], 'customer_id' => $postData['eCustomer'], 'type_id' => $postData['eTipo'], 'brand_id' => $postData['eMarca'], 'field' => 'model', 'value' => $postData['eModelo'], 'label' => 'El Modelo')*/
			);
		} else {
			$data = array(
				array('table' => 'products', 'customer_id' => $postData['customer'], 'type_id' => $postData['tipo'], 'brand_id' => $postData['marca'], 'field' => 'code', 'value' => $postData['codigo'], 'label' => 'El Código'),
				/*array('table' => 'products', 'customer_id' => $postData['customer'], 'type_id' => $postData['tipo'], 'brand_id' => $postData['marca'], 'field' => 'model', 'value' => $postData['modelo'], 'label' => 'El Modelo')*/
			);
		}

		for ($i=0; $i < count($data); $i++) {
			$resError .= $this->__validateUnique($i, $data, $op);
		}

		return $resError;
	}

	function __validateUnique($i, $data, $op) {
		if ($op == 'edit') {
			$this->db->where('id <>', $data[$i]['id']);
		}
		$this->db->where($data[$i]['field'], $data[$i]['value']);
		$this->db->where('customer_id', $data[$i]['customer_id']);
		$this->db->where('type_product_id', $data[$i]['type_id']);
		$this->db->where('brand_id', $data[$i]['brand_id']);
		$num = $this->db->count_all_results($data[$i]['table']);
		$msj = '';

		if ($num > 0) {
			$msj = $data[$i]['label'] . ' ya existe.|';
		}
		return $msj;
	}
}