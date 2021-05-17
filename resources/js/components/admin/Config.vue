<template>
<div class="config">
    <a-tabs default-active-key="1">
        <a-tab-pane key="1" tab="Setting field">
            <div>
                <div style="display: block;margin: 20px 0 30px;">
                    <select v-model="selected" v-if="list_pipeline.result" v-on:click="save_temporarily" v-on:change="get_field_config">
                        <option v-for="item in list_pipeline.result" :key="item.ID" v-bind:value="item.ID">{{item.NAME}}</option>
                    </select>
                    <div style="float:right;font-weight:bold">
                        <input type="checkbox" id="default" style="margin-right:10px">Set as the general display template
                    </div>
                </div>
                <div>
                    <div style="margin-bottom:20px;">
                        <input type="checkbox" v-on:click="check_all" id="check_all" /><label for="checkAll" style="font-weight:bold">Select all field</label>
                    </div>
                    <div class="field">
                        <a-checkbox-group>
                            <a-row v-if="list_deal_field.result">
                                <a-col :span="8" v-for="(item, index) in list_deal_field.result" :key="index">
                                    <!--a-checkbox v-bind:value="index" :id="index">
                                        {{item}}
                                    </a-checkbox-->
                                    <input type='checkbox' v-bind:value="index" v-bind:id="index" /><label v-bind:for="index">{{item}}</label>
                                </a-col>
                            </a-row>
                        </a-checkbox-group>
                    </div>
                </div>
                <button name="submit" style="float: right;width: 80px;height:30px;background-color: #c50303;border: none;color: white;border-radius: 5px" id="save" v-on:click="save_config_field">Lưu</button>
            </div>
        </a-tab-pane>
        <a-tab-pane key="2" tab="Setting commission" force-render>
                <a-row type="flex">
                    <div>
                        <label>Loại hoa hồng</label>
                        <input v-model="type_commission" type="radio" name="type" id="phantram" value="percent" /><label for="percent">Phần trăm</label>
                        <input v-model="type_commission" type="radio" name="type" id="tienthuc" value="default" /><label for="default">Tiền thực</label>
                    </div>
                </a-row>
                <a-row type="flex" v-if="list_pipeline.result" v-for="item in list_pipeline.result" :key="item.ID" >
                    <div style="width:55%;margin:10px 0">
                        <label>{{item.NAME}} </label>
                    </div>
                    <div class="field_commission" style="width:40%;margin:10px 0">
                        <input type="number" :id="item.ID" />
                    </div>
                </a-row>
                <button name="submit" style="float: right;width: 80px;height:30px;background-color: #c50303;border: none;color: white;border-radius: 5px" id="save" v-on:click="save_commission">Lưu</button>
        </a-tab-pane>
    </a-tabs>
</div>
</template>

