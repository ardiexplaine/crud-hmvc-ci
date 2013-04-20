<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends MX_Controller {

/*
| -------------------------------------------------------------------
| Ardie xpLaiNe CodeIgniter Version 2.1.3              			    |
| -------------------------------------------------------------------
| Arthor    : Wahyu Ardie                                           |
| Contoh 	: Penerapan Operasi CRUD dengan konsep HMVC CodeIgniter |
| Website   : http://indielabstudio.com						        |
| -------------------------------------------------------------------
*/

	public function __construct()
	{
		parent::__construct();
		$this->load->model('crud_model');
	}
	 
	public function index()
	{
		$data['main_content'] = $this->crud_model->tampil();
		$this->load->view('view_crud', $data);
	}
	
	public function add()
	{
		$data['form_action'] = 'add';
		
		// Melihat NIK yang di inputkan sudah ada blom dalam database
		// Jika sudah ada maka operasi gagal
		if ($this->crud_model->cek_nik($this->input->post('nik')) == TRUE)
			{
				$this->session->set_flashdata('ok',' Karyawan dengan NIK '.$this->input->post('nik').' sudah terdaftar');
				redirect('crud/crud/add');
			}
		else
			{
				// Jika benar maka akan diinputkan ke dalam databse
				$this->form_validation->set_rules('nik','nik','required');
				$this->form_validation->set_rules('nama','nama','required');
				$this->form_validation->set_rules('kelamin','kelamin','required');
				$this->form_validation->set_rules('status','status','required');
				
				if($this->form_validation->run() == TRUE){
			
					$this->crud_model->add();
					$this->session->set_flashdata('ok','Satu data berhasil disimpan!');
					redirect('crud/crud/index');
				}
			}
		
		$this->load->view('form_crud', $data);
	}
	
	public function edit($nik = NULL)
	{	
		$data['form_action']= site_url('crud/crud/edit/'. $nik);
		$data['nilai'] = $this->crud_model->tampil_by_id($nik);
		
		// Jika benar maka akan diinputkan ke dalam databse\
		$this->form_validation->set_rules('nama','nama','required');
		$this->form_validation->set_rules('kelamin','kelamin','required');
		$this->form_validation->set_rules('status','status','required');
		
		if($this->form_validation->run() == TRUE){
	
			$this->crud_model->edit($nik);
			$this->session->set_flashdata('ok','Satu data berhasil disimpan!');
			redirect('crud/crud/index');
		}
			
		$this->load->view('form-edit_crud', $data);
	}
	
	public function delete($nik = NULL)
	{
		$this->crud_model->delete($nik);
		$this->session->set_flashdata('ok','Satu data berhasil dihapus!');
		redirect('crud/crud/index');
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */