<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to mobile Json management
 * @author Teamtweaks
 *
 */
class Mobile_model extends My_Model
{
  public function __construct(){
    parent::__construct();
  }
  /*
  * $table name of the table
  * $condition array of where conditions
  * $columnlist name of the coloums separated by comma(,) and enclosed with ` symbol.
  */
  public function get_column_details($table='',$condition='',$columnlist=''){
    $this->db->select($columnlist);
    $this->db->from($table);
    $this->db->where($condition);
    return $this->db->get();
  }
  public function insertUserQuick($firstname='',$lastname='',$email='',$pwd='',$expireddate,$key=''){
    $dataArr = array(
      'firstname' =>  $firstname,
      'lastname'  =>  $lastname,
      'user_name' =>  $firstname,
      'group'   =>  'User',
      'email'   =>  $email,
      'password'  =>  md5($pwd),
      'status'  =>  'Active',
      'expired_date'  =>  $expireddate,
      'is_verified'=> 'No',
      'created' =>  mdate($this->data['datestring'],time()),
      'through' => 'mobile',
      'mobile_key'=> $key
    );
    $this->simple_insert(USERS,$dataArr);
  }
  public function add_wishlist_category($dataArr=''){
      $this->db->insert(LISTS_DETAILS,$dataArr);
      return $this->db->insert_id();
  }
/* City details home page */
  public function Featured_city(){
    $this->db->select('u.*,u.seourl as cityurl,count(u.id) as NCount, st.name as state_name');
    $this->db->from(CITY.' as u');
    $this->db->join(STATE_TAX.' as st' , 'st.id = u.stateid','LEFT');
    $this->db->join(NEIGHBORHOOD.' as n' , 'u.id = n.neighborhoods','LEFT');
    $this->db->where('u.status','Active','u.featured','1');
    $this->db->where('u.featured','1');
    $this->db->group_by('u.id');
    $this->db->order_by('u.view_order');
    $city = $this->db->get();
    return $city;
  }
public function get_transaction_details($email){
$this->db->select('c.*,r.currencycode as currency_code,TRIM(cr.currency_symbols) as currency_symbol');
$this->db->from(RENTALENQUIRY.' as r');
$this->db->join(COMMISSION_TRACKING.' as c' , 'c.booking_no= r.Bookingno');
$this->db->join(CURRENCY.' as cr' , 'cr.currency_type= r.currencycode');
$this->db->where('c.host_email',$email);
$currency= $this->db->get();
return $currency;

}
  /* Inbox notification message */
  public function json_get_med_messages($userId)
  {
    $this->db->select('M.*,U.image,U.firstname');
    $this->db->from(MED_MESSAGE .' as M');
    $this->db->join(USERS.' as U' , 'U.id = M.senderId','LEFT');
    $this->db->where_in('receiverId',$userId);
    $this->db->group_by('bookingNo');
    $this->db->order_by('dateAdded', 'desc');
    $resultArr = $this->db->get();
    //echo $this->db->last_query();die;
    return $resultArr;
    
  }
  /* Future Transaction */
  public function get_future_transaction($email)
  {
    $this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.id as product_id, P.product_title, P.price, RQ.Bookingno, CT.total_amount as totalAmt, CT.guest_fee, CT.host_fee, CT.payable_amount');
    $this->db->from(COMMISSION_TRACKING.' as CT');
    $this->db->join(RENTALENQUIRY.' as RQ' , 'RQ.Bookingno = CT.booking_no','LEFT');
    $this->db->join(PRODUCT.' as P' , 'P.id = RQ.prd_id','LEFT');
    $this->db->join(USERS.' as U' , 'U.id = RQ.user_id','LEFT');
    $this->db->where('CT.host_email',$email);
    $this->db->where('CT.paid_status','no');
    $this->db->order_by('CT.dateAdded', 'desc');
    return $resultArr = $this->db->get();
  }
  /* Completed Transaction */
  public function get_completed_transaction($email)
  {
    $this->db->select('dateAdded, transaction_id ,amount');
    $this->db->from(COMMISSION_PAID.' as CP');
    $this->db->where('CP.host_email',$email);
    //$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
    $this->db->order_by('CP.dateAdded', 'desc');
    return $resultArr = $this->db->get();
  }
  /* User Review ABout You */
  function get_productreview_aboutyou($user_id='')
  {
    $this->db->select('r.review,u.email,r.total_review,u.image,u.loginUserType,u.user_name,r.dateAdded');
    $this->db->from(REVIEW.' as r');
    $this->db->where('r.user_id', $user_id);
    $this->db->join(PRODUCT.' as p',"r.product_id=p.id");
    $this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
    return $query = $this->db->get_where();
  }
  /* User Review By You */
  function get_productreview_byyou($user_id='')
  {
    $this->db->select('r.review,u.email,r.total_review,u.image,u.loginUserType,r.dateAdded');
    $this->db->from(REVIEW.' as r');
    $this->db->where('r.reviewer_id', $user_id);
    $this->db->join(PRODUCT.' as p',"r.product_id=p.id");
    $this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
    return $query = $this->db->get_where();
  }
  /* dispute By You */
  function get_productdispute_byyou($user_id='')
  {
    $this->db->select('d.message,d.booking_no,u.image,u.email,u.loginUserType,d.created_date');
    $this->db->from(DISPUTE.' as d');
    $this->db->where('d.user_id', $user_id);
    $this->db->join(PRODUCT.' as p',"d.prd_id=p.id");
    $this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");
    return $query = $this->db->get_where();
  }
  /* dispute about You */
  function get_productdispute_aboutyou($user_id='')
  {
    $this->db->select('d.message,d.booking_no,u.image,u.email,u.loginUserType,d.created_date');
    $this->db->from(DISPUTE.' as d');
    $this->db->where('d.disputer_id', $user_id);
    $this->db->join(PRODUCT.' as p',"d.prd_id=p.id");
    $this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");
    return $query = $this->db->get_where();
  }
  
