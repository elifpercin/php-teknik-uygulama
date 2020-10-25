<?php
	session_start();
	if(isset($_SESSION['user'])){
		header('location:index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Giriş Paneli</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
</head>
<body>
<div class="container">
	<h1 class="page-header text-center ">Kullanıcı Giriş Paneli</h1>
	<div id="login">
        <div class="col-md-3"></div>
		<div class="col-md-6">
 
			<div class="panel panel-info ">
			  	<div class="panel-heading"><i class="fas fa-user-lock"></i>  Kullanıcı Girişi</div>
			  	<div class="panel-body">
			    	<label>Kullanıcı Adı:</label>
			    	<input type="text" class="form-control" placeholder="Lütfen kullanıcı adınızı giriniz" v-model="logDetails.username" v-on:keyup="keymonitor">
			    	<label>Şifre:</label>
			    	<input type="password" class="form-control" placeholder="Lütfen şifrenizi giriniz" v-model="logDetails.password" v-on:keyup="keymonitor">
			  	</div>
			  	<div class="panel-footer">
			  		<button class="btn btn-info btn-block" @click="checkLogin();"> Giriş </button>
			  	</div>
			</div>
            <template  v-if="errorMessage">
			    <div class="alert alert-danger text-center">
				    <button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				    <span class="glyphicon glyphicon-alert"></span> {{ errorMessage }}
			    </div>
            </template>
            <template  v-if="successMessage">
			    <div class="alert alert-success text-center" >
				    <button type="button" class="close" @click="clearMessage();"><span aria-hidden="true">&times;</span></button>
				    <span class="glyphicon glyphicon-check"></span> {{ successMessage }}
			    </div>
            </template>
        </div>
        
        <div class="col-md-3"></div>
	</div>
</div>
    <!-- Vuejs -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
  var app = new Vue({
	el: '#login',
	data:{
		successMessage: "",
		errorMessage: "",
		logDetails: {username: '', password: ''},
	},
 
	methods:{
		keymonitor: function(event) {
       		if(event.key == "Enter"){
         		app.checkLogin();
        	}
       	},
 
		checkLogin: function(){
			var logForm = app.toFormData(app.logDetails);
			axios.post('logincon.php', logForm)
				.then(function(response){
                   
					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
                     
						app.successMessage = response.data.message;
						app.logDetails = {username: '', password:''};
						setTimeout(function(){
							window.location.href="index.php";
						},3000);
 
					}
				});
		},
 
		toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
 
		clearMessage: function(){
			app.errorMessage = '';
			app.successMessage = '';
		}
 
	}
  });
</script> 


</body>
</html>