<template>
    <div class='page-content'>
        <table-bar :showTop="true" :columns="columns" @changeColumn="changeColumn">
            <div slot="top">
                <el-form label-width="90px">
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :lg="6">
                            <el-form-item label="关键词：">
                                <el-input v-model="word" placeholder="菜单名称或路径"></el-input>
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
            <el-table-column label="父级菜单" width="130" prop="parent_title" v-if="columns[1].show"/>
            <el-table-column label="菜单名称" width="130" prop="title" v-if="columns[2].show"/>
            <el-table-column label="路径" width="150" prop="path" v-if="columns[3].show"/>
            <el-table-column label="状态" width="100" prop="status" v-if="columns[4].show">
                <template slot-scope="scope">
                    <template v-if="scope.row.status == 1">
                        <el-tag size="mini" type="success">显示</el-tag>
                    </template>
                    <template v-else>
                        <el-tag size="mini" type="danger">隐藏</el-tag>
                    </template>
                </template>
            </el-table-column>
            <el-table-column label="排序值" width="150" prop="order_num" v-if="columns[5].show"/>
            <el-table-column label="创建时间" width="140" prop="create_time" v-if="columns[6].show"/>
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
                <el-form-item label="父级菜单">
                    <el-select v-model="model.parent_id" style="width:100%" filterable placeholder="请选择父级菜单(不选默认顶级菜单)">
                        <el-option v-for="item in menuParentList" :key="item.id" :label="item.title" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="菜单名称">
                    <el-input v-model="model.title" placeholder="请输入菜单名称" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="路径">
                    <el-input v-model="model.path" placeholder="请输入路径(顶级菜单不填)" style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="排序值">
                    <el-input v-model="model.order_num" placeholder="请输入排序值" type="number" style="width:100%"></el-input>
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
    import {getMenuList, editMenu,deleteMenu,getMenuParentList} from '@/api/menuApi';
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
                    {name: "父级菜单", show: true},
                    {name: "菜单名称", show: true},
                    {name: "路径", show: true},
                    {name: "状态", show: true},
                    {name: "排序值", show: true},
                    {name: "创建时间", show: true},
                ],
                dvEdit:false,
                menuParentList:[]
            };
        },
        created: function () {
            this.handleCurrentChange(1);
            this.getMenuParentListAll();
        },
        methods: {
            onSubmit:function(){
                editMenu({
                    id:this.model.id,
                    parent_id:this.model.parent_id,
                    path:this.model.path,
                    order_num:this.model.order_num,
                    status:this.model.status,
                    title:this.model.title
                }).then(res => {
                    if(res.code === 1){
                        this.$message({
                            message: '操作成功',
                            type: 'success'
                        });
                        this.dvEdit = false;
                        this.handleCurrentChange(this.current);
                        this.getMenuParentListAll();
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
            getMenuParentListAll:function(){
                getMenuParentList().then(res => {
                    this.menuParentList = res.data.lists;
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
                getMenuList({
                    page:index,
                    word:this.word,
                }).then(res => {
                    this.lists = res.data.lists;
                    this.allpage = res.data.allpage;
                })
            },
            deleteModel(row) {
                this.$confirm('您确定要删除当前菜单吗？', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'error'
                }).then(() => {
                    deleteMenu({
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
