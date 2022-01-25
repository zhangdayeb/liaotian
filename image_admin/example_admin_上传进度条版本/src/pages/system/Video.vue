<template>
  <div class='page-content'>
    <table-bar :showTop="true" :columns="columns" @changeColumn="changeColumn">
      <div slot="top">
        <el-form label-width="90px">
          <el-row :gutter="20">
            <el-col :xs="24" :sm="12" :lg="6">
              <el-form-item label="名称：">
                <el-input v-model="name" placeholder="名称"></el-input>
              </el-form-item>
            </el-col>
            <el-col :xs="24" :sm="12" :lg="6">
              <el-form-item label="分类：">
                <el-select v-model="video_type_id" style="width:100%" filterable placeholder="分类">
                  <el-option v-for="item in videoTypeList" :key="item.id" :label="item.name" :value="item.id"></el-option>
                </el-select>
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
      <el-table-column label="分类" width="100" prop="video_type_name" v-if="columns[1].show"/>
      <el-table-column label="名称" width="240" prop="name" v-if="columns[2].show"/>
      <el-table-column label="封图片" width="80" prop="image" v-if="columns[3].show">
        <template slot-scope="scope">
          <img :src="scope.row.image" style="width: 50px;height: 50px" @click="clickBig(scope.row.avatar_url)"/>
        </template>
      </el-table-column>
      <el-table-column label="状态" width="70" prop="status" v-if="columns[4].show">
        <template slot-scope="scope">
          <template v-if="scope.row.status == 1">
            <el-tag size="mini" type="success">显示</el-tag>
          </template>
          <template v-else>
            <el-tag size="mini" type="danger">隐藏</el-tag>
          </template>
        </template>
      </el-table-column>
      <el-table-column label="排序值" width="70" prop="order_num" v-if="columns[5].show"/>
      <el-table-column label="视频类型" width="70" prop="type" v-if="columns[6].show">
        <template slot-scope="scope">
          <template v-if="scope.row.type == 1">
            <el-tag size="mini" type="success">上传</el-tag>
          </template>
          <template v-else>
            <el-tag size="mini" type="danger">链接</el-tag>
          </template>
        </template>
      </el-table-column>
      <el-table-column label="视频地址" width="100" prop="video_path" v-if="columns[7].show">
        <template slot-scope="scope">
          <template v-if="scope.row.video_path">
            <el-button type="info" @click="viewFileStr(scope.row.video_path)">查看</el-button>
          </template>
        </template>
      </el-table-column>
      <el-table-column label="上传视频" width="100" prop="video_url" v-if="columns[8].show">
        <template slot-scope="scope">
          <template v-if="scope.row.video_url.length > 0">
            <el-button type="info" @click="viewFileStr(scope.row.video_url[0])">查看</el-button>
          </template>
        </template>
      </el-table-column>
      <el-table-column label="评分" width="80" prop="rate" v-if="columns[9].show"/>
      <el-table-column label="备注" width="150" prop="remark" v-if="columns[10].show"/>
      <el-table-column label="创建时间" width="140" prop="create_time" v-if="columns[11].show"/>
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
        <el-form-item label="分类">
          <el-select v-model="model.video_type_id" style="width:100%" filterable placeholder="请选择分类">
            <el-option v-for="item in videoTypeList" :key="item.id" :label="item.name" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="名称">
          <el-input v-model="model.name" placeholder="请输入名称" style="width:100%"></el-input>
        </el-form-item>
        <el-form-item label="封面图">
          <span style="color:red">注意：只能上传jpg/png文件，建议尺寸300*200</span>
          <el-upload
            class="avatar-uploader"
            :action="uploadImage"
            accept=".jpg,.png"
            name="file"
            :show-file-list="false"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            :on-success="handleAvatarSuccess">
            <img v-if="image" :src="image" style="width:150px;height: 100px;">
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </el-form-item>
        <el-form-item label="排序值">
          <el-input v-model="model.order_num" placeholder="请输入排序值" type="number" style="width:100%"></el-input>
        </el-form-item>
        <el-form-item label="评分">
          <el-input v-model="model.rate" placeholder="请输入评分" type="number" style="width:100%"></el-input>
        </el-form-item>
        <el-form-item label="备注">
          <el-input v-model="model.remark" placeholder="请输入备注" style="width:100%"></el-input>
        </el-form-item>
        <el-form-item label="视频类型">
          <el-select v-model="model.type" style="width:100%" placeholder="请选择视频类型">
            <el-option label="上传" value="1"></el-option>
            <el-option label="链接" value="2"></el-option>
          </el-select>
        </el-form-item>
        <template v-if="model.type == 1">
          <el-form-item label="视频文件">
            <el-upload
              enctype="multipart/form-data"
              class="upload-demo"
              :action="uploadImage"
              accept=".mp4"
              name="file"
              :on-error="handleAvatarError1"
              :on-remove="handleRemove1"
              :file-list="video_url"
              :http-request="uploadFile"
              :on-progress="handleProgress"
              list-type="file">
              <el-button size="small" type="primary">点击上传</el-button>
              <div slot="tip" class="el-upload__tip">
                只能上传MP4文件，且不超过100M
              </div>
            </el-upload>
            <div v-if="progressSeen">
              <el-progress
                :text-inside="true"
                :stroke-width="15"
                :percentage="progress"
                status="success"
              ></el-progress>
            </div>
          </el-form-item>
        </template>
        <template v-if="model.type == 2">
          <el-form-item label="视频链接">
            <el-input v-model="model.video_path" placeholder="请输入视频链接" style="width:100%"></el-input>
          </el-form-item>
        </template>
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
import {getVideoList, editVideo, deleteVideo} from '@/api/videoApi';
import {getVideoTypeListAll} from '@/api/videoTypeApi';
import {uploadImageUrl} from "@/utils/config.js";
import axios from "axios";

