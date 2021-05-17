<?php

namespace App\Bitrix;
use \App\Helper;

class Contact
{
	protected $endpoint = [];
	public $endpoints = [			
		'crm.contact.add',
		'crm.contact.delete',
		'crm.contact.fields',
		'crm.contact.get',
		'crm.contact.list',
		'crm.contact.update',
		'crm.contact.company.add',
		'crm.contact.company.delete',
		'crm.contact.company.fields',
		'crm.contact.company.items.delete',
		'crm.contact.company.items.get',
		'crm.contact.company.items.set',
		'crm.contact.userfield.add',
		'crm.contact.userfield.get',
		'crm.contact.userfield.list',
		'crm.contact.userfield.update',
		'crm.contact.userfield.delete',
		'onCrmContactAdd',
		'onCrmContactUpdate',
		'onCrmContactDelete',
		'onCrmContactUserFieldAdd',
		'onCrmContactUserFieldUpdate',
		'onCrmContactUserFieldDelete',
		'onCrmContactUserFieldSetEnumValues',
	];
    function __construct(){
        foreach ($this->endpoints as $endpoint){
            $this->endpoint[$endpoint] =  Helper::URL_WEBHOOK.$endpoint.'.json';
        }
    }	
	public function crm_contact_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.delete'], 
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_items_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.items.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_items_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.items.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_company_items_set($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.company.items.set'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_userfield_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.userfield.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_userfield_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.userfield.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_userfield_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.userfield.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_userfield_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.userfield.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_contact_userfield_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.contact.userfield.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactUserFieldAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactUserFieldAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactUserFieldUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactUserFieldUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactUserFieldDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactUserFieldDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmContactUserFieldSetEnumValues($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmContactUserFieldSetEnumValues'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
}