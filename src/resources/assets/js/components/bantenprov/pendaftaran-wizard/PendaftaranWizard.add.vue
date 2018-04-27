<template>
  <div>


    <form-wizard
      @on-complete="onComplete"
      shape="square"
      color="#3498db">

      <div class="text-center mb-3" slot="title">
      </div>

      <tab-content title="Pendaftaran"  icon="fa fa-gear" :before-change="()=>beforeTabSwitch1(1)">
        <div class="card mb-3">
          <div class="card-header"><i class="fa fa-gear" aria-hidden="true"></i> Pendaftaran</div>
          <div class="card-body">

        <vue-form class="form-horizontal form-validation" :state="state_daftar">
          <div class="form-row">
            <div class="col-md">
              <validate tag="div">
                <label for="model.tanggal_pendaftaran">Tanggal Pendaftaran</label>
                 <input disabled class="form-control" type="datetime"  v-model="model.tanggal_pendaftaran"  name="tanggal_pendaftaran" >
              </validate>
            </div>
          </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <label for="kegiatan">Kegiatan</label>
            <v-select name="kegiatan" required v-model="model.kegiatan" :options="kegiatan" placeholder="Select Kegiatan"></v-select>
          </div>
        </div>

        <div class="form-row mt-4">
					<div class="col-md">
						<label for="user_id">Username</label>
						<v-select name="user_id"  disabled="disabled"  v-model="model.user" :options="user" class="mb-4"></v-select>
					</div>
				</div>

      </vue-form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </tab-content>

      <tab-content title="Data Siswa" icon="fa fa-user" :before-change="()=>beforeTabSwitch2(1)">
        <div class="card mb-3">
          <div class="card-header"><i class="fa fa-user" aria-hidden="true"></i> Data Siswa</div>
          <div class="card-body">

        <vue-form class="form-horizontal form-validation" :state="state_siswa" >


        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.nomor_un">Nomor UN</label>
            <input class="form-control" v-model="model.nomor_un" required autofocus name="nomor_un" type="number" placeholder="Nomor UN">
            <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Nomor UN is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.nik">NIK</label>
              <input class="form-control" v-model="model.nik" required autofocus name="nik" type="number" placeholder="NIK" v-mask="'##-##-####-####-######'"  >
             
            <field-messages name="nik" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">NIK is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.nama_siswa">Nama Siswa</label>
            <input class="form-control" v-model="model.nama_siswa" required autofocus name="nama_siswa" type="text" placeholder="Nama Siswa">
            <field-messages name="nama_siswa" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Nama Siswa is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>


        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.no_kk">Nomor Kartu Keluarga</label>
               <input class="form-control" v-model="model.no_kk" required autofocus name="no_kk" type="number" v-mask="'################'" placeholder="Nomor Kartu Keluarga" >
            
            <field-messages name="no_kk" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Nomor KK is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.alamat_kk">Alamat Kartu Keluarga</label>
            <input class="form-control" v-model="model.alamat_kk" required autofocus name="alamat_kk" type="text" placeholder="Alamat KK">
            <field-messages name="alamat_kk" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Alamat KK is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.tempat_lahir">Tempat Lahir</label>
            <input class="form-control" v-model="model.tempat_lahir" required autofocus name="tempat_lahir" type="text" placeholder="Tempat Lahir">
            <field-messages name="tempat_lahir" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Tempat Lahir is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.tgl_lahir">Tanggal Lahir</label>
            <input class="form-control" v-model="model.tgl_lahir" required autofocus name="tgl_lahir" type="date" placeholder="Tanggal Lahir">
            <field-messages name="tgl_lahir" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Tanggal Lahir is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.jenis_kelamin">Jenis Kelamin</label>
            <!--input class="form-control" v-model="model.jenis_kelamin" required autofocus name="jenis_kelamin" type="text" placeholder="Jenis Kelamin"-->
            <v-select name="jenis_kelamin" v-model="model.jenis_kelamin" required :options="['Laki-laki','Perempuan']" placeholder="Jenis Kelamin"></v-select>
            <field-messages name="jenis_kelamin" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Jenis Kelamin is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.agama">Agama</label>
            <v-select name="agama" v-model="model.agama" required :options="['Islam','Kristen','Protestan','Hindu','Budha','Konghucu']" placeholder="Agama"></v-select>
            <field-messages name="agama" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Agama is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.nisn">NISN</label>
            <input class="form-control" v-model="model.nisn" required autofocus name="nisn" type="number" placeholder="NISN">
            <field-messages name="nisn" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">NISN is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.tahun_lulus">Tahun Lulus</label>
            <v-select name="tahun_lulus"   v-model="model.tahun_lulus" :options="tahun_lulus" class="mb-4" placeholder="Tahun Lulus"></v-select>
            <field-messages name="tahun_lulus" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Tahun Lulus is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <label for="user_id">Username</label>
            <v-select name="user_id"  disabled="disabled" v-model="model.user" :options="user" class="mb-4"></v-select>
          </div>
        </div>


      </vue-form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </tab-content>

      <tab-content title="Data Orangtua" icon="fa fa-users">
        <div class="card mb-3">
          <div class="card-header"><i class="fa fa-users" aria-hidden="true"></i> Data Orangtua</div>
          <div class="card-body">

          <vue-form class="form-horizontal form-validation" :state="state_ortu" >

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.nomor_un">Nomor UN :</label>
              <p><h5> {{ model.nomor_un }} </h5></p>

              <!--input class="form-control" disabled="disabled" v-model="model.nomor_un" required autofocus name="nomor_un" type="number" placeholder="Nomor UN">
              <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Nomor UN is a required field</small>
              </field-messages-->
              </validate>
            </div>
          </div>


          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.no_telp">Nomor Telepon</label>
              <input class="form-control" v-model="model.no_telp" required autofocus name="no_telp" type="tel" v-mask="'(###)-######-####'"  placeholder="Nomor Telp">
              <field-messages name="no_telp" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Nomor Telp is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.nama_ayah">Nama Ayah</label>
              <input class="form-control" v-model="model.nama_ayah" required autofocus name="nama_ayah" type="text" placeholder="Nama Ayah">
              <field-messages name="nama_ayah" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Nama Ayah is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.nama_ibu">Nama Ibu</label>
              <input class="form-control" v-model="model.nama_ibu" required autofocus name="nama_ibu" type="text" placeholder="Nama Ibu">
              <field-messages name="nama_ibu" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Nama Ibu is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.pendidikan_ayah">Pendidikan Ayah</label>
              <input class="form-control" v-model="model.pendidikan_ayah" required autofocus name="pendidikan_ayah" type="text" placeholder="Pendidikan Ayah">
              <field-messages name="pendidikan_ayah" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Pendidikan Ayah is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.kerja_ayah">Pekerjaan Ayah</label>
              <input class="form-control" v-model="model.kerja_ayah" required autofocus name="kerja_ayah" type="text" placeholder="Pekerjaan Ayah">
              <field-messages name="kerja_ayah" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Pekerjaan Ayah is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.pendidikan_ibu">Pendidikan Ibu</label>
              <input class="form-control" v-model="model.pendidikan_ibu" required autofocus name="pendidikan_ibu" type="text" placeholder="Pendidikan Ibu">
              <field-messages name="pendidikan_ibu" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Pendidikan Ibu is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.kerja_ibu">Pekerjaan Ibu</label>
              <input class="form-control" v-model="model.kerja_ibu" required autofocus name="kerja_ibu" type="text" placeholder="Pekerjaan Ibu">
              <field-messages name="kerja_ibu" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Pekerjaan Ibu is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <validate tag="div">
              <label for="model.alamat_ortu">Alamat Orang Tua</label>
              <input class="form-control" v-model="model.alamat_ortu" required autofocus name="alamat_ortu" type="text" placeholder="Alamat Orang Tua">
              <field-messages name="alamat_ortu" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-danger" slot="required">Alamat Orang Tua is a required field</small>
              </field-messages>
              </validate>
            </div>
          </div>

          <div class="form-row mt-4">
            <div class="col-md">
              <label for="user_id">Username</label>
              <v-select name="user_id" disabled="disabled" v-model="model.user" :options="user" class="mb-4"></v-select>
            </div>
          </div>

      </vue-form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </tab-content>
    </form-wizard>

