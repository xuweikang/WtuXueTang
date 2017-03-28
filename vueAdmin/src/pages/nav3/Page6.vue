<template>
	<section>
		<form action="http://localhost/studyApi/PhalApi/Public/?service=User.login" method="post">
			<input type="text" name="login_name">
			<input type="text" name="login_pwd">
			<button type="submit">提交</button>
		</form>

	</section>
</template>
<script>
	function ajax() {

		//先声明一个异步请求对象
	         var xmlHttpReg = null;
	         if (window.ActiveXObject) {//如果是IE

		             xmlHttpReg = new ActiveXObject("Microsoft.XMLHTTP");

		        } else if (window.XMLHttpRequest) {

		             xmlHttpReg = new XMLHttpRequest(); //实例化一个xmlHttpReg
		         }

		        //如果实例化成功,就调用open()方法,就开始准备向服务器发送请求
		         if (xmlHttpReg != null) {
		            xmlHttpReg.open("post", "http://localhost/studyApi/PhalApi/Public/?service=User.login", true);
			               xmlHttpReg.send(null);
			              xmlHttpReg.onreadystatechange = doResult; //设置回调函数

		          }

		          //回调函数
	          //一旦readyState的值改变,将会调用这个函数,readyState=4表示完成相应

		         //设定函数doResult()
		          function doResult() {

			              if (xmlHttpReg.readyState == 4) {//4代表执行完成

			                 if (xmlHttpReg.status == 200) {//200代表执行成功
				                     //将xmlHttpReg.responseText的值赋给ID为resText的元素
				                     console.log(xmlHttpReg.responseText);

				                  }
			              }

		           }


	      }



</script>