  public function edit_rentalbooking($dataArr='',$condition=''){
    //$this->db->cache_on();
      $this->db->where($condition);
      $this->db->update(RENTALENQUIRY,$dataArr);
  }
  
  public function get_booking_details($bookingNo){
    $this->db->cache_on();
    $this->db->reconnect();
    $this->db->select('rq.id, rq.checkin, rq.checkout, rq.Bookingno, rq.subTotal, rq.serviceFee, rq.totalAmt, rq.NoofGuest, rq.renter_id, rq.secDeposit, p.product_title, p.currency,rq.user_id,rq.prd_id,u.user_name as requester_name,u.loginUserType as requester_login_type,u.image as  requester_image,r.user_name as host_name,r.loginUserType as host_login_type,r.image as  host_image,rq.totalAmt,rq.approval,rq.currencycode,u.created');
    $this->db->from(RENTALENQUIRY.' as rq');
    $this->db->join(PRODUCT.' as p',"p.id=rq.prd_id","left");
    $this->db->join(USERS.' as u',"u.id=rq.user_id","LEFT");
    $this->db->join(USERS.' as r',"r.id=rq.renter_id","LEFT");
    $this->db->where('Bookingno', $bookingNo);
    return $query = $this->db->get();
  }
  public function get_dashboard_list($condition = '',$Cont2 = ''){
  
    $this->db->select('p.*,pp.product_image,pa.lat as latitude,s.data as shedule,hs.payment_status,pa.address');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");
    $this->db->join('schedule as s',"s.id=p.id","LEFT");
    $this->db->join(HOSTPAYMENT.' as hs',"hs.product_id=p.id","LEFT");
    $this->db->where_in('p.user_id',$condition);
    if($Cont2!=''){
      $this->db->where('p.status',$Cont2);
    }
    $this->db->group_by('p.id');
    $this->db->order_by('p.id','desc');
    
    return $query = $this->db->get();
      
  }
  public function get_list_details_wishlist($condition = ''){
    
     $select_qry = "select id,name,product_id from ".LISTS_DETAILS." where user_id=".$condition."  or user_id=0"; 
    $productList = $this->ExecuteQuery($select_qry);
    //echo $this->db->last_query(); die;
    return $productList;
  }
  public function get_product_details_wishlist_one_category($condition = ''){
    $this->db->select('pa.city as name, p.product_name, p.currency, p.product_title, p.room_type, p.accommodates, p.bedrooms, p.bathrooms, p.price,p.user_id, n.id as nid, n.notes, p.id, pa.address, pa.zip as post_code,p.currency');
    $this->db->from(PRODUCT.' as p');
    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
    $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");
    $this->db->join(NOTES.' as n',"n.product_id=p.id","LEFT");
    $this->db->where_in('p.id',$condition);
    $this->db->group_by('p.id');
    $this->db->order_by('pp.imgPriority','asc');
    return $query = $this->db->get();
  }
  public function get_wishlistphoto($condition = '')
  {
    $this->db->select('product_image,product_id');
    $this->db->from(PRODUCT_PHOTOS);
    $this->db->where('product_id',$condition);
    return $query = $this->db->get();
  }
  /* booking mail functionality */
  public function getbookeduser_detail($id) {
    //$this->db->cache_on();
    //$this->db->reconnect();
      $this->db->select('rq.Bookingno,rq.numofdates as noofdates,rq.checkin as checkin,rq.checkout as checkout,rq.renter_id as renter_id,p.price as price,u.email as email,u.user_name as name,p.product_title as productname,p.id as prd_id');
    $this->db->from(RENTALENQUIRY.' as rq');    
    $this->db->join(USERS.' as u',"u.id=rq.user_id","LEFT");
    $this->db->join(PRODUCT.' as p',"p.id=rq.prd_id","LEFT");
    $this->db->where('rq.id',$id);
    $this->db->limit(15, 0);
    return $query = $this->db->get();
  }