</tr>

  </div>
</template>


<script>
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'
//Add Vue Mask https://vuejs-tips.github.io/vue-the-mask/
import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)
Vue.use(VueMoment, {
    moment,
})


var tanggal={}
tanggal.mydate = moment(new Date()).format("YYYY-MM-DD k:mm:ss ");

export default {

  mounted(){
    this.tahunLulus(),
    axios.get('api/pendaftaran/create')
    .then(response => {
        response.data.kegiatan.forEach(element => {
          this.kegiatan.push(element);
        });
        this.model.user = response.data.current_user;


    })
    .catch(function(response) {
      alert('Break');
    });
  },
  data() {
    return {
      state_daftar: {},
      state_siswa: {},
      state_ortu: {},
      model: {
        tanggal_pendaftaran: tanggal.mydate,
        user: "",
        kegiatan: "",

        label: "",
        description: "",
        nomor_un: "",
        nik: "",
        nama_siswa: "",
        alamat_kk: "",
        tempat_lahir: "",
        tgl_lahir: "",
        jenis_kelamin: "",
        agama: "",
        nisn: "",
        tahun_lulus: "",

        no_kk : '',
        no_telp : '',
        nama_ayah : '',
        nama_ibu : '',
        pendidikan_ayah : '',
        kerja_ayah : '',
        pendidikan_ibu : '',
        kerja_ibu : '',
        alamat_ortu : '',
      },
      kegiatan: [],
      user: [],
      tahun_lulus: [],
      formOptions: {
        validationErrorClass: "has-error",
        validationSuccessClass: "has-success",
        validateAfterChanged: true
      }
    }
  },
  methods: {
    tahunLulus: function(){

      for(var i = ((new Date()).getFullYear() - 10); i <= (new Date()).getFullYear(); i++)
      {
        this.tahun_lulus.push({id:i,label:`${i}`});
      }
    },
    beforeTabSwitch1: function(){
      let app = this;

     //alert("This is called before switchind tabs")
      if (this.state_daftar.$invalid  ) {
        miniToastr.error('Data Tidak Lengkap', 'ERROR')
        this.state_daftar.$submitted = true;
        return false;
      } else {
        return true;
      }
    },
    beforeTabSwitch2: function(){
      let app = this;

     //alert("This is called before switchind tabs")
      if (this.state_siswa.$invalid ) {
        miniToastr.error('Data Tidak Lengkap', 'ERROR')
        this.state_siswa.$submitted = true;
        return false;
      } else {
        return true;
      }
    },


    // onComplete: function () {
    //   miniToastr.success('Yay. Done!', 'Success');
    // },

    onComplete: function() {
      let app = this;

      if (this.state_ortu.$invalid) {
        miniToastr.error('Data Orangtua Tidak Lengkap', 'ERROR');
        return;
      } else {
        axios.post('api/pendaftaran', { 
            kegiatan_id: this.model.kegiatan.id,
            user_id: this.model.user.id
          })
        .then(response => {
            console.log(response.data.status);
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                //miniToastr.success(response.data.message, 'Success:');
                //alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })

         axios.post('api/siswa', {
            user_id: this.model.user.id,
            nomor_un: this.model.nomor_un,
            nik: this.model.nik,
            nama_siswa: this.model.nama_siswa,
            no_kk : this.model.no_kk,
            alamat_kk: this.model.alamat_kk,
            tempat_lahir: this.model.tempat_lahir,
            tgl_lahir: this.model.tgl_lahir,
            jenis_kelamin: this.model.jenis_kelamin,
            agama: this.model.agama,
            nisn: this.model.nisn,
            tahun_lulus: this.model.tahun_lulus

          })
         .then(response => {
            console.log(response.data.status);
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                //miniToastr.success(response.data.message, 'Success:');
                //alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })

         axios.post('api/orang-tua', {
            user_id : this.model.user.id,
            nomor_un : this.model.nomor_un,
            no_telp : this.model.no_telp,
            nama_ayah : this.model.nama_ayah,
            nama_ibu : this.model.nama_ibu,
            pendidikan_ayah : this.model.pendidikan_ayah,
            kerja_ayah : this.model.kerja_ayah,
            pendidikan_ibu : this.model.pendidikan_ibu,
            kerja_ibu : this.model.kerja_ibu,
            alamat_ortu : this.model.alamat_ortu
          })
          .then(response => {
            console.log(response.data.status);
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                miniToastr.success(response.data.message, 'Success:');
                //alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            miniToastr.error('Ada kesalahan data', 'Error:');
            //alert('Break');
          });
      }
    },
    reset() {
      this.model = {
          label: "",
          description: ""
      };
    },
    back() {
      window.location = '#/admin/pendaftaran';
    }
  }
}
</script>

