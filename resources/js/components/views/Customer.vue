<template>
<div>
    <div class="pipeline">
        <select v-model="selected" v-if="list_pipeline" v-on:change="get_fields()">
            <option>Chọn Pipeline</option>
            <option v-for="(value, key) in list_pipeline" :key="value['ID']" v-bind:value="value['ID']">{{value['NAME']}}</option>
        </select>
    </div>
    <div v-for="(value, key) in data_fields[1]" :key="key">
        <input :name="key" />{{value}}
    </div>
    <button>Thêm mới</button>
</div>
</template>

<script>
const get_config_field = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_config_field'
const get_pipeline = window.location.protocol + '//' + window.location.hostname + ':8000/api/get_pipeline'
export default {
    data() {
        return {
            data_fields: {},
            selected: '',
            list_pipeline:{}
        };
    },
    created() {
        let that = this;
            this.request(get_pipeline, {
            }, function (response) {
                if (response.error) {
                    this.$message.error(response.error)
                } else {
                    that.list_pipeline = response;
                    console.log(response)
                }
            }, 'POST')
    },
    methods: {
        get_fields() {
            let that = this;
            this.request(get_config_field, {
                id_pipeline: this.selected,
            }, function (response) {
                if (response.error) {
                    this.$message.error(response.error)
                } else {
                    that.data_fields = response;
                }
            }, 'POST')
        },
    }
};
</script>

<style lang="less">
.resize-table-th {
    position: relative;

    .table-draggable-handle {
        height: 100% !important;
        bottom: 0;
        left: auto !important;
        right: -5px;
        cursor: col-resize;
        touch-action: none;
    }
}
</style>
