import Login from './pages/Login.vue'
import NotFound from './pages/404.vue'
import Home from './pages/Home.vue'
import Main from './pages/Main.vue'
import Table from './pages/nav1/Table.vue'
import Form from './pages/nav1/Form.vue'
import user from './pages/nav1/user.vue'
import course_list from './pages/nav2/course_list.vue'
import course_dsh from './pages/nav2/course_dsh.vue'
import course_wtg from './pages/nav2/course_wtg.vue'
import course_detail from './pages/nav2/course_detail.vue'
import comment from './pages/nav3/comment.vue'
import xiti from './pages/nav4/xiti.vue'
import config from './pages/config.vue'
let routes = [

    {
        path: '/login',
        component: Login,
        name: '',
        hidden: true
    },
    {
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },
    //{ path: '/main', component: Main },
    {
        path: '/',
        component: Home,
        name: '用户中心',
        iconCls: 'fa fa-address-book',//图标样式class
        children: [
            { path: '/main', component: Main, name: '主页', hidden: true },
            { path: '/table', component: Table, name: '用户操作' },
         
            { path: '/user', component: user, name: '用户列表' },
        ]
    },
    {
        path: '/',
        component: Home,
        name: '课程中心',
        iconCls: 'fa fa-id-card-o',
        children: [
            { path: '/course_list', component: course_list, name: '课程列表'},
            { path: '/course_dsh', component: course_dsh, name: '待审核' },
            {path: '/course_wtg', component: course_wtg, name: '审核未通过'}
        ]
    },
    {
        path: '/',
        component: Home,
        name: '',
        iconCls: 'fa fa-address-card',
        leaf: true,//只有一个节点
        children: [
            { path: '/comment', component: comment, name: '评论中心' }
        ]
    },
    {
        path: '/',
        component: Home,
        name: '习题中心',
        iconCls: 'fa fa-bar-chart',
        children: [
            { path: '/xiti', component: xiti, name: '习题中心' }
        ]
    },
    {
        path: '/',
        component: Home,
        name: 'config',
        hidden: true,
        children: [
            { path: '/config', component: config, name: 'config' }
        ]
    },
    {
        path: '/',
        component: Home,
        name: '课程详细',
        hidden: true,
        children: [
            { path: '/course_list/detail/:course_id', component: course_detail, name: 'detail' }
        ]
    },
    {
        path: '*',
        hidden: true,
        redirect: { path: '/404' }
    }
];

export default routes;