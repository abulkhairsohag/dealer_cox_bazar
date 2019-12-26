$product_info .='<tr> <td> <input type="text" class="form-control main_product_id product_id" name="product_id[]" readonly="" value="';
			$product_info .=$product_id;
			$product_info .= '"> </td> <td><input type="text" class="form-control main_products_name products_name"  name="products_name[]" readonly="" value="';
			$product_info .=$name;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_loaded_packet loaded_packet" name="loaded_packet[]" readonly="" value="';
			$product_info .=$loaded_packet;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_loaded_offer_qty loaded_offer_qty" name="loaded_offer_qty[]" readonly="" value="';
			$product_info .=$loaded_offer_qty;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_sold_packet sold_packet" name="sold_packet[]" readonly="" value="';
			$product_info .=$sold_packet;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_sold_offer_qty sold_offer_qty" name="sold_offer_qty[]" readonly="" value="';
			$product_info .=$sold_offer_qty;
			$product_info .= '"></td>';

			$product_info .=  '<td><input type="text" class="form-control main_back_packet back_packet" name="back_packet[]" readonly="" value="';
			$product_info .=$back_packet;
			$product_info .= '"></td>';

			$product_info .= ' <td><input type="text"   class="form-control main_back_offer_qty back_offer_qty" id="back_offer_qty" name="back_offer_qty[]" readonly=""  value="';
			$product_info .=$back_offer_qty;
			$product_info .= '" > </td> </tr>';

			
	               
		}
		$product_info .= ' </tbody>  </table>';
		$product_info .= '<input type="hidden" name="load_id" id="load_id" value="';
					$product_info .= $truck_load_tbl_id ;
					$product_info .='">';