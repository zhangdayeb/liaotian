<template>
    <div class='page-content'>
<!--        <table-bar :showTop="true" :columns="columns" @changeColumn="changeColumn">
            <div slot="bottom">
                <el-button type="primary" plain @click="showDialog">新增</el-button>
            </div>
        </table-bar>-->
        <el-table :data="lists" :showPage="false" border ref="table">
            <el-table-column label="ID" width="80" prop="id" v-if="columns[0].show"/>
            <el-table-column label="标题" width="850" prop="title" v-if="columns[1].show"/>
            <el-table-column fixed="right" label="操作" width="160">
                <template slot-scope="scope">
                    <el-button type="primary" @click="updateModel(scope.row)" size="mini">修改</el-button>
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
        <el-dialog title="编辑" width="50%" :visible.sync="dvEdit" :before-close="handleClose">
            <el-form ref="model" :model="model" label-width="80px">
                <el-form-item label="标题">
                    <el-input v-model="model.title" placeholder="请输入标题"
                              style="width:100%"></el-input>
                </el-form-item>
                <el-form-item label="详情">
                    <quill-editor class="editor" ref="quillEditor" v-model="model.detail" :options="editorOption"/>
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
    import {getNoticeList, editNotice} from '@/api/noticeApi';
    import quillConfig from "@/utils/quill-config.js";
    import {quillEditor} from 'vue-quill-editor';
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import '@/config/quill/quill.scss'

    export default {
        components: {
            quillEditor
        },
        data() {
            return {
                lists: [],
                allpage: 1,//总页数
                showItem: 5,//分页显示得中间按钮个数
                current: 1,//当前页
                model: {},
                columns: [
                    {name: "ID", show: true},
                    {name: "标题", show: true},
                ],
                dvEdit: false,
                editorOption: quillConfig,
            };
        },
        created: function () {
            this.handleCurrentChange(1);
        },
        methods: {
          onSubmit: function () {
            editNotice({
              id: this.model.id,
              title:this.model.title,
              detail: this.model.detail,
            }).then(res => {
              if (res.code === 1) {
                this.$message({
                  message: '操作成功',
                  type: 'success'
                });
                this.dvEdit = false;
                this.handleCurrentChange(this.current);
              }
            })
          },
          showDialog: function () {
            this.model = {};
            this.dvEdit = true;
          },
          updateModel: function (row) {
            this.model = row;
            this.dvEdit = true;
          },
          handleCurrentChange: function (index) {
            this.current = index;
            getNoticeList({
              page: index,
            }).then(res => {
              this.lists = res.data.lists;
              this.allpage = res.data.allpage;
            })
          },
          changeColumn(columns) {
            this.columns = columns;
            this.$refs.table.doLayout();
          },
          handleClose:function(done) {
            this.$confirm('确认关闭？')
              .then(_ => {
                done();
              })
              .catch(_ => {});
          }
        }
    }
</script>

<style lang='scss' scoped>
    .page-content {
        width: 100%;
        height: 100%;
    }

    avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }

    input[type='file'] {
        display: none;
    }
</style>