<script>
export default {
    props: [
        'url_get_pipeline',
        'url_get_config_field',
        'url_get_config_commission',
        'url_save_config_field',
        'url_save_config_commission',
        'url_get_deal_field'
    ],
    created() {
        let that = this;
        this.request(this.url_get_pipeline, {}, function (response) {
            that.list_pipeline = response
            that.get_field()
        }, 'POST')
    },
    data() {
        return {
            list_pipeline: {},
            list_deal_field: {},
            list_field_config: {},
            temp: {},
            selected: '2',
            type_commission: '',
            index_checked: 0,
        }
    },
    methods: {
        check_all: function () {
            var array_field = document.querySelectorAll(".field input[type='checkbox']")
            if (this.index_checked == 0) {
                for (var i = 0; i < array_field.length; i++) {
                    array_field[i].checked = true;
                }
                this.index_checked = 1;
            } else {
                for (var i = 0; i < array_field.length; i++) {
                    array_field[i].checked = false;
                }
                this.index_checked = 0;
            }
        },
        save_temporarily() {
            var array_field = document.querySelectorAll(".field input[type='checkbox']")
            var data = [];
            var field = JSON.parse(localStorage.getItem('create_field'));
            if (field == null) {
                var temp = {
                    id_pipeline: this.selected,
                    field: []
                };
                for (var i = 0; i < array_field.length; i++) {
                    if (array_field[i].checked == true) {
                        temp.field.push(array_field[i].value);
                    }
                }
                data.push(temp);
            } else {
                var temp = {
                    id_pipeline: this.selected,
                    field: []
                };
                data = field;
                var result = true;
                for (var j = 0; j < data.length; j++) {
                    if (data[j].id_pipeline == this.selected) {
                        for (i = 0; i < array_field.length; i++) {
                            if (array_field[i].checked == true) {
                                temp.field.push(array_field[i].value);
                            }
                        }
                        data[j].field = temp.field;
                        result = true;
                        break;
                    } else {
                        console.log(result)
                    }
                }
                if (result == false) {
                    data.push(temp);
                }
            }
            localStorage.setItem('create_field', JSON.stringify(data));
        },
        get_field() {
            let that = this;
            this.request(this.url_get_deal_field, {}, function (response) {
                that.list_deal_field = response
                that.get_field_config();
            }, 'POST')
        },
        onChange(checkedValues) {
            console.log('checked = ', checkedValues);
        },
        save_config_field() {
            let that = this;
            var array_field = document.querySelectorAll(".field input[type='checkbox']");
            var checbox_default = document.getElementById('default').checked;
            var data = [];
            if (checbox_default == true) {
                for (var i = 0; i < this.list_pipeline.result.length; i++) {
                    var temp = {
                        id_pipeline: this.list_pipeline.result[i]['ID'],
                        field: []
                    };
                    for (var j = 0; j < array_field.length; j++) {
                        if (array_field[j].checked == true) {
                            temp.field.push(array_field[j].value);
                        }
                    }
                    data.push(temp);
                }
                this.request(this.url_save_config_field, {
                        data: data
                    },
                    function (response) {
                        if (response.error) {
                            that.$message.error(response.error)
                        } else {
                            that.$message.success(response.error)
                        }
                    }, 'POST')
            } else {
                this.save_temporarily();
                var localSto_field = JSON.parse(localStorage.getItem('create_field'));
                let that = this;
                this.request(this.url_save_config_field, {
                        data: localSto_field
                    },
                    function (response) {
                        if (response.error) {
                            that.$message.error(response.error)
                        } else {
                            that.$message.success(response.error)
                        }
                    }, 'POST')
            }
        },
        get_field_config() {
            let that = this;
            var array_field = document.querySelectorAll(".field input[type='checkbox']");
            for (var i = 0; i < array_field.length; i++) {
                array_field[i].checked = false;
            }
            this.request(this.url_get_config_field, {
                    id_pipeline: this.selected
                },
                function (response) {
                    if (response.error) {
                        that.$message.error(response.error)
                    } else {
                        that.list_field_config = response[1];
                        for (var i = 0; i < response[1].length; i++) {
                            document.getElementById(response[1][i]).checked = true;
                        }
                    }
                }, 'POST')
        },
        save_commission() {
            let that = this;
            var temp = {
                "type_commission":this.type_commission,
                "data":[]
            };
            for(var i = 0;i<this.list_pipeline.result.length;i++){
                var id_pipeline = this.list_pipeline.result[i].ID
                temp['data'][i] = {id:id_pipeline,value:document.getElementById(id_pipeline).value};
            }
            this.request(this.url_save_config_commission, {
                    data: temp
                },
                function (response) {
                    if (response.error) {
                        that.$message.error(response.error)
                    } else {
                        that.$message.success(response.success)
                    }
                }, 'POST')
        }

    }
};
</script>

<style lang="less" scoped>
.config {
    min-height: 300px;
    margin: 0 auto;
    padding: 10px 20px;
    margin-top: 10px;
    box-shadow: #131313 1px 3px 10px 1px;
    border-radius: 5px;

}

.config .logo img {
    width: 100px;
}
</style>
