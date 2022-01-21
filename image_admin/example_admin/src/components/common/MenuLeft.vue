<template>
    <div class="menu-left" v-if="showMenuMobile">
        <div class="header" :style="{background: theme.menuLeftBc}" @click="goPage('/dashboard/console')">
            <svg class="svg-icon" aria-hidden="true">
                <use xlink:href="#iconzhaopian-copy"></use>
            </svg>
            <p :style="{color: theme.textColor, width: collapse ? '0' : '190px'}">{{systemName}}</p>
        </div>

        <el-menu class="el-menu" :class="'el-menu-'+ theme.theme"
                 :collapse="collapse"
                 :default-active="routerPath"
                 :text-color="theme.textColor"
                 :unique-opened="uniqueOpened"
                 :background-color="theme.menuLeftBc"
                 :active-text-color="theme.activeColor"
                 :default-openeds="defaultOpenedsArray"
        >
            <submenu :list="menuList" :isMobile="isMobileModel" @close="closeMenu"/>
        </el-menu>

        <div class="menu-model" @click="visibleMenu()" :style="{
      opacity: collapse ? 0 : 1,
      transform: showMobileModel ? 'scale(1)' : 'scale(0)'
    }">
        </div>
    </div>
</template>

<script>
    import setting from '@/config/setting'
    import Submenu from './Submenu.vue';
    import {mapState} from 'vuex'
    import {getMenuListAll} from "@/api/menuApi"

    export default {
        name: "MenuLeft",
        inject: ['reload'],
        components: {
            Submenu
        },
        computed: {
            ...mapState({
                worktab: state => state.worktab.worktab,
                setting: state => state.setting.setting,
                menu: state => state.menu
            }),
            routerPath() {
                let {current} = this.worktab
                let {path, params} = current
                let {status} = current.params

                // 个人中心折叠菜单
                if (path === '/user/user') {
                    this.defaultOpenedsArray = []
                }

                return status ? path + params.status : path
            }
        },
        watch: {
            'setting.theme': {
                handler(theme) {
                    this.getTheme(theme)
                },
                immediate: true
            },
            'setting.uniqueOpened'(uniqueOpened) {
                this.uniqueOpened = uniqueOpened
            },
            'menu.menuList'(list) {
                this.menuList = list
            }
        },
        data() {
            return {
                status: '',
                systemName: setting.systemName, // 系统名称
                menuList: [],                   // 菜单数据
                collapse: false,                // 是否水平折叠收起菜单
                collapseMobile: false,           // 移动端菜header折叠
                theme: {},                      // 主题
                uniqueOpened: '',               // 是否只保持一个子菜单的展开
                screenWidth: '',
                isMobileModel: false,
                showMenuMobile: false,
                showMobileModel: false,
                resizeList: [0, 0],
                defaultOpenedsArray: [],
            }
        },
        mounted() {
            this.getMenuList()
            this.initUserSetting()
            this.listenerWindowResize()
        },
        methods: {
            // 获取菜单列表|权限列表
            getMenuList() {
                getMenuListAll().then(res => {
                    if (res.code == 1) {
                        this.menuList = res.data.data;
                        return;
                    }
                    this.$router.push('/login');
                });
                this.menuList = [];
                console.log(this.menuList);
            },
            // 获取主题
            getTheme(theme) {
                if (theme) {
                    let t = setting.themeList.filter((item) => {
                        return item.theme === theme
                    })
                    this.theme = t[0]
                }
            },
            // 初始化用户设置
            initUserSetting() {
                this.uniqueOpened = this.setting.uniqueOpened
            },
            // 菜单展开 | 收缩
            visibleMenu() {
                this.collapse = !this.collapse

                setTimeout(() => {
                    this.collapseMobile = !this.collapseMobile
                }, 200)

                // 移动端模态框
                if (!this.showMobileModel) {
                    this.showMobileModel = true
                } else {
                    setTimeout(() => {
                        this.showMobileModel = false
                    }, 200)
                }
            },
            listenerWindowResize() {
                this.screenWidth = document.body.clientWidth;
                this.setMenuModel()

                window.onresize = () => {
                    return (() => {
                        this.screenWidth = document.body.clientWidth;
                        this.setMenuModel()
                    })();
                };
            },
            setMenuModel() {
                let {screenWidth, resizeList} = this

                if (screenWidth > 800) {
                    if (resizeList[0] === 0) {
                        this.isMobileModel = false
                        this.collapse = false
                        this.collapseMobile = false
                        this.showMenuMobile = true
                        this.$emit('topBarCollapse', true)
                    }

                    this.$set(this.resizeList, 0, 1)
                } else {
                    this.isMobileModel = true
                    this.collapse = true
                    this.$emit('topBarCollapse', false)
                    this.collapseMobile = true
                    this.showMobileModel = false
                    this.$set(this.resizeList, 0, 0)
                }

                setTimeout(() => {
                    this.showMenuMobile = true
                }, 10)
            },
            closeMenu() {
                this.collapse = true
                this.collapseMobile = true
                this.showMobileModel = false
            },
            goPage(path) {
                if (this.$route.path !== path) {
                    this.$router.push(path)
                }
            }
        }
    };
