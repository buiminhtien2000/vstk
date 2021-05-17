<?php

namespace App\Bitrix;
use \App\Helper;

class Deal
{
	protected $endpoint = [];
	public $endpoints = [			
		'crm.deal.add',
		'crm.deal.delete',
		'crm.deal.fields',
		'crm.deal.get',
		'crm.deal.list',
		'crm.deal.productrows.get',
		'crm.deal.productrows.set',
		'crm.deal.recurring.add',
		'crm.deal.recurring.delete',
		'crm.deal.recurring.expose',
		'crm.deal.recurring.fields',
		'crm.deal.recurring.get',
		'crm.deal.recurring.list',
		'crm.deal.recurring.update',
		'crm.deal.update',
		'crm.deal.userfield.add',
		'crm.deal.userfield.get',
		'crm.deal.userfield.update',
		'crm.deal.userfield.delete',
		'crm.deal.userfield.list',
		'crm.deal.contact.add',
		'crm.deal.contact.fields',
		'crm.deal.contact.items.get',
		'crm.deal.contact.items.set',
		'crm.deal.contact.items.delete',
		'crm.deal.contact.delete',
		'crm.dealcategory.default.set',
		'crm.dealcategory.default.get',
		'onCrmDealAdd',
		'onCrmDealUpdate',
		'onCrmDealDelete',
		'onCrmDealUserFieldAdd',
		'onCrmDealUserFieldUpdate',
		'onCrmDealUserFieldDelete',
		'onCrmDealUserFieldSetEnumValues',
		'onCrmDealRecurringAdd',
		'onCrmDealRecurringDelete',
		'onCrmDealRecurringExpose',
		'crm.dealcategory.add',
		'crm.dealcategory.delete',
		'crm.dealcategory.fields',
		'crm.dealcategory.get',
		'crm.dealcategory.list',
		'crm.dealcategory.stage.list',
		'crm.dealcategory.status',
		'crm.dealcategory.update',
	];
	function __construct(){
        foreach ($this->endpoints as $endpoint){
            $this->endpoint[$endpoint] = Helper::URL_WEBHOOK.$endpoint.'.json';
        }
    }
	
	public function crm_deal_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_productrows_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.productrows.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_productrows_set($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.productrows.set'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_expose($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.expose'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_recurring_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.recurring.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_userfield_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.userfield.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_userfield_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.userfield.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_userfield_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.userfield.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_userfield_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.userfield.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_userfield_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.userfield.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_items_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.items.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_items_set($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.items.set'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_items_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.items.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_deal_contact_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.deal.contact.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_default_set($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.default.set'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_default_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.default.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealUserFieldAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealUserFieldAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealUserFieldUpdate($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealUserFieldUpdate'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealUserFieldDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealUserFieldDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealUserFieldSetEnumValues($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealUserFieldSetEnumValues'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealRecurringAdd($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealRecurringAdd'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealRecurringDelete($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealRecurringDelete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function onCrmDealRecurringExpose($params){
		return Helper::request([
			'url'	=> $this->endpoint['onCrmDealRecurringExpose'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_add($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.add'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_delete($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.delete'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_fields($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.fields'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_get($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.get'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_stage_list($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.stage.list'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_status($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.status'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
	public function crm_dealcategory_update($params){
		return Helper::request([
			'url'	=> $this->endpoint['crm.dealcategory.update'],
			'method'=> 'POST',
			'params'=> $params
		]);
	}
}