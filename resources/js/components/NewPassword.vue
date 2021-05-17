<template>
<div class="newpass">
    <div class="logo">.
        <img :src="'../../images/logo-vstk.png'" />
    </div>
    <p class="title">Đặt lại mật khẩu</p>
    <a-form id="form_newpass" :form="form" class="reset-form" @submit="handleSubmit">
        <a-form-item>
            <a-input v-decorator="['newpassword', 
                { rules: 
                [
                    {
                    required: true,
                    message: 'Vui lòng nhập mật khẩu mới!'
                    }
                ]
                }
                ]" type="password" placeholder="Nhập mật khẩu mới" />
        </a-form-item>
        <a-form-item>
            <a-input v-decorator="['confirmpassword', { rules: [{required: true, message: 'Vui lòng xác nhận mật khẩu!' }] }]" type="password" placeholder="Xác nhận mật khẩu" />
        </a-form-item>
        <a-form-item>
            <a-button type="primary" html-type="submit" class="newpass-form-button">
            <span id="loading"></span><span style="margin-top:2">Xác nhận</span>
            </a-button>
        </a-form-item>
    </a-form>
</div>
</template>

<script>
export default {
    props: [
        'code_reset',
        'url_reset'
    ],
    data() {
        return {
            "new_password": "",
            "confirm_password": "",
        }
    },
    beforeCreate() {
        this.form = this.$form.createForm(this, { name: 'normal_login' });
    },
    methods: {
        handleSubmit(e) {
            var spin_load = document.getElementById('loading');
            spin_load.setAttribute("class", "donut")
            e.preventDefault();
            var code = window.location.pathname.split("/", 3)
            let that = this;
            this.form.validateFields((err, values) => {
                if (!err) {
                    if (values.newpassword == values.confirmpassword) {
                        this.request(this.url_reset, {
                            id: code[2].slice(32),
                            code: code[2].slice(0, 32),
                            password: values.newpassword
                        }, function (response) {
                            if (response.error) {
                                spin_load.removeAttribute("class", "donut")
                                that.$message.error(response.error)
                            } else {
                                spin_load.removeAttribute("class", "donut")
                                that.$message.success(response.success)
                            }
                        }, 'POST')
                    } else {
                        spin_load.removeAttribute("class", "donut")
                        that.$message.error("Mật khẩu nhập lại không khớp!")
                    }
                }
            });
        },
    }
};
</script>

<style>
.newpass {
    background: #ffffff;
    width: 300px;
    margin: 0 auto;
    padding: 10px 20px;
    box-shadow: #131313 1px 3px 10px 1px;
    position: absolute;
    top: 100px;
    left: 41.5%;
}

.newpass .title {
    font-weight: bold;
    margin: 0px 0 10px 0;
    text-align: center;
    font-size: 20px;
}

.newpass .logo img {
    width: 100px;
}

#form_newpass .login-form {
    max-width: 300px;
}

#form_newpass .newpass-form-button {
    width: 100%;
    background-color: #0b8479;
}
.donut {
        width: 20px;
    height: 20px;
    margin: 4px;
    border-radius: 50%;
    border: 3px solid #cccccc;
    border-top-color: white;
        animation: 1s spin infinite linear;
    }
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
