<template>
<div class="resetpass">
    <div class="logo">.
        <img :src="'../../images/logo-vstk.png'" />
    </div>
    <p class="title">Tìm tài khoản của bạn</p>
    <a-form id="form_reset" :form="form" class="reset-form" @submit="resetpass">
        <a-form-item>
            <a-input v-decorator="[
          'email',
          {
            rules: [
              {
                type: 'email',
                message: 'Không đúng định dạng E-mail!',
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
            <a-button type="primary" html-type="submit" class="reset-form-button">
                <span id="loading"></span><span style="margin-top:2">Đặt lại mật khẩu</span>
            </a-button>
        </a-form-item>
    </a-form>
</div>
</template>

<script>
import axios from "axios";
export default {
    props: [
        'url_create_link_reset',
        'url_check_user'
    ],
    beforeCreate() {
        this.form = this.$form.createForm(this, { name: 'normal_login' });
    },
    methods: {
        resetpass(e) {
            var spin_load = document.getElementById('loading');
            spin_load.setAttribute("class", "donut")
            e.preventDefault();
            let that = this;
            this.form.validateFields((err, values) => {
                if (!err) {
                    that.request(that.url_check_user, {
                        email: values.email,
                    }, function (response) {
                        if (typeof response === 'object' && response['ID']) {
                            that.sendrequest(response['ID'])
                        } else {
                            if (response.error) {
                                spin_load.removeAttribute("class", "donut")
                                that.$message.error(response.error)
                            } else {
                                spin_load.removeAttribute("class", "donut")
                                that.$message.success(response.data)
                            }
                        }
                    }, 'POST')
                }
            })
        },
        sendrequest(id_user) {
            var spin_load = document.getElementById('loading');
            let that = this;
            that.request(this.url_create_link_reset, {
                id: id_user,
            }, function (response) {
                console.log(response)
                if (response.error) {
                    that.$message.error(response.data)
                } else {
                    spin_load.removeAttribute("class", "donut")
                    that.$message.success(response.data)
                }
            }, 'POST')
        }
    },
};
</script> 

<style>
.resetpass {
    background: #ffffff;
    width: 300px;
    margin: 0 auto;
    padding: 10px 20px;
    box-shadow: #131313 1px 3px 10px 1px;
    position: absolute;
    top: 100px;
    left: 41.5%;
}

.resetpass .title {
    font-weight: bold;
    margin: 0px 0 10px 0;
    text-align: center;
    font-size: 20px;
}
.resetpass .logo {
    margin-bottom: 5px;
}
.resetpass .logo img {
    width: 100px;
}
.resetpass .ant-form-item{
    margin-bottom: 10px !important;
}
.resetpass input[type="text"],
input[type="password"] {
    height: 40px;
}

#form_reset .login-form {
    max-width: 300px;
}
#form_reset .reset-form-button {
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
