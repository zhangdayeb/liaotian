import Vue from 'vue'
import store from '@/store'
import Router from 'vue-router'
import Home from '@/pages/home/Home.vue'
import Console from '@/pages/dashboard/Console'
import setting from '@/config/setting'

Vue.use(Router)

// 不需要权限的路由
const routes = [
    {
        path: '/',
        redirect: '/login'
    }, {
        path: '/dashboard',
        component: Home,
        meta: {
            title: '首页'
        },
        children: [
            {
                path: 'console',
                component: Console,
                meta: {
                    title: '首页'
                }
            }
        ]
    },
    {
        path: '/login',
        component: () => import('@/pages/login/Login'),
        meta: {
            title: '登录',
            newPage: true
        }
    }, {
        path: '/exception',
        component: Home,
        meta: {
            title: '异常页面'
        },
        children: [
            {
                path: '403',
                component: () => import('@/pages/exception/403'),
                meta: {
                    title: '403'
                }
            },
            {
                path: '404',
                component: () => import('@/pages/exception/404'),
                meta: {
                    title: '404'
                }
            },
            {
                path: '500',
                component: () => import('@/pages/exception/500'),
                meta: {
                    title: '500'
                }
            }
        ]
    }
]


// 需要权限的路由
export const allowRouters = [
    {
        path: '/',
        redirect: '/login'
    },

    {
        path: '/login',
        component: () => import('@/pages/login/Login'),
        meta: {
            title: '登录',
            newPage: true
        }
    },
    {
        path: '/dashboard',
        component: Home,
        meta: {
            title: '首页'
        },
        children: [
            {
                path: 'console',
                component: Console,
                meta: {
                    title: '首页'
                }
            }
        ]
    },
    {
        path: '/admin',
        component: Home,
        meta: {
            title: '权限管理'
        },
        children: [
            {
                path: 'admin',
                component: () => import('@/pages/admin/Admin'),
                meta: {
                    title: '管理员列表'
                }
            },
            {
                path: 'role',
                component: () => import('@/pages/admin/Role'),
                meta: {
                    title: '角色管理'
                }
            },
            {
                path: 'route',
                component: () => import('@/pages/admin/Route'),
                meta: {
                    title: '路由管理'
                }
            },
            {
                path: 'menu',
                component: () => import('@/pages/admin/Menu'),
                meta: {
                    title: '菜单管理'
                }
            },
            {
                path: 'auth',
                component: () => import('@/pages/admin/Auth'),
                meta: {
                    title: '权限分配'
                }
            },
        ]
    }, {
        path: '/system',
        component: Home,
        meta: {
            title: '系统配置'
        },
        children: [
            {
                path: 'video-type',
                component: () => import('@/pages/system/VideoType'),
                meta: {
                    title: '视频分类'
                }
            },
          {
            path: 'city',
            component: () => import('@/pages/system/City'),
            meta: {
              title: '城市管理'
            }
          },
          {
            path: 'beautiful',
            component: () => import('@/pages/system/Beautiful'),
            meta: {
              title: '选美列表'
            }
          },
          {
            path: 'video',
            component: () => import('@/pages/system/Video'),
            meta: {
              title: '视频管理'
            }
          },
          {
            path: 'notice',
            component: () => import('@/pages/system/Notice'),
            meta: {
              title: '公告管理'
            }
          },
        ]
    },
]


const router = new Router({
    routes: allowRouters
})

router.beforeEach((to, from, next) => {
    let isLogin = false
    let {meta, matched} = to
    let {title, newPage, keepAlive} = meta
    let sys = JSON.parse(localStorage.getItem("sys"))

    if (sys) {
        isLogin = sys.user.isLogin
    }

    to.params.keepAlive = keepAlive

    // if(!isLogin && to.path !== '/login') {
    //   next('/login')
    //   return
    // }else {
    let {menuList} = store.state.menu

    if (menuList.length > 0) { // 菜单数据加载成功
        if (!matched.length) {   // 打开的页面不存在
            router.push('/exception/404')
            return
        }
    }
    next()
    // }

    // 不是标签页
    if (newPage) {
        return
    }

    // 路由添加到标签页
    store.dispatch('worktab/worktabRoute', {
        to: {
            name: to.name ? to.name : '',
            title: (to.meta && title) ? title : '',
            path: to.path,
            params: to.params
        },
        from: {
            name: from.name ? from.name : '',
            title: (from.meta && from.meta.title) ? from.meta.title : '',
            path: from.path,
            params: to.params
        }
    })

    // 设置网页title
    if (title) {
        document.title = `${title} - ${setting.systemName}`
    }
    return
})

export default router
