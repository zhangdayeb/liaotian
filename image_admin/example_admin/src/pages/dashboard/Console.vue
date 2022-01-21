<template>
    <div class="task console">
        <el-table :data="lists" :showPage="false" border ref="table">
            <el-table-column label="登录帐号" width="200" prop="user_name" />
            <el-table-column label="权限" width="200" prop="role_name"/>
            <el-table-column label="当前登录时间" width="200" prop="login_at"/>
        </el-table>
    </div>
</template>

<script>
    import {loadApi} from '@/api/loginApi';
    export default {
        data() {
            return {
                lists:[],
                token:localStorage.getItem('token'),
            };
        },
        created:function(){
            this.load();
        },
        methods: {
            load: function () {
                loadApi({
                    token:this.token
                }).then(res => {
                    if(res.code === 1){
                        this.lists = res.data.lists;
                    }else{

                    }
                })
            },
        }
    }
</script>

<style lang="scss" scoped>
    .console {
        height: 100%;

        &::-webkit-scrollbar {
            width: 0px !important;
        }

        > > > .head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-right: 20px;
            padding: 10px 0;
            border-bottom: 1px solid #F0F0F0;
            position: relative;
            z-index: 999;

            .line-title {
                padding: 0 13px;
                display: flex;
                align-items: center;

                i {
                    display: inline-block;
                    width: 24px;
                    height: 24px;
                    line-height: 24px;
                    text-align: center;
                    border-radius: 50%;
                    color: #1890FF;
                    background-color: rgb(230, 247, 255);
                    font-size: 15px;
                }

                span {
                    color: #555;
                    font-size: 15px;
                    margin-left: 10px;
                }
            }
        }

        .row {
            display: flex;
            margin-top: 15px;
            background: transparent !important;

            > div {
                margin-right: 15px;
                overflow: hidden;
                background: #fff;
                border-radius: 3px;
                transition: box-shadow .3s;

                &:last-of-type {
                    margin-right: 0 !important;
                }
            }
        }

        .row1, .row2 {
            height: 380px;
        }
    }

    @media only screen and (max-width: $device-notebook) {
        .console {
            .row1 {
                height: 350px;
            }

            .row2 {
                height: 300px;
            }
        }
    }

    @media only screen and (max-width: $device-ipad) {
        .console {

            .row {
                display: block;
                height: auto !important;

                > div {
                    height: 370px;
                }
            }

            .row1 {
                margin-top: 0;
            }
        }
    }
</style>
