<!doctype html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
  <!-- BootstrapVue CSS -->
  <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
  <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"/>-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <title>PERSONEL İŞLEMLERİ</title>
  <style>
    [v-cloak] {
      display: none;
    }
  </style>
</head>

<body>

  <div class="row">
    <div class="col-md-10"></div>
  </div>

  <div class="row">
    <div class="col-md-10"></div>
    <div class="col-md-2"><a href="logout.php" class="btn btn-warning  float-right text-light"> <i class="fas fa-sign-out-alt"></i> Çıkış</a></div>


  </div>


  <div class="container" id="app" v-cloak>
    <div class="row">
      <div class="col-md-12 mt-5">
        <h1 class="text-center">Personel İşlemleri</h1>
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <!-- insert -->
        <div>

          <b-button class="float-left" style="margin-bottom: 10px;" id="show-btn" @click="showModal('my-modal')"><i class="fas fa-plus-circle"></i>    Personel Ekle</b-button>
          <br />

          <b-modal ref="my-modal" hide-footer title="Personel Ekle">
            <div>
              <form action="" @submit.prevent="onSubmit">
                <div class="form-group">
                  <label for="">İsim</label>
                  <input type="text" v-model="name" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="">E-mail</label>
                  <input type="email" v-model="email" class="form-control" />
                </div>
                <div class="form-group">
                  <button class="btn mt-3 btn-outline-success float-right ">Personel Ekle</button>
                  <b-button class="mt-3 float-right" style="margin-right: 10px;" variant="outline-danger" @click="hideModal('my-modal')">Kapat</b-button>

                </div>
              </form>
            </div>

          </b-modal>
        </div>
        <!-- Update -->
        <div>
          <b-modal ref="my-modal1" hide-footer title="Personel Güncelle">
            <div>
              <form action="" @submit.prevent="onUpdate">
                <div class="form-group">
                  <label for="">İsim</label>
                  <input type="text" v-model="edit_name" class="form-control" />
                </div>
                <div class="form-group">
                  <label for="">E-mail</label>
                  <input type="email" v-model="edit_email" class="form-control" />
                </div>
                <div class="form-group">
                  <button class="btn mt-3 btn-outline-success float-right">Güncelle</button>
                  <b-button class="mt-3 float-right" style="margin-right: 10px;" variant="outline-danger" @click="hideModal('my-modal1')">Kapat</b-button>
                </div>
              </form>
            </div>

          </b-modal>
        </div>
      </div>
    </div>
    <div class="row" v-if="records.length">
      <hr>
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>İsim</th>
              <th>E-mail</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(val, i) in records" :key="val.id">
              <td>{{i + 1}}</td>
              <td>{{val.name}}</td>
              <td>{{val.email}}</td>
              <td>
              <button @click="editRecord(val)" class="btn btn-sm btn-info">Düzenle</button>
              <button @click="deleteRecord(val.id)" class="btn btn-sm btn-danger">Sil</button>
              
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>



  </div>
  </div>
  <!-- Vuejs -->
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <!-- BootstrapVue js -->
  <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        name: '',
        email: '',
        records: [],
        edit_id: '',
        edit_name: '',
        edit_email: ''
      },
      methods: {
        showModal(id) {
          this.$refs[id].show()
        },
        hideModal(id) {
          this.$refs[id].hide()
        },
        onSubmit() {
          if (this.name !== '' && this.email !== '') {
            var fd = new FormData()
            fd.append('name', this.name)
            fd.append('email', this.email)
            axios({
                url: 'insert.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('Personel Eklendi')
                  this.name = ''
                  this.email = ''
                  app.hideModal('my-modal')
                  app.getRecords()
                } else {
                  alert('error')
                }
              })
              .catch(err => {
                console.log(err)
              })
          } else {
            alert('empty')
          }
        },
        getRecords() {
          axios({
              url: 'records.php',
              method: 'get'
            })
            .then(res => {

              this.records = res.data.rows
            })
            .catch(err => {
              console.log(err)
            })
        },
        deleteRecord(id) {
          if (window.confirm('Personeli Silmek İstediğinize Emin Misiniz? ')) {
            var fd = new FormData()
            fd.append('id', id)
            axios({
                url: 'delete.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('Personel Kayıtlardan Silindi')
                  app.getRecords();
                } else {
                  alert('error')
                }
              })
              .catch(err => {
                console.log(err)
              })
          }
        },
        editRecord(item) {
          this.edit_id = item.id;
          this.edit_email = item.email;
          this.edit_name = item.name;
          app.showModal('my-modal1');
        },
        onUpdate() {
          if (this.edit_name !== '' && this.edit_email !== '' && this.edit_id !== '') {
            var fd = new FormData()
            fd.append('id', this.edit_id)
            fd.append('name', this.edit_name)
            fd.append('email', this.edit_email)
            axios({
                url: 'update.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('Kayıt Güncellendi');
                  this.edit_name = '';
                  this.edit_email = '';
                  this.edit_id = '';
                  app.hideModal('my-modal1');
                  app.getRecords();
                }
              })
              .catch(err => {
                console.log(err)
              })
          } else {
            alert('empty')
          }
        }
      },
      mounted: function() {
        this.getRecords()
      }
    })
  </script>

  </html>