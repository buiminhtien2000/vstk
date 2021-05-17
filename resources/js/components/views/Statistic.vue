<template>
<div class="statistic">
    <div class="space"></div>
    <a-row>
        <a-col :span="11" class="custom_col">
            <div class="title">
                <p style="text-align:center;font-size:18px;font-weight400;color:white">Thống kê số lượng khách hàng</p>
            </div>
            <div class="pipeline">
                <select v-model="selected" v-if="list_pipeline" v-on:change="get_stage()">
                    <option>Chọn Pipeline</option>
                    <option v-for="(value, key) in list_pipeline" :key="key" v-bind:value="key">{{value}}</option>
                </select>
            </div>
            <div class="contain_stage">
                <div class="stage" v-if="list_stage" v-for="(value, key) in list_stage" :key="key">
                    <div class="name_stage">
                        {{key}}
                    </div>
                    <div class="quantity">
                        {{value}}
                    </div>
                </div>
            </div>
            <div class="total">
                <span class="title">Tổng số lượng:</span>
                <span class="quantity">20</span>
            </div>
            <div class="total">
                <span class="title">Tổng hoa hồng:</span>
                <span class="quantity" v-if="commission_deal_won.data">{{formatPrice(commission_deal_won.data.total_commission)}} VND</span>
            </div>
        </a-col>
        <a-col :span="11" class="custom_col">
            <div class="title">
                <p style="text-align:center;font-size:18px;font-weight400;color:white">Thống kê số lượng khách hàng</p>
            </div>
            <div class="contain_pipeline" id="commission" v-if="commission_deal_won.data">
                <div class="commission" v-for="(value, key) in commission_deal_won.data.detail" :key="value.id">
                    <div class="name_pipeline">
                        {{value.name}}
                    </div>
                    <div class="quantity">
                        {{formatPrice(value.commission)}} {{value.currentcy_id}} VND
                    </div>
                </div>
            </div>
            <div class="total">
                <span class="title">Tổng hoa hồng:</span>
                <span class="quantity" v-if="commission_deal_won.data">{{formatPrice(commission_deal_won.data.total_commission)}} {{commission_deal_won.data.detail[0].currentcy_id}} VND</span>
            </div>
        </a-col>
    </a-row>
    <div class="space"></div>
    <div class="custom_col custom_col_2" style="background-color: rgb(0, 0, 0, 0.3) !important">
        <div class="title">
            <p style="text-align:center;font-size:18px;font-weight400;color:white">Danh sách khách hàng</p>
        </div>
        <div class="list_customer">
            <div class="filter_search">
                <div class="search">
                    <a-input-search placeholder="Tìm kiếm" style="width: 200px" @search="onSearch" />
                </div>
                <div class="filter">
                    <a-form layout="inline" @submit="filter_data" :form="form">
                        <a-form-item :validate-status="from_date_error() ? 'error' : ''" :help="from_date_error() || ''">
                            <a-date-picker v-decorator="[
                                'from_date',
                                { rules: [{ required: true, message: 'Vui lòng nhập ngày!' }] },
                                ]" placeholder="Từ ngày" />
                        </a-form-item>
                        <a-form-item :validate-status="to_date_error() ? 'error' : ''" :help="to_date_error() || ''">
                            <a-date-picker v-decorator="[
                                'to_date',
                                { rules: [{ required: true, message: 'Vui lòng nhập ngày!' }] },
                                ]" placeholder="Đến ngày" id="to_date" />
                        </a-form-item>
                        <a-button type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())">
                            Lọc
                        </a-button>
                    </a-form>
                </div>
            </div>
            <a-table :columns="columns" :row-key="data.key" :data-source="data" :pagination="pagination" :loading="loading">
                <template slot="action" slot-scope="action"> <a v-on:click="showModal(action)">Chi tiết</a></template>
            </a-table>
        </div>
    </div>
    </a-row>
    <div>
        <a-modal v-model="visible" @ok="update_customer" @cancel="handleCancel" :okText="'Lưu'" :celText="'Chỉnh sửa'">
            <img :src="'../../images/logo-vstk.png'" style="display:block;margin:0 auto;width:100px"/>
            <div class="detail">
                <div style="color:black margin-bottom:10px">
                    <input type="text" class="disabled" :value="customer_detail.TITLE" id="title"/>
                    <input type="text" :value="customer_detail.ID" style="display:none" id="id_deal"/>
                    <input type="text" :value="customer_detail.CONTACT_ID" style="display:none" id="id_contact"/>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Tên khách hàng </div>
                    <div style="color:black"><input type="text" id="name"/></div>
                </div>
                <div style="color:black margin-bottom:10px" v-if="customer_detail_contact['PHONE']">
                    <div style="color:black;font-weight:500; margin-right:10px">Số điện thoại</div>
                    <div style="color:black" v-if="customer_detail_contact['PHONE'][0]"><input type="text" id="sdt" :value="customer_detail_contact['PHONE'][0]['VALUE']" /></div>
                </div>
                <div style="color:black margin-bottom:10px" v-if="customer_detail_contact['EMAIL']">
                    <div style="color:black;font-weight:500; margin-right:10px">E-mail: </div>
                    <div style="color:black" v-if="customer_detail_contact['EMAIL'][0]"><input type="text" :value="customer_detail_contact['EMAIL'][0]['VALUE']" id="email"/></div>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Địa chỉ: </div>
                    <div style="color:black"><input type="text" :value="customer_detail_contact['ADDRESS']" id="address"/></div>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Trạng thái</div>
                    <div style="color:black"><span>{{customer_detail.STAGE_ID}}</span></div>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Số tiền</div>
                    <div style="color:black"><span>{{formatPrice(customer_detail.OPPORTUNITY)}}</span></div>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Ngày tạo</div>
                    <div style="color:black"><span>{{customer_detail.DATE_CREATE}}</span></div>
                </div>
                <div style="color:black margin-bottom:10px">
                    <div style="color:black;font-weight:500; margin-right:10px">Pipeline</div>
                    <div style="color:black"><span>{{customer_detail.CATEGORY_ID}}</span></div>
                </div>
            </div>
        </a-modal>
    </div>