  public function update_wishlist($userid='',$dataStr='',$condition1=''){
    $this->db->cache_on();
    $sel_qry = "select product_id,id from ".LISTS_DETAILS." where user_id=".$userid."";
    $ListVal = $this->ExecuteQuery($sel_qry);
    
    if($ListVal->num_rows() > 0){
      //exit("if");
      foreach($ListVal->result() as $wlist){
      $productArr=@explode(',',$wlist->product_id);
        if(!empty($productArr)){
          if(in_array($dataStr,$productArr)){
          $conditi = array('id' => $wlist->id);
            //$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);
            $my_array = array_filter($productArr);
            $to_remove =(array)$dataStr;
            $result = array_diff($my_array, $to_remove);
            
            $resultStr =implode(',',$result);

            /* $newdata = array('fav'=>0);
            $condition = array('id'=>$dataStr);
            $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );
            */
            $this->updateWishlistRentals(array('product_id' =>$resultStr),$conditi);
          }
        }
      }
    }
    
    if(!empty($condition1)){
      //exit("else");
      //foreach($condition1 as $wcont){
        $select_qry = "select product_id from ".LISTS_DETAILS." where id=".$condition1."";
        $productList = $this->ExecuteQuery($select_qry);
        $productIdArr=explode(',',$productList->row()->product_id);
    
        if(!empty($productIdArr)){
          if(!in_array($dataStr,$productIdArr)){
            $select_qry = "update ".LISTS_DETAILS." set product_id=concat(product_id,',".$dataStr."') where id=".$condition1."";
            $productList = $this->ExecuteQuery($select_qry);
            /* $newdata = array('fav'=>1);
            $condition = array('id'=>$dataStr);
            $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );
            */
          }
        }
      //}
    }
  }

  public function updateWishlistRentals($dataArr='',$condition=''){
    $this->db->cache_on();
      $this->db->where($condition);
      $this->db->update(LISTS_DETAILS,$dataArr);
  }

