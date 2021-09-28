<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * Shop related functions
 * @author Teamtweaks
 * 
 */

class Wishlists extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form','email'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('product_model','shop');
		$this->load->model('city_model');
		if($_SESSION['sMainCategories'] == ''){
			$sortArr1 = array('field'=>'cat_position','type'=>'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->shop->get_all_details(CATEGORY,array('rootID'=>'0','status'=>'Active'),$sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		
		if($_SESSION['sColorLists'] == ''){
			$_SESSION['sColorLists'] = $this->shop->get_all_details(LIST_VALUES,array('list_id'=>'1'));
		}
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
	 	if ($this->data['loginCheck'] != ''){
			$this->data['WishlistUserDetails'] = $this->shop->get_all_details(USERS,array('id'=>$this->checkLogin('U')));
	 		$this->data['likedProducts'] = $this->shop->get_all_details(PRODUCT_LIKES,array('user_id'=>$this->checkLogin('U')));
	 	}
    }
	
    
	public function index(){
	
		$this->data['heading'] = 'Wish Lists';
		$paginationNo = $_POST['paginationId'];
		if($paginationNo == '') $paginationNo = 0;
		$pageLimitStart = $paginationNo;
		$perpage = $this->config->item('wishlist_pagination_per_page');
		//$this->data['productList'] = $this->product_model->get_product_details_wishlist($Rental_id);
		$this->data['WishListCat'] = $this->product_model->get_list_details_wishlistShow($this->data['loginCheck'],$pageLimitStart,$perpage);
		
		$this->load->view('site/user/wishlist-home',$this->data);
    }

    public function load_wishlist_pagination()
    {
    	$paginationNo = $this->input->post('page');

		$perpage = $this->config->item('wishlist_pagination_per_page');
		$start = ceil($this->input->get('page') * $perpage) - $perpage;
		$get_wishlist = $this->product_model->get_wishlist($this->data['loginCheck'],$start,$perpage);

		$res_content ='';

		if($get_wishlist->num_rows()>0){
			$count=0;
			foreach($get_wishlist->result() as $wlist )
   			{
   				
   				if($wlist->last_added!='0'){
   						$CountExperience = 0;
					$products 		=	explode(',',$wlist->product_id);
					$productsNotEmy =	array_filter($products);
					$CountProduct1	=	count($productsNotEmy);

					if($experienceExistCount>0)
					{
						$experiences 		= 	explode(',',$wlist->experience_id);
						$experienceNotEmy	=	array_filter($experiences);
						$CountExperience	=	count($experienceNotEmy);
					}
					$totCount = $CountProduct1 + $CountExperience;	

					$imgPath = 'images/site/empty-wishlist.jpg';
					if($wlist->last_added=='1'){
						$CountProduct = $this->shop->get_all_details(PRODUCT,array('id'=>end($productsNotEmy)))->num_rows(); 
						if($CountProduct > 0){ 
							$ProductsImg = $this->shop->get_all_details(PRODUCT_PHOTOS,array('product_id'=>end($productsNotEmy))); 
							if($ProductsImg->row()->product_image!=''){
							 $imgPath = base_url().PRODUCTPATH.$ProductsImg->row()->product_image;
							}
							else{
								$imgPath = 'images/product/dummyProductImage.jpg';
							}
						}
						
					}else if($experienceExistCount>0){
						 if($wlist->last_added=='2'){
							$CountProduct = $this->shop->get_all_details(EXPERIENCE,array('experience_id'=>end($experienceNotEmy)))->num_rows(); 
							if($CountProduct > 0){ 
								$ProductsImg = $this->shop->get_all_details(EXPERIENCE_PHOTOS,array('product_id'=>end($experienceNotEmy))); 
								if($ProductsImg->row()->product_image!=''){
								 $imgPath = base_url().EXPERIENCEPATH.$ProductsImg->row()->product_image;
								}
								else{
									$imgPath = 'images/product/dummyProductImage.jpg';}
							}
						}
					}

					$res_content.='<li  class="wishlists-list-item has-photo-pile">
								<div class="photo-heart-container">
								<div class="photo-pile">
								<div class="matte-media-box">
								<div class="top-matte-box">
										<div class="pull-left">
											<i class="fa fa-bed" aria-hidden="true"></i> <span class="mywish">';$res_content.=$wlist->name;$res_content.='</span>
										</div>
										<div class="pull-right">
										<a href="user/'.$loginCheck.'/wishlists/'.$wlist->id.'">
										<span class="color-gray font-tiny listings-count listt"><i class="fa fa-heart" aria-hidden="true"></i>';
										if($this->lang->line('Listings') != '') { $res_content.=stripslashes($this->lang->line('Listings')); } else$res_content.= "Listings";
					$res_content .= '</span></a></div></div><div class="bottom-matte-box">
										<a href="user/'.$loginCheck.'/wishlists/'.$wlist->id.'"><img class="wish-main-img" alt="'.$wlist->name.'" src="'.$imgPath.'"/></a></div>';					

					$res_content.='</div></div></div></li>';
   				}
   				else{
   					$res_content .='<li  class="wishlists-list-item has-photo-pile">
                            <div class="photo-heart-container">
                                <div class="photo-pile">
                                  <div class="matte-media-box">
                          <div class="top-matte-box">         
					  	<div class="pull-left">
					  			<i class="fa fa-bed" aria-hidden="true"></i> <span class="mywish">';
					  			$res_content .=$wlist->name;
					  			$res_content .='</span>
					  	</div>
					  	<div class="pull-right">
					  		
					  <span class="color-gray font-tiny listings-count listt">0';if($this->lang->line('Listings') != '') { $res_content .=stripslashes($this->lang->line('Listings')); } else $res_content .="Listings";
					  $res_content .='</span>
					  	</div></div>
						<div class="bottom-matte-box">
					  	<img alt="Vacation Places" src="images/site/empty-wishlist.jpg" class="wish-main-img"></div>
					 

                                                                    </div>
                                  
                                </div>
                             
                            </div>
                    
                          </li>';
   				}
   			}
		}
		else{

		}

		echo $res_content;
    }
	
	/**
	 * 
	 * This function delete the wishlist record from db
	 */
	public function DeleteWishList(){
		if ($this->checkLogin('U') == ''){
			redirect(base_url());
		}else {
			
			$product_id = $this->input->post('pid');
			
			$id = $this->input->post('wid');
			$condition = array('id' => $id);
			$this->data['WishListCat'] = $this->product_model->get_all_details(LISTS_DETAILS,$condition);
			if($this->data['WishListCat']->row()->product_id !=''){
				$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);
				
				$my_array = array_filter($WishListCatArr);
				$to_remove =(array)$product_id;
				$result = array_diff($my_array, $to_remove);
				$resultStr =implode(',',$result);
				if($resultStr!='')
				{		
				$this->product_model->updateWishlistRentals(array('product_id' =>$resultStr),$condition);
				$res['result']='0';
				}else {
					$this->product_model->updateWishlistRentals(array('product_id' =>$resultStr),$condition);
					$res['result']='1';
				}
			//print_r($result);die;
			}
			
			//$this->setErrorMessage('success','Wish list deleted successfully');
			/*echo '<script>window.history.go(-1);</script>';*/
		}echo json_encode($res);
	}
	
}
/*End of file cms.php */
/* Location: ./application/controllers/site/product.php */