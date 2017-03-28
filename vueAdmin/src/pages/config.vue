<template>

   <div>
       <!--action="http://localhost/studyApi/PhalApi/Public/?service=User.uploadTx&name=xwk"-->
           <!--<input type="file" name="file" id="txFile">-->
           <!--<button  @click="sub1">上传</button>-->

       <form id="uploadForm">
           <input type="file" name="file" id="txFile" />
           <!--<input type="button" id="btnUpload" value="上传" @click="sub1" />-->
           <el-button @click="sub1" id="btnUpload">上传</el-button>
       </form>
   </div>
</template>

<style>

</style>

<script>
    import Bus from '../common/js/bus.js';
    export default {
        data()
    {
        return {}
    }
    ,
    methods: {
        sub1:function () {
            //判断是否有选择上传文件
            var imgPath = $("#txFile").val();
            if (imgPath == "") {
                alert("请选择上传图片！");
                return;
            }
            //判断上传文件的后缀名
            var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
            if (strExtension != 'jpg' && strExtension != 'gif'
                    && strExtension != 'png' && strExtension != 'bmp') {
                this.$notify.error({
                    title: '错误',
                    message: '请选择图片形式的文件'
                });
                return;
            }

            var formData=new FormData($( "#uploadForm" )[0]);
            var _self=this;
            var user = sessionStorage.getItem('user');
            var name;
            if (user) {
                user = JSON.parse(user);
                name= user.name || '';
            }
            
            $.ajax(
                    {
                        type:'POST',
                        url:'http://localhost/studyApi/PhalApi/Public/?service=User.uploadTx&name='+name,
                        data:formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success:function (data){
                            if(data['data']!=0){
                                var user = sessionStorage.getItem('user');
                                user=JSON.parse(user);
                                user.tx_url=data['data'];
                                sessionStorage.setItem('user',JSON.stringify(user));

                                _self.$notify({
                                    title: '修改成功',
                                    type: 'success',
                                    duration:'2000'
                                });

                                //触发emit
                                Bus.$emit('changeTx',data['data']);

                            }else{
                                _self.$notify.error({
                                    title: '错误',
                                    message: '修改失败',
                                    duration:'2000'
                                });
                            }
                        },
                        error:function (){alert('error')}
                    }
            );
        }

    }
    }
</script>