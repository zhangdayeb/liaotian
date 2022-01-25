<template>
    <div class='page-content'>
        <table-bar :showTop="true" :columns="columns" @changeColumn="changeColumn">
            <div slot="top">
                <el-form label-width="90px">
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :lg="6">
                            <el-form-item label="关键词：">
                                <el-input v-model="word" placeholder="路由名称或路径"></el-input>
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
            <el-table-column label="路由名称" width="200" prop="name" v-if="columns[1].show"/>
            <el-table-column label="路径" width="200" prop="path" v-if="columns[2].show"/>
            <el-table-column label="创建时间" width="200" prop="create_time" v-if="columns[3].show"/>
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
                <el-form-item label="路由名称">
                    <el-input v-model="model.name" placeholder="请输入菜单名称" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="路径">
                    <el-input v-model="model.path" placeholder="请输入路径" style="width:100%"></el-input>
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
    import {getRouteList, editRoute,deleteRoute} from '@/api/routeApi';
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
                    {name: "路由名称", show: true},
                    {name: "路径", show: true},
                    {name: "创建时间", show: true},
                ],
                dvEdit:false,
            };
        },
        created: function () {
            this.handleCurrentChange(1);
        },
        methods: {
            onSubmit:function(){
                editRoute({
                    id:this.model.id,
                    name:this.model.name,
                    path:this.model.path,
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
            reset: function () {
                this.word = '';
            },
            search: function () {
                this.handleCurrentChange(1);
            },
            handleCurrentChange: function (index) {
                this.current = index;
                getRouteList({
                    page:index,
                    word:this.word,
                }).then(res => {
                    this.lists = res.data.lists;
                    this.allpage = res.data.allpage;
                })
            },
            deleteModel(row) {
                this.$confirm('您确定要删除当前路由吗？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'error'
                }).then(() => {
                    deleteRoute({
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
