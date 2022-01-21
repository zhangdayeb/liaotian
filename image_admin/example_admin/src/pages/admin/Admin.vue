<template>
    <div class='page-content'>
        <table-bar :showTop="true" :columns="columns" @changeColumn="changeColumn">
            <div slot="top">
                <el-form label-width="90px">
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :lg="6">
                            <el-form-item label="关键词：">
                                <el-input v-model="word" placeholder="用户名或手机号"></el-input>
                            </el-form-item>
                        </el-col>
                        <el-row :xs="24" :sm="12" :lg="6" style="float: right; margin-right: 10px;">
                            <el-button type="primary" @click="search">查询</el-button>
                            <el-button @click="reset">重置</el-button>
                        </el-row>
                    </el-row>
                </el-form>
            </div>
            <div slot="bottom">
                <el-button type="primary" plain @click="showDialog">新增</el-button>
            </div>
        </table-bar>
        <el-table :data="lists" :showPage="false" border ref="table">
            <el-table-column label="ID" width="80" prop="id" v-if="columns[0].show"/>
            <el-table-column label="用户名" width="130" prop="username" v-if="columns[1].show"/>
            <el-table-column label="角色" width="150" prop="role_name" v-if="columns[2].show"/>
            <el-table-column label="状态" width="100" prop="status" v-if="columns[3].show">
                <template slot-scope="scope">
                    <template v-if="scope.row.status == 1">
                        <el-tag size="mini" type="success">正常</el-tag>
                    </template>
                    <template v-else>
                        <el-tag size="mini" type="danger">禁用</el-tag>
                    </template>
                </template>
            </el-table-column>
            <el-table-column label="手机号" width="150" prop="mobile" v-if="columns[4].show"/>
            <el-table-column label="绑定城市" width="160" prop="city_config_name" v-if="columns[5].show"/>
            <el-table-column label="备注" width="160" prop="remark" v-if="columns[6].show"/>
            <el-table-column label="创建时间" width="140" prop="create_time" v-if="columns[7].show"/>
            <el-table-column fixed="right" label="操作" width="140">
                <template slot-scope="scope">
                    <el-button type="text" icon="el-icon-edit" @click="updateModel(scope.row)">修改</el-button>
                    <el-button type="text" icon="el-icon-delete" @click="deleteModel(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <template v-if="allpage>10">
            <el-pagination @current-change="handleCurrentChange"
                           :current-page="1"
                           :page-size="10"
                           layout="total, prev, pager, next, jumper"
                           :total="allpage">
            </el-pagination>
        </template>
        <el-dialog title="编辑" width="500px" :visible.sync="dvEdit">
            <el-form ref="model" :model="model" label-width="80px">
                <el-form-item label="用户名">
                    <el-input v-model="model.username" placeholder="请输入用户名" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input v-model="model.password" placeholder="请输入密码(修改时可不填)" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="model.mobile" placeholder="请输入手机号" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="角色">
                    <el-select v-model="model.role_id" style="width:100%" filterable placeholder="请选择角色">
                        <el-option v-for="item in roleList" :key="item.id" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="省市">
                    <el-cascader v-model="model.city_config_arr" :options="cityConfigList" style="width:100%"></el-cascader>
                </el-form-item>
                <el-form-item label="状态">
                    <el-select v-model="model.status" style="width:100%" placeholder="请选择状态">
                        <el-option label="正常" value="1"></el-option>
                        <el-option label="禁用" value="2"></el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
        <el-button @click="dvEdit = false">取 消</el-button>
        <el-button type="primary" @click="onSubmit">确 定</el-button>
      </span>
        </el-dialog>
    </div>
</template>

<script>
    import {getAdminList, editAdmin,deleteAdmin} from '@/api/adminApi';
    import {getRoleListAll} from '@/api/roleApi';
    import {getCityConfigListAll} from '@/api/cityConfigApi';
    export default {
        data() {
            return {
                lists: [],
                allpage: 1,//总页数
                showItem: 5,//分页显示得中间按钮个数
                current: 1,//当前页
                word: '',
                model:{},
                columns: [
                    {name: "ID", show: true},
                    {name: "用户名", show: true},
                    {name: "角色", show: true},
                    {name: "状态", show: true},
                    {name: "手机号", show: true},
                    {name: "绑定城市", show: true},
                    {name: "备注", show: true},
                    {name: "创建时间", show: true},
                ],
                roleList:[],
                dvEdit:false,
                cityConfigList:[]
            };
        },
        created: function () {
            this.handleCurrentChange(1);
            this.getRoleList();
            this.getCityConfigList();
        },
        methods: {
            onSubmit:function(){
                editAdmin({
                    id:this.model.id,
                    username:this.model.username,
                    password:this.model.password,
                    mobile:this.model.mobile,
                    role_id:this.model.role_id,
                    city_config_arr:this.model.city_config_arr,
                    status:this.model.status,
                }).then(res => {
                    if(res.code === 1){
                        this.$message({
                            message: '操作成功',
                            type: 'success'
                        });
                        this.dvEdit = false;
                        this.handleCurrentChange(this.current);
                    }
                })
            },
            showDialog:function(){
                this.model = {};
                this.dvEdit = true;
            },
            updateModel:function(row){
                this.model = row;
                this.dvEdit = true;
            },
            getCityConfigList:function(){
                getCityConfigListAll().then(res => {
                    this.cityConfigList = res.data.lists;
                })
            },
            getRoleList:function(){
                getRoleListAll().then(res => {
                    this.roleList = res.data.lists;
                })
            },
            reset: function () {
                this.word = '';
            },
            search: function () {
                this.handleCurrentChange(1);
            },
            handleCurrentChange: function (index) {
                this.current = index;
                getAdminList({
                    page:index,
                    word:this.word,
                }).then(res => {
                    this.lists = res.data.lists;
                    this.allpage = res.data.allpage;
                })
            },
            deleteModel(row) {
                this.$confirm('您确定要删除当前管理员吗？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'error'
                }).then(() => {
                    deleteAdmin({
                        id: row.id
                    }).then(res => {
                        if (res.code === 1) {
                            this.$message({
                                message: '删除成功',
                                type: 'success'
                            });
                            this.handleCurrentChange(this.current);
                        }
                    })
                }).catch(() => {
                })
            },
            changeColumn(columns) {
                this.columns = columns;
                this.$refs.table.doLayout()
            }
        }
    }
</script>

<style lang='scss' scoped>
    .page-content {
        width: 100%;
        height: 100%;

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    }
</style>
