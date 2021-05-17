<template>
<div class="ConfirmReset"></div>
</template>
<script>
import axios from "axios";
export default {
    created() {
        axios
        .post('http://localhost/app_bitrix1/User/ConfirmReset/'+this.$route.params.id+'/'+this.$route.params.code)
        .then(response => (console.warn(response),(response.data != true)?this.$router.push({name:"Page404"}):this.getPassword(this.$route.params.id)));
    },
    methods:{
        getPassword(id){
            axios
            .post('http://localhost/app_bitrix1/User/CreatePassword/'+id)
            .then(this.$message.success("Email xác nhận được gửi về hộp thư của bạn. Vui lòng xác nhận để đặt lại mật khẩu!"));
        }
    }
};
</script>