<template>
<a-layout id="components-layout-demo-custom-trigger">
    <a-layout-sider v-model="collapsed" :trigger="null" collapsible>
        <a-menu theme="dark" mode="inline" :default-selected-keys="['1']">
            <a-menu-item key="1">
                <a-icon type="profile"></a-icon>
                <span<router-link :to="{name:'statistic'}">>Danh sách khách hàng</router-link></span>
            </a-menu-item>
            <a-menu-item key="2">
                <a-icon type="user-add"></a-icon>
                <span><router-link :to="{name:'customer'}">Thêm mới khách hàng</router-link></span>
            </a-menu-item>
            <a-menu-item key="3">
                <a-icon type="info-circle"></a-icon>
                <span>Giới thiệu</span>
            </a-menu-item>
            <a-menu-item key="4" id="logout2">
                <a-icon type="logout"></a-icon>
                <span>Đăng xuất</span>
            </a-menu-item>
        </a-menu>
    </a-layout-sider>
    <a-layout>
        <a-layout-header style="background: #fff; padding: 0">
            <a-icon class="trigger" :type="collapsed ? 'menu-unfold' : 'menu-fold'" @click="() => (collapsed = !collapsed)"></a-icon>
            <ul class="menu-top">
                <li>
                    <a-icon type="info-circle"></a-icon>
                    <span>Giới thiệu</span>
                </li>
                <li>
                    <a-icon type="question-circle"></a-icon>
                    <span>Trợ giúp</span>
                </li>
                <li id="logout1">
                    <a-icon type="logout"></a-icon>
                    <span>Đăng xuất</span>
                </li>
            </ul>
        </a-layout-header>
        <a-layout-content>
            <router-view></router-view>
        </a-layout-content>
    </a-layout>
</a-layout>
</template>

<script>
export default {
    data() {
        return {
            collapsed: false,
        };
    },
};
</script>

<style>
.menu-top {
    width: 370px;
    float: right;
    list-style-type: none;
}

.menu-top li {
    width: 30%;
    float: left;
}
.menu-top li span,.anticon svg{
    font-size:15px;
    color:white;
    font-weight:400;
}
#components-layout-demo-custom-trigger .trigger {
    font-size: 18px;
    line-height: 64px;
    padding: 0 24px;
    cursor: pointer;
    transition: color 0.3s;
}

#components-layout-demo-custom-trigger .trigger:hover {
    color: #1890ff;
}

#components-layout-demo-custom-trigger .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}
.ant-layout-sider,.ant-layout-header,.ant-layout,.ant-menu{
    background:none !important;
}

</style>