  public function update_wishlist_property($property_id='',$user_id='',$wishlist_id='')
  {
    $select_qry = "select product_id from ".LISTS_DETAILS." where id=".$wishlist_id."";
    $productList = $this->ExecuteQuery($select_qry);
    $productIdArr=explode(',',$productList->row()->product_id);

    if(!empty($productIdArr)){
      if(!in_array($property_id,$productIdArr)){
        $select_qry = "update ".LISTS_DETAILS." set product_id=concat(product_id,',".$property_id."') where id=".$wishlist_id."";
        $productList = $this->ExecuteQuery($select_qry);

        $select_pro_qry = "update ".PRODUCT." set fav=1 where id=".$property_id."";
        $productwishList = $this->ExecuteQuery($select_pro_qry);
      }
    }
  }
  /* REMOVE WISHLIST PROPERTY */
  public function remove_wishlist_property ($property_id='',$user_id='',$wishlist_id='')
  {

    //$sel_qry = "select product_id,id from ".LISTS_DETAILS." where id=".$wishlist_id."";
    $sel_qry = "select product_id,id from ".LISTS_DETAILS." where find_in_set(".$property_id.",product_id)";
    $ListVal = $this->ExecuteQuery($sel_qry);
    
    if($ListVal->num_rows() > 0){
      //exit("if");
      foreach($ListVal->result() as $wlist){
      $productArr=@explode(',',$wlist->product_id);
        if(!empty($productArr)){
          if(in_array($property_id,$productArr)){
          $conditi = array('id' => $wlist->id);
            //$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);
            $my_array = array_filter($productArr);
            $to_remove =(array)$property_id;
            $result = array_diff($my_array, $to_remove);
            
            $resultStr =implode(',',$result);
            $select_pro_qry = "update ".PRODUCT." set fav=0 where id=".$property_id."";
            $productwishList = $this->ExecuteQuery($select_pro_qry);

            $this->updateWishlistRentals(array('product_id' =>$resultStr),$conditi);
          }
        }
      }
    }
  }
  /* Add Review */
  public function add_review($dataArr=''){
    return $this->db->insert(REVIEW,$dataArr);
  }

  /* ADD Dispute */
  public function add_dispute($dataArr=''){
    return $this->db->insert(DISPUTE,$dataArr);
  }
  /* Get Your Dispute */
  public function get_trip_dispute($bookingno='',$disputer_id='')

  {

    $this->db->cache_on();

    $this->db->select('d.*,u.firstname,u.lastname,u.image');

    $this->db->from(DISPUTE.' as d');

    $this->db->join(USERS.' as u',"u.id=d.user_id","LEFT");

    $this->db->where('d.booking_no',$bookingno);

    if($disputer_id !='')

    {

      $this->db->where('d.user_id',$disputer_id);

    }

    $query = $this->db->get();

    return $query;

  }
  public function get_trip_review($bookingno='',$reviewer_id='')
  {
    $this->db->cache_on();
    $this->db->select('p.*,u.firstname,u.lastname,u.image');
    $this->db->from(REVIEW.' as p');
    $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
    $this->db->where('p.bookingno',$bookingno);
    if($reviewer_id !='')
    {
      $this->db->where('p.reviewer_id',$reviewer_id);
    }
    $query = $this->db->get();
    return $query;
  }
  /* PROPERTY DETAILS REVIEW DETAILS */
  public function get_review($product_id,$reviewer_id='')
  {
    $this->db->cache_on();
    $this->db->select('p.*,u.firstname,u.lastname,u.image');
    $this->db->from(REVIEW.' as p');
    $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
    $this->db->where('p.product_id',$product_id);
    if($reviewer_id !='')
    {
    $this->db->where('p.reviewer_id',$reviewer_id);
    }
    $this->db->where('p.status','Active');
    $this->db->order_by('p.dateAdded','desc');
    $query = $this->db->get();
    return $query;
    //echo $this->db->last_query();die;
  }
  /* PROPERTY DETAILS REVIEW DETAILS */
  public function get_review_tot($product_id)
  {
    $this->db->cache_on();
    $this->db->select('AVG( total_review ) as tot_tot, AVG( accuracy ) as tot_acc, AVG( communication ) as tot_com, AVG( cleanliness ) as tot_cln, AVG( location ) as tot_loc, AVG( checkin ) as tot_chk, AVG( value ) as tot_val');
    $this->db->from(REVIEW);
    $this->db->where('product_id',$product_id);
    $query = $this->db->get();

    return $query;
  }
  
  
}