</script>

<style lang="scss">
    .menu-left {
        // 黑色主题
        .el-menu-dark {
            // 选中颜色
            .el-menu-item.is-active {
                background: #2d8cf0 !important;
            }

            // 鼠标移入背景色
            .el-submenu__title:hover {
                background: #121319 !important;
            }
        }

        // 白色主题
        .el-menu-white {

            // box-shadow: 5px 5px 8px 0 red;

            // 选中颜色
            .el-menu-item.is-active {
                background: #F0FAFF !important;

                // 左侧线条
                &::before {
                    content: '';
                    width: 3px;
                    height: 100%;
                    position: absolute;
                    left: 0;
                    background: #3296FA;
                }
            }

            // 鼠标移入背景色
            .el-submenu__title:hover,
            .el-submenu .el-menu-item:hover {
                color: #3296FA !important;
                background: #F0FAFF !important;
            }

            // 鼠标移入图标颜色
            .el-submenu__title:hover i,
            .el-submenu .el-menu-item:hover i {
                color: #3296FA !important;
            }
        }

        // 折叠后宽度
        .el-menu--collapse {
            width: $menu-left-shrink-width;
        }
        // 左边距
        .el-submenu__title {
            padding-left: 25px !important;
        }
        // 设置文字与图标的距离
        .el-submenu__title span {
            margin-left: 10px;
        }
        .el-submenu .el-menu-item span {
            margin-left: 15px;
        }
        // 箭头加粗
        .el-submenu__icon-arrow {
            font-weight: bold;
        }
    }
</style>

<style lang="scss" scoped>
    .menu-left {
        height: 100vh;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        position: fixed;
        z-index: 1001;
        top: 0;
        left: 0;
        box-shadow: 5px 5px 8px 0 rgba(29, 35, 41, .05);

        .el-menu--collapse {
            > > > .el-submenu__title span,
            > > > .el-submenu__icon-arrow {
                display: none;
            }
        }

        .header {
            height: 45px;
            line-height: 45px;
            box-sizing: border-box;
            cursor: pointer;
            display: flex;
            overflow: hidden;

            .svg-icon {
                width: 22px;
                vertical-align: -0.15em;
                fill: currentColor;
                overflow: hidden;
                margin-left: -2px;
                margin-top: 10px;
                margin-left: 25px;
            }

            p {
                color: #C3C3C3;
                font-size: 15px;
                margin-left: 10px;
                margin-top: 5px;
                overflow: hidden;
                transition: width .3s ease-in-out;
            }
        }

        .el-menu {
            border-right: 0;
            height: calc(100vh - 45px);
            box-sizing: border-box;
            overflow-y: auto;

            &::-webkit-scrollbar {
                width: 0px !important;
            }
        }

        .el-menu:not(.el-menu--collapse) {
            width: $menu-left-open-width;
        }

        .menu-model {
            display: none;
        }
    }

    @media only screen and (max-width: $device-ipad) {
        .menu-left {
            .header {
                display: none;
            }

            .el-menu {
                height: 100vh;
            }

            .el-menu--collapse {
                width: 0;
            }

            .menu-model {
                display: block;
                width: 100%;
                height: 100vh;
                position: fixed;
                z-index: -1;
                left: 0;
                top: 0;
                background: rgba($color: #000000, $alpha: 0.5);
                transition: opacity .2s ease-in-out;
            }
        }
    }
</style>
