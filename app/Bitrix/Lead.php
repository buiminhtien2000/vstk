<?php

namespace App\Bitrix;
use \App\Helper;

class Lead
{
	protected $endpoint = [];
	public $endpoints = [			
		'crm.lead.add',
		'crm.lead.delete',
		'crm.lead.fields',
		'crm.lead.get',
		'crm.lead.list',
		'crm.lead.productrows.get',
		'crm.lead.productrows.set',
		'crm.lead.update',
		'crm.lead.userfield.add',
		'crm.lead.userfield.get',
		'crm.lead.userfield.list',
		'crm.lead.userfield.update',
		'crm.lead.userfield.delete',
		'onCrmLeadAdd',
		'onCrmLeadUpdate',
		'onCrmLeadDelete',
		'onCrmLeadUserFieldAdd',
		'onCrmLeadUserFieldUpdate',
		'onCrmLeadUserFieldDelete',
		'onCrmLeadUserFieldSetEnumValues',
	];
    function __construct($portal){
        foreach ($this->endpoints as $endpoint){
            $this->endpoint[$endpoint] = Helper::$url_webhook.$endpoint.'.json';
        }
    }
	
	public function crm_lead_add($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.add'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_delete($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.delete'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_fields($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.fields'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_get($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.get'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_list($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.list'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_productrows_get($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.productrows.get'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_productrows_set($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.productrows.set'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_update($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.update'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_userfield_add($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.userfield.add'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_userfield_get($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.userfield.get'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_userfield_list($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.userfield.list'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_userfield_update($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.userfield.update'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function crm_lead_userfield_delete($params){
		return Helper::request([
			'url'		=> $this->endpoint['crm.lead.userfield.delete'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadAdd($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadAdd'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadUpdate($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadUpdate'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadDelete($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadDelete'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadUserFieldAdd($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadUserFieldAdd'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadUserFieldUpdate($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadUserFieldUpdate'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadUserFieldDelete($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadUserFieldDelete'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
	public function onCrmLeadUserFieldSetEnumValues($params){
		return Helper::request([
			'url'		=> $this->endpoint['onCrmLeadUserFieldSetEnumValues'],
			'method'	=> 'POST',
			'params'	=> $params
		]);
	}
}