</div>
</template>

<script>
const url_get_pipeline = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_pipeline_by_user'
const url_get_sum_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/sum_customer'
const url_get_sum_commission = window.location.protocol + '//' + window.location.hostname + ':8000/api/sum_commission'
const url_get_customer_by_id = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_customer_by_id'
const url_get_contact_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_contact_customer'
const url_get_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_customer'
const url_filter_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/filter_customer'
const url_search_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/search_customer'
const url_update_customer = window.location.protocol + '//' + window.location.hostname + ':8000/api/update_customer'
const columns = [{
        title: 'STT',
        dataIndex: 'key',
        width: '6%',
    },
    {
        title: 'TÊN',
        dataIndex: 'name',
        width: '15%',
    },
    {
        title: 'TRẠNG THÁI',
        dataIndex: 'stage',
        width: '15%',
    },
    {
        title: 'GIÁ TRỊ DEAL',
        dataIndex: 'price',
        width: '15%',
    },
    {
        title: 'NGÀY TẠO',
        dataIndex: 'date',
        width: '15%',
    },
    {
        title: 'THAO TÁC',
        dataIndex: 'action',
        key: 'action',
        scopedSlots: { customRender: 'action' },
        width: '15%',

    },
];

function hasErrors(fieldsError) {
    return Object.keys(fieldsError).some(field => fieldsError[field]);
}
export default {
    created() {
        this.get_pipeline();
        this.get_commission();
        this.get_customer();
    },
    data() {
        return {
            data: [],
            pagination: {},
            loading: false,
            columns,
            visible: false,
            selected: '',
            list_pipeline: {},
            list_stage: {},
            commission_deal_won: {},
            list_customer: {},
            data_length: 1,
            id_customer: '',
            customer_detail: {},
            customer_detail_contact: {},
            hidden_input: true,
            hasErrors,
            form: this.$form.createForm(this, { name: 'horizontal_login' }),
        }
    },
    mounted() {
        this.$nextTick(() => {
            // To disabled submit button at the beginning.
            this.form.validateFields();
        });
    },
    methods: {
        update_customer(){
            var title = document.getElementById('title').value;
            var sdt = document.getElementById('sdt').value;
            var email = document.getElementById('email').value;
            var name = document.getElementById('name').value;
            var address = document.getElementById('address').value;
             var id_deal = document.getElementById('id_deal').value;
            var id_contact = document.getElementById('id_contact').value;
            var data = {
                title:title,
                sdt:sdt,
                email:email,
                name:name,
                address:address
            }
            this.request(url_update_customer, {
                        data:data,
                        id_deal:id_deal,
                        id_contact:id_contact,
                    }, function (response) {
                        if (response.error) {
                            this.$message.error(response.error)
                        } else {
                            this.$message.success(response.success)
                        }
                    }, 'POST')
        },
        from_date_error() {
            const { getFieldError, isFieldTouched } = this.form;
            return isFieldTouched('from_date') && getFieldError('from_date');
        },
        // Only show error after a field is touched.
        to_date_error() {
            const { getFieldError, isFieldTouched } = this.form;
            return isFieldTouched('to_date') && getFieldError('to_date');
        },
        filter_data(e) {
            this.loading = true;
            let that = this;
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    var from_date = new Date(values.from_date['_d'])
                    from_date = new Date(from_date.toLocaleDateString("en-US"))
                    from_date = from_date.getTime()/1000;
                    var to_date = new Date(values.to_date['_d'])
                    to_date = new Date(to_date.toLocaleDateString("en-US"))
                    to_date = to_date.getTime()/1000;
                    console.log(to_date)
                    this.request(url_filter_customer, {
                        from_date: from_date,
                        to_date:to_date,
                    }, function (response) {
                        if (response.error) {
                            this.$message.error(response.error)
                        } else {
                            response.forEach((value, key) => {
                                that.data.push({
                                    key: key + 1,
                                    name: value.TITLE,
                                    stage: value.STAGE_ID,
                                    date: that.formatDate(value.DATE_CREATE),
                                    price: that.formatPrice(value.OPPORTUNITY) + ' ' + value.CURRENCY_ID,
                                    action: value.ID,
                                })
                            })
                            that.loading = false;
                        }
                    }, 'POST')
                }
            });
        },
        onSearch(value) {
            this.loading = true;
            this.data = [];
            let that = this;
            this.request(url_search_customer, {
                key_work: value
            }, function (response) {
                if (response.error) {
                    this.$message.error(response.error)
                } else {
                    response.forEach((value, key) => {
                        that.data.push({
                            key: key + 1,
                            name: value.TITLE,
                            stage: value.STAGE_ID,
                            date: that.formatDate(value.DATE_CREATE),
                            price: that.formatPrice(value.OPPORTUNITY) + ' ' + value.CURRENCY_ID,
                            action: value.ID,
                        })
                    })
                    that.loading = false;
                }
            }, 'POST')

        },
        handleTableChange(pagination, sorter) {
            const pager = { ...this.pagination };
            pager.current = pagination.current;
            this.pagination = pager;
            this.fetch({
                results: pagination.pageSize,
                page: pagination.current,
                sortField: sorter.field,
                sortOrder: sorter.order,
                ...filters,
            });
        },
        showModal(id_deal) {
            this.visible = true;
            let that = this;
            this.request(url_get_customer_by_id, {
                id_deal: id_deal
            }, function (customer_by_id) {
                if (customer_by_id.error) {
                    this.$message.error(customer_by_id.error)
                } else {
                    that.customer_detail = customer_by_id;
                    that.request(url_get_contact_customer, {
                        id_contact: customer_by_id.CONTACT_ID
                    }, function (response) {
                        if (response.error) {
                            that.$message.error(response.error)
                        } else {
                            that.customer_detail_contact = response;
                            console.log(that.customer_detail_contact)
                        }
                    }, 'POST')
                }
            }, 'POST')

        },
        handleOk(e) {
            this.visible = false;
        },
        handleCancel(e) {
            this.disabled = false;
        },
        itemRender(current, type, originalElement) {
            if (type === 'prev') {
                return 'Previous';
            } else if (type === 'next') {
                return 'Next';
            }
            return originalElement;

        },
        get_pipeline: function () {
            let that = this;
            axios
                .post(url_get_pipeline, { headers: { 'Content-Type': 'application/json' } })
                .then(function (response) {
                    console.log(response)
                    that.list_pipeline = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        get_stage: function () {
            let that = this;
            this.request(url_get_sum_customer, {
                id_pipeline: this.selected
            }, function (response) {
                if (response.error) {
                    this.$message.error(response.error)
                } else {
                    that.list_stage = response;
                    var temp = 0;
                }
            }, 'POST')
        },
        get_commission: function () {
            let that = this;
            axios
                .post(url_get_sum_commission, { headers: { 'Content-Type': 'application/json' } })
                .then(function (response) {
                    that.commission_deal_won = response;
                    console.log(response)
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        get_customer: function () {
            this.loading = true;
            let that = this;
            axios
                .post(url_get_customer, { headers: { 'Content-Type': 'application/json' } })
                .then(function (response) {
                    response.data.forEach((value, key) => {
                        that.data.push({
                            key: key + 1,
                            name: value.TITLE,
                            stage: value.STAGE_ID,
                            date: that.formatDate(value.DATE_CREATE),
                            price: that.formatPrice(value.OPPORTUNITY) + ' ' + value.CURRENCY_ID,
                            action: value.ID,
                        })
                    })
                    that.loading = false;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        formatPrice(value) {
            let val = (value / 1)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        formatDate(date) {
            date = new Date(date);
            date.toLocaleDateString('en-US')
            return date.toLocaleDateString('en-US')
        }
    }
};
</script>

<style>
.ant-btn {
    color: black;
}

.detail input {
    background: none;
    border: none;
    outline: none;
}

.custom_col {
    background-color: rgb(0, 0, 0, 0.2) !important;
    margin-left: 30px !important;
    border-radius: 10px !important;
    padding: 10px !important;
    min-height: 300px !important;
}

.pipeline {
    margin: 10px 0 20px 0;
}

.pipeline select {
    border: none;
    min-width: 180px;
    color: white;
    background: none;
    border-bottom: 1px solid #ffffff;
    outline: none;
}

.pipeline option {
    color: black;
    background: #ffffff;
}

.pipeline option:not(:last-child) {
    border-bottom: solid 1px #eeeeee;
}

.stage,
.commission {
    clear: both;
    display: block;
    width: 100%;
    min-height: 40px;
    line-height: 40px;
    font-size: 16px;
    font-weight: 400;
    border-bottom: 1px solid white;
    color: white;
}

.stage .name_stage,
.commission .name_pipeline {
    float: left;
}

.stage .quantity,
.commission .quantity {
    float: right;
}

.space {
    width: 50px;
    height: 40px;
    clear: bold;
}

.total {
    font-size: 18px;
    font-weight: 500;
    color: white;
    min-height: 40px;
    line-height: 40px;
    border-bottom: 1px solid white;
}

.total .title {
    float: left;
}

.total .quantity {
    float: right;
}

.custom_col_2 {
    width: 94%;
    margin: 0 auto;
}

.ant-table-thead>tr>th {
    color: white !important;
    background: none !important;
}

table {
    color: white;
}

table tr td a {
    color: white;
}

table tr:hover {
    background: rgb(0, 0, 0, 0.4) !important;
}

.filter_search {
    height: 30px;
    margin: 10px 0 15px 0;
}

.filter,
.search {
    float: right;
    margin-left: 15px;
}

.filter .ant-calendar-picker {
    display: inline-table !important;
}

.ant-table-placeholder {
    background: none !important;
}

.display-right {
    text-align: right;
}

.display-center {
    text-align: center;
}
</style>