export default {
  data() {
    return {
      lists: [],
      allpage: 1,//总页数
      showItem: 5,//分页显示得中间按钮个数
      current: 1,//当前页
      name: '',
      video_type_id: '',
      model: {},
      columns: [
        {name: "ID", show: true},
        {name: "分类", show: true},
        {name: "名称", show: true},
        {name: "封面图", show: true},
        {name: "状态", show: true},
        {name: "排序值", show: true},
        {name: "视频类型", show: true},
        {name: "视频地址", show: true},
        {name: "上传视频", show: true},
        {name: "评分", show: true},
        {name: "备注", show: true},
        {name: "创建时间", show: true},
      ],
      dvEdit: false,
      image: '',
      video_url:[],
      videoTypeList: [],
      uploadImage: uploadImageUrl,
      progress: 0,
      progressSeen: false,
    };
  },
  created: function () {
    this.handleCurrentChange(1);
    this.getCityList();
  },
  methods: {
    viewFileStr:function(file_str){
      if(file_str){
        window.open(file_str);
      }
    },
    getCityList: function () {
      getVideoTypeListAll().then(res => {
        this.videoTypeList = res.data.lists;
      })
    },
    onSubmit: function () {
      editVideo({
        id: this.model.id,
        video_type_id: this.model.video_type_id,
        name: this.model.name,
        order_num: this.model.order_num,
        status: this.model.status,
        remark: this.model.remark,
        image:this.image,
        video_path:this.model.video_path,
        video_url:this.video_url,
        type:this.model.type,
        rate:this.model.rate
      }).then(res => {
        if (res.code === 1) {
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
    showDialog: function () {
      this.model = {};
      this.image = '';
      this.video_url = [];
      this.dvEdit = true;
    },
    updateModel: function (row) {
      this.model = row;
      this.image = row.image;
      this.video_url = [];
      for (let i = 0;i<row.video_url.length;i++){
        let item = {
          'url': row.video_url[i],
          'name': row.video_url[i],
        };
        this.video_url.push(item);
      }
      this.dvEdit = true;
    },
    reset: function () {
      this.name = '';
      this.video_type_id = '';
    },
    search: function () {
      this.handleCurrentChange(1);
    },
    handleCurrentChange: function (index) {
      this.current = index;
      getVideoList({
        page: index,
        name: this.name,
        video_type_id: this.video_type_id
      }).then(res => {
        this.lists = res.data.lists;
        this.allpage = res.data.allpage;
      })
    },
    deleteModel(row) {
      this.$confirm('您确定要删除当前数据吗？', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'error'
      }).then(() => {
        deleteVideo({
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
    },
    handleAvatarSuccess: function (res, file) {
      this.image = res.data.src;
    },
    handleRemove: function (file, fileList) {
      this.image = '';
    },
    beforeRemove: function (file, fileList) {
      this.image = '';
    },
    uploadFile: function (file) {
      //显示进度
      this.progressSeen = true;
      this.video_url = [];
      var fm = new FormData();
      fm.append('file', file.file);
      var config = {
        headers: {
          "Content-Type": "multipart/form-data"
        },
        onUploadProgress: progressEvent => {
          var complete =
            ((progressEvent.loaded / progressEvent.total) * 100) | 0;
          this.progress = complete;
        }
      };
      axios.post('/uploadCommon/uploadImage', fm,config).then(res => {
        var arr = {
          'url': res.data.data.src,
          'name': res.data.data.src,
        };
        this.video_url.push(arr);
        this.progressSeen = false;
      })
    },
    handleRemove1: function (file, fileList) {
      this.video_url = fileList;
    },
    handleProgress:function(event, file, fileList){
      console.log(event);
    },
    handleAvatarError1: function (error, file) {
      this.$message({
        message: error,
        type: 'error'
      });
    },
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
