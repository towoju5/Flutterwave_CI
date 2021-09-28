<?php
class contactform extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->library(array('session', 'form_validation', 'email'));
        $this->load->model('insert_model');
    }

    function index()
    {
        //set validation rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|callback_alpha_space_only');
        $this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

        //run validation on form input
        if ($this->form_validation->run() == FALSE)
        {
            //validation fails
            $this->load->view('contact_form_view');
        }
        else
        {
            //get the form data
            $name = $this->input->post('name');
            $from_email = $this->input->post('email');
            $phone = $this->input->post('phone');
            //$subject = $this->input->post('subject');
            $msg = $this->input->post('message');
            $data = array('username' => $name,
                          'phone' => $phone,
                          'message1' => $msg,
                          'email' => $from_email);
            $this->insert_model->form_insert($data);//insert into database
            $message = $this->load->view('emails/design.php',$data,TRUE);

            //configure email settings

           $config = array(
             'protocol' => 'smtp',
             'smtp_host' => 'smtp.laravelecommerce.com',
             'smtp_port' => 465,
             'smtp_user' => 'sales@laravelecommerce.com', // change it to yours
             'smtp_pass' => 'laravelEcommerce', // change it to yours
             'charset' => 'iso-8859-1',
             'wordwrap' => TRUE,
             'mailtype' => 'html'
          );  //use double quotes
            //$this->load->library('email', $config);
            //$this->email->initialize($config);                        

            //send mail
            $this->load->library('email', $config);
            $this->email->from($from_email, $name);
            $this->email->to("mohan@pofitec.com");
            $this->email->cc("maheswaran@pofitec.com");
            $this->email->bcc("kailashkumar.r@pofitec.com");
            $this->email->subject("HomeStayDNN Demo");
            $this->email->set_mailtype("html");
            //$body = $this->load->view('emails/design.php',$data,TRUE);
            $this->email->message($message);

            if($this->email->send())
            {
                // mail sent
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your mail has been sent successfully!</div>');
                
                redirect('/');
            }
            else
            {
                //error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">There is error in sending mail! Please try again later</div>');
                redirect('default_controller');
            }
                

        }
    }

    // public function insert_data()
    // {
    //     $data = array('username' => $name,
    //                       'phone' => $phone,
    //                       'message1' => $msg,
    //                       'email' => $from_email);
    //     $this->insert_model->form_insert($data);
    //     $this->load->view('site/templates/header', $data);
    // }
    
    //custom validation function to accept only alphabets and space input
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/",$str))
        {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
?>