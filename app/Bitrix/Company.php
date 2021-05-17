<?php

namespace App\Bitrix;
use \App\Helper;

class Company 
{
	protected $endpoint = [];
	public $endpoints = [			
		'crm.company.add',
		'crm.company.delete',
		'crm.company.fields',
		'crm.company.get',
		'crm.company.list',
		'crm.company.update',
		'crm.company.userfield.add',
		'crm.company.userfield.get',
		'crm.company.userfield.list',
		'crm.company.userfield.update',
		'crm.company.userfield.delete',
		'crm.company.contact.add',
		'crm.company.contact.delete',
		'crm.company.contact.fields',
		'crm.company.contact.items.delete',
		'crm.company.contact.items.get',
		'crm.company.contact.items.set',
		'onCrmCompanyAdd',
		'onCrmCompanyUpdate',
		'onCrmCompanyDelete',
		'onCrmCompanyUserFieldAdd',
		'onCrmCompanyUserFieldUpdate',
		'onCrmCompanyUserFieldDelete',
		'onCrmCompanyUserFieldSetEnumValues',
	];
    function __construct(){
        foreach ($this->endpoints as $endpoint){
            $this->endpoint[$endpoint] = Helper::URL_WEBHOOK.$endpoint.'.json';
        }
    }	
	public function crm_company_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_delete($params){
		return Helper::request([ 
			'url'	=> $this->endpoint['crm.company.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.get'],
			'method'=> 'POST',
			'params'=> $params
		]); 
	}
	public function crm_company_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_userfield_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.userfield.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_userfield_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.userfield.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_userfield_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.userfield.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_userfield_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.userfield.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_userfield_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.userfield.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_items_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.items.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_items_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.items.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_company_contact_items_set($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.company.contact.items.set'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyUserFieldAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyUserFieldAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyUserFieldUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyUserFieldUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyUserFieldDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyUserFieldDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmCompanyUserFieldSetEnumValues($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmCompanyUserFieldSetEnumValues'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
}