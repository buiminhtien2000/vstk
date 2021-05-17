<template>
<div>
    <div class="Custom_login_form">
        <div class="logo">.
            <img :src="'../../images/logo-vstk.png'"/>
        </div>
        <p class="title">Đăng Nhập</p>
        <a-form id="components-form-demo-normal-login" :form="form" class="login-form" @submit="handleSubmit">
            <a-form-item>
                <a-input v-decorator="[
            'email',
            {
                rules: [
                {
                    type: 'email',
                    message: 'E-mail không đúng định dạng!',
                },
                {
                    required: true,
                    message: 'Vui lòng nhập E-mail!',
                },
                ],
            },
            ]" placeholder="Email">
                    <a-icon slot="prefix" type="mail" style="color: rgba(0,0,0,.25)" />
                </a-input>
            </a-form-item>
            <a-form-item>
                <a-input v-decorator="[
            'password',
            { rules: [{ required: true, message: 'Vui lòng nhập mật khẩu!' }] },
            ]" type="password" placeholder="Password">
                    <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
                </a-input>
            </a-form-item>
            <a-form-item>
                <a-checkbox v-decorator="[
                'remember',
                {
                    valuePropName: 'checked',
                    initialValue: true,
                },
                ]">
                    Nhớ tài khoản
                </a-checkbox>
                <a class="login-form-forgot" v-on:click="resetpass()">
                    Quên mật khẩu?
                </a>
            </a-form-item>
            <a-form-item>
                <a-button type="primary" html-type="submit" class="login-form-button">
                    <span id="loading"></span><span style="margin-top:2">Đăng nhập</span>
                </a-button>
            </a-form-item>
        </a-form>
    </div>
</div>
</template>

<script>
export default {
    props: [
        'route_store',
        'user_remember'
    ],
    data() {
        return {
            user: {},
        }
    },
    beforeCreate() {
        this.form = this.$form.createForm(this, { name: 'normal_login' });
    },
    mounted() {
        if(this.user_remember != false){
            var temp = JSON.parse(this.user_remember);
            this.form.setFieldsValue({ email: temp[1], password: temp[2] })
        }
    },
    methods: { 
        handleSubmit(e) {
            var spin_load = document.getElementById('loading');
            spin_load.setAttribute("class", "donut")
            e.preventDefault();
            let that = this;
            this.form.validateFields((err, values) => {
                if (!err) {
                    this.request(this.route_store,{
                      email: values.email,
                      password: values.password,
                      remember: (values.remember==true)?values.remember:false
                    },function (response){
                        if (response.error) {
                            this.$message.error(response.error)
                        }else{
                            if (response==true) {
                                spin_load.removeAttribute("class", "donut")
                                window.location.href = 'khach-hang';
                            }
                        }
                    }, 'POST')
                }
            });
        },
        resetpass() {
            window.location.href = 'quen-mat-khau';
        }
    },
};
</script>

<style>
.ant-layout-content{
    padding:0 !important;
}
.Custom_login_form {
    background-color: #ffffff;
    width: 320px;
    min-height: 350px;
    margin: 0px auto;
    padding: 10px 20px;
    box-shadow: #131313 1px 3px 10px 1px;
    position: absolute;
    top: 170px;
    left: 41%;
}

.Custom_login_form .ant-form-item {
    margin-bottom: 10px !important;
}
.Custom_login_form .title{
    font-weight: bold;
    margin: 0px 0 10px 0;
    text-align: center;
    font-size: 20px;
}
.Custom_login_form .logo {
    margin-bottom: 5px;
}
.Custom_login_form .logo img{
    width:100px;
}

.Custom_login_form input[type="text"],
input[type="password"] {
    height: 40px;
}

#components-form-demo-normal-login .login-form {
    max-width: 300px;
}

#components-form-demo-normal-login .login-form-forgot {
    float: right;
}

#components-form-demo-normal-login .login-form-button {
    width: 100%;
    background-color: #0b8479;
}
#loading{
    float:left;
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
