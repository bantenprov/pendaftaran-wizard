<template>
  <div>


    <form-wizard
      @on-complete="onComplete"
      shape="square"
      color="#3498db"
      finish-button-text="Register"
      :start-index="start_index">

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
              <validate tag="div">
              <label for="kegiatan">Kegiatan</label>
              <v-select @input="kegiatanChange" name="kegiatan" required v-model="model.kegiatan" :options="kegiatan" placeholder="Select Kegiatan"></v-select>

              <field-messages name="kegiatan" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kegiatan tidak boleh kosong</small>
              </field-messages>
              </validate>
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
                <h5> {{ model.nomor_un }} </h5>
            </validate>
          </div>
        </div>

        <div class="form-row">
          <div class="col-md">
            <validate tag="div">
              <label for="nik">NIK</label>
              <input class="form-control" v-model="model.nik" required autofocus name="nik" type="text" placeholder="NIK">

              <field-messages name="nik" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nama_siswa">Nama Siswa</label>
              <input class="form-control" v-model="model.nama_siswa" required autofocus name="nama_siswa" type="text" placeholder="Nama Siswa">

              <field-messages name="nama_siswa" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nomor_kk">No KK</label>
              <input class="form-control" v-model="model.no_kk" required autofocus name="nomor_kk" type="text" placeholder="Nomor KK">

              <field-messages name="nomor_kk" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="alamat_kk">Alamat KK</label>
              <input class="form-control" v-model="model.alamat_kk" required autofocus name="alamat_kk" type="text" placeholder="Alamat KK">

              <field-messages name="alamat_kk" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="tempat_lahir">Tempat Lahir</label>
              <input class="form-control" v-model="model.tempat_lahir" required autofocus name="tempat_lahir" type="text" placeholder="Tempat Lahir">

              <field-messages name="tempat_lahir" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <label for="tgl_lahir">Tanggal Lahir</label>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md-4">
            <validate tag="div">
              <v-select name="tgl_lahir" placeholder="Tanggal" v-model="model.tgl_lahir" required :options="tgl_lahir" class="mb-4"></v-select>
              <field-messages name="tgl_lahir" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Tanggal tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
          <div class="col-md-4">
            <validate tag="div">
              <v-select name="bln_lahir" placeholder="Bulan" v-model="model.bln_lahir" :options="bln_lahir" required class="mb-4"></v-select>

              <field-messages name="bln_lahir" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Bulan tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
          <div class="col-md-4">
            <validate tag="div">
              <v-select name="thn_lahir" placeholder="Tahun" v-model="model.thn_lahir" :options="thn_lahir" required class="mb-4"></v-select>

              <field-messages name="thn_lahir" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Tahun tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <v-select placeholder="Jenis Kelamin" name="jenis_kelamin" v-model="model.jenis_kelamin" required :options="jenis_kelamin" class="mb-4"></v-select>

            <field-messages name="jenis_kelamin" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Jenis Kelamin tidak boleh kosong</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="agama">Agama</label>
            <v-select placeholder="Agama" name="agama" v-model="model.agama" required :options="agama" class="mb-4"></v-select>

            <field-messages name="agama" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Agama Kelamin tidak boleh kosong</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nisn">NISN</label>
              <input class="form-control" v-model="model.nisn" required autofocus name="nisn" type="text" placeholder="NISN">

              <field-messages name="nisn" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Label tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="model.tahun_lulus">Tahun Lulus</label>
            <v-select name="tahun_lulus"   v-model="model.tahun_lulus" :options="tahun_lulus" class="mb-4" required placeholder="Tahun Lulus"></v-select>
            <field-messages name="tahun_lulus" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-danger" slot="required">Tahun Lulus tidak boleh kosong</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="sekolah">Sekolah Tujuan</label>
              <v-select name="sekolah" v-model="model.sekolah" :options="sekolah_filter" @input="changeSekolah" placeholder="Sekolah Tujuan" required></v-select>

              <field-messages name="sekolah" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Sekolah tujuan tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="prodi_sekolah">Prodi Sekolah</label>
              <v-select name="prodi_sekolah" :disabled="disable_prodi_sekolah" v-model="model.prodi_sekolah" :options="prodi_sekolah" placeholder="Prodi Sekolah" :required="required_prodi_sekolah"></v-select>

              <field-messages name="prodi_sekolah" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Prodi Sekolah tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="province_id">Provinsi</label>
              <v-select name="province_id" placeholder="Provinsi" required v-model="model.province" :options="province" @input="changeProvince" class="mb-4"></v-select>

              <field-messages name="province_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">provinsi tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="city_id">Kabupaten</label>
              <v-select placeholder="Kabupaten" name="city_id" v-model="model.city" :options="city" @input="changeCity" required class="mb-4"></v-select>

              <field-messages name="city_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kabupaten tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="district_id">Kota</label>
              <v-select placeholder="Kota" name="district_id" v-model="model.district" :options="district" @input="changeDistrict" required class="mb-4"></v-select>

                <field-messages name="district_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kota tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="village_id">Desa</label>
              <v-select placeholder="Desa" name="village_id" v-model="model.village" :options="village" class="mb-4" required></v-select>

              <field-messages name="village_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Desa tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="user_id">Username</label>
              <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

              <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">User tidak boleh kosong</small>
              </field-messages>
            </validate>
          </div>
        </div>




        </vue-form>

          </div><!-- /.card-body -->
        </div><!-- /.card -->
      </tab-content>

      <tab-content title="Data Orangtua" icon="fa fa-users" :before-change="()=>beforeTabSwitch3(1)">
        <div class="card mb-3">
          <div class="card-header"><i class="fa fa-users" aria-hidden="true"></i> Data Orangtua</div>
          <div class="card-body">

            <vue-form class="form-horizontal form-validation" :state="state_ortu" >

            <div class="form-row mt-4">
              <div class="col-md">
                <validate tag="div">
                <label for="model.nomor_un">Nomor UN :</label>
                  <h5> {{ model.nomor_un }} </h5>
                </validate>
              </div>
            </div>


            <div class="form-row mt-4">
              <div class="col-md">
                <validate tag="div">
                <label for="model.no_telp">Nomor Telepon</label>
                <input class="form-control" v-model="model.no_telp" required autofocus name="no_telp" type="number" placeholder="Nomor Telp">
                <field-messages name="no_telp" show="$invalid && $submitted" class="text-danger">
                  <small class="form-text text-danger" slot="required">Nomor Telp tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Nama Ayah tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Nama Ibu tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Pendidikan Ayah tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Pekerjaan Ayah tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Pendidikan Ibu tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Pekerjaan Ibu tidak boleh kosong</small>
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
                  <small class="form-text text-danger" slot="required">Alamat Orang Tua tidak boleh kosong</small>
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

      <tab-content title="Review"  icon="fa fa-list">
        <div class="card mb-3" id="cetak">
          <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <span id="head">Review</span>
            <button class="btn btn-sm btn-secondary ml-1" id="tombol_cetak" type="button" @click="cetak">
              <i class="fa fa-print" aria-hidden="true"></i> print
            </button>
          </div>
            <div class="card-body">
              <dl class="row">
                <dt class="col-4">Nomor Peserta PPDB</dt>
                <dd class="col-8">{{ model.nomor_un }}</dd>

                <dt class="col-4">Nama</dt>
                <dd class="col-8">{{ model.nama_siswa }}</dd>

                <dt class="col-4">Jenis Pendaftaran</dt>
                <dd class="col-8">{{ model.kegiatan.label }}</dd>

                <dt class="col-4">Sekolah Tujuan</dt>
                <dd class="col-8">{{ model.sekolah.label }}</dd>

                <dt class="col-4">Program Keahlian</dt>
                <dd class="col-8">{{ model.prodi_sekolah.label }}</dd>

                <dt class="col-4">Tanggal Pendaftaran</dt>
                <dd class="col-8">{{ model.tanggal_pendaftaran }}</dd>

                <dt class="col-4">Nilai Bahasa Indonesia</dt>
                <dd class="col-8">{{nilai_terdaftar.bindo}}</dd>

                <dt class="col-4">Nilai Bahasa Inggris</dt>
                <dd class="col-8">{{nilai_terdaftar.bingg}}</dd>

                <dt class="col-4">Nilai Metematika</dt>
                <dd class="col-8">{{nilai_terdaftar.mtk}}</dd>

                <dt class="col-4">Nilai IPA</dt>
                <dd class="col-8">{{nilai_terdaftar.ipa}}</dd>

                <dt class="col-4">Status</dt>
                <dd class="col-8">{{status_now}}</dd>
              </dl>

              <qrcode v-if="terdaftar == true"
                :value="qrcode.val"
                :options="{
                  background: qrcode.bgColor,
                  foreground: qrcode.fgColor,
                  size: qrcode.size,
                  level: 'H'
                }"
                tag="img"
                class="d-block"
              ></qrcode>

            </div><!-- /.card-body -->
        </div><!-- /.card -->
      </tab-content>

    </form-wizard>

  </div>
</template>


<script>
import swal from 'sweetalert2';
import VueMoment from 'vue-moment'
import moment from 'moment-timezone'

Vue.use(VueMoment, {
    moment,
})


var tanggal={}
tanggal.mydate = moment(new Date()).format("YYYY-MM-DD k:mm:ss ");

export default {

  mounted(){

    let app = this;
    this.beforeTabSwitch2(1),
    this.tahunLulus(),
    this.tglLahir(),
    this.blnLahir(),
    this.thnLahir(),

     axios.get('api/pendaftaran/create')
    .then(response => {
        response.data.kegiatan.forEach(element => {
          this.kegiatan.push(element);
        });

        this.model.user = response.data.current_user;
        this.start_index  = (response.data.terdaftar == true) ? 3 : 0;
        if(response.data.terdaftar == true){
          this.terdaftar = true;

          /* kegiatan */
          this.model.kegiatan     = response.data.data_terdaftar.pendaftaran.kegiatan;
          this.model.kegiatan.id  = response.data.data_terdaftar.pendaftaran.kegiatan.id;
          this.model.tanggal_pendaftaran = response.data.data_terdaftar.pendaftaran.tanggal_pendaftaran;

          /* siswa */
          this.model.nomor_un               = response.data.user.name;
          this.model.nik                    = response.data.data_terdaftar.siswa.nik;
          this.model.nama_siswa             = response.data.data_terdaftar.siswa.nama_siswa;
          this.model.no_kk                  = response.data.data_terdaftar.siswa.no_kk;
          this.model.alamat_kk              = response.data.data_terdaftar.siswa.alamat_kk;
          this.model.province               = response.data.data_terdaftar.siswa.province;
          this.model.city                   = response.data.data_terdaftar.siswa.city;
          this.model.district               = response.data.data_terdaftar.siswa.district;
          this.model.village                = response.data.data_terdaftar.siswa.village;
          this.model.tempat_lahir           = response.data.data_terdaftar.siswa.tempat_lahir;
          this.model.tgl_lahir              = response.data.data_terdaftar.siswa.tgl_lahir.slice(8,10);
          this.model.bln_lahir              = response.data.data_terdaftar.siswa.tgl_lahir.slice(5,7);
          this.model.thn_lahir              = response.data.data_terdaftar.siswa.tgl_lahir.slice(0,4);
          this.model.jenis_kelamin          = response.data.data_terdaftar.siswa.jenis_kelamin;
          this.model.agama                  = response.data.data_terdaftar.siswa.agama;
          this.model.nisn                   = response.data.data_terdaftar.siswa.nisn;
          this.model.tahun_lulus            = response.data.data_terdaftar.siswa.tahun_lulus;
          this.model.sekolah                = response.data.data_terdaftar.siswa.sekolah;

          if(response.data.data_terdaftar.pendaftaran.kegiatan.id == 21 || response.data.data_terdaftar.pendaftaran.kegiatan.id == 22){
            this.model.prodi_sekolah          = response.data.data_terdaftar.siswa.prodi_sekolah.program_keahlian;
          }else{
            this.model.prodi_sekolah          = {id: 0, label: '-'};
          }

          /* orang tua */

          this.model.no_telp                = response.data.data_terdaftar.orang_tua.no_telp;
          this.model.nama_ayah              = response.data.data_terdaftar.orang_tua.nama_ayah;
          this.model.nama_ibu               = response.data.data_terdaftar.orang_tua.nama_ibu;
          this.model.pendidikan_ayah        = response.data.data_terdaftar.orang_tua.pendidikan_ayah;
          this.model.kerja_ayah             = response.data.data_terdaftar.orang_tua.kerja_ayah;
          this.model.pendidikan_ibu         = response.data.data_terdaftar.orang_tua.pendidikan_ibu;
          this.model.kerja_ibu              = response.data.data_terdaftar.orang_tua.kerja_ibu;
          this.model.alamat_ortu            = response.data.data_terdaftar.orang_tua.alamat_ortu;

          /* nilai */
          this.nilai_terdaftar.bindo        = response.data.data_terdaftar.nilai_un.bahasa_indonesia;
          this.nilai_terdaftar.bingg        = response.data.data_terdaftar.nilai_un.bahasa_inggris;
          this.nilai_terdaftar.mtk          = response.data.data_terdaftar.nilai_un.matematika;
          this.nilai_terdaftar.ipa          = response.data.data_terdaftar.nilai_un.ipa;

          /* status */
          this.status_now                       = response.data.data_terdaftar.status_now;

          this.qrcode.val = window.location.origin + '/check-peserta/' + this.model.nomor_un
        }else{
          this.terdaftar = false;
        }

    })
    .catch(function(response) {
      alert('Break');
    });

        axios.get('api/siswa/create')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.nomor_un = response.data.users.name;
          this.model.no_kk = response.data.data_akademik.nomor_kk;
          this.model.nama_siswa = response.data.data_akademik.nama_siswa;

          this.model.user = response.data.current_user;
          if(response.data.user_special == true){
            this.user = response.data.users;
          }else{
            this.user.push(response.data.users);
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );
          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );
        app.back();
      });
    axios.get('api/wilayah-indonesia/province/get')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.province = response.data.provinces;
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );
          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );
        app.back();
      });
      axios.get('api/sekolah/get')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.sekolah = response.data.sekolahs;
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );
          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );
        app.back();
      });
  },
  data() {
    return {
      state_daftar: {},
      state_siswa : {},
      state_ortu  : {},
      show_review : false,
      qrcode:{
        val     : window.location.href,
        bgColor : "#FFFFFF",
        fgColor : "#000000",
        size    : 140
      },
      nilai_terdaftar:{
        bindo:'',
        bingg:'',
        ipa:'',
        mtk:''
      },
      status_now: '-',
      model: {
        tanggal_pendaftaran: tanggal.mydate,

        kegiatan          : "",

        nomor_un          : "",
        nik               : "",

        nama_siswa        : "",
        alamat_kk         : "",
        tempat_lahir      : "",

        tgl_lahir         : "",
        bln_lahir         : "",
        thn_lahir         : "",
        jenis_kelamin     : "",
        agama             : "",
        nisn              : "",
        tahun_lulus       : "",
        sekolah_id        : "",
        prodi_sekolah_id  : "",
        user_id           : "",
        created_at        : "",
        updated_at        : "",
        province          : "",
        city              : "",
        district          : "",
        village           : "",
        sekolah           : "",
        prodi_sekolah     : "",
        user              : "",

        no_kk             : '',
        no_telp           : '',
        nama_ayah         : '',
        nama_ibu          : '',
        pendidikan_ayah   : '',
        kerja_ayah        : '',
        pendidikan_ibu    : '',
        kerja_ibu         : '',
        alamat_ortu       : '',
      },
      kegiatan                : [],
      user                    : [],
      tahun_lulus             : [],

      province                : [],
      city                    : [],
      district                : [],
      village                 : [],
      sekolah                 : [],
      sekolah_filter          : [],
      prodi_sekolah           : [],
      disable_prodi_sekolah   : '',
      required_prodi_sekolah  : '',
      start_index             : 0,
      terdaftar               : false,

      /* tgl lahir */
      tgl_lahir               : [],
      bln_lahir               : [],
      thn_lahir               : [],

      formOptions: {
        validationErrorClass  : "has-error",
        validationSuccessClass: "has-success",
        validateAfterChanged  : true
      },

      jenis_kelamin: [
        {id: 1, label: 'Laki-laki'},
        {id: 2, label: 'Perempuan'}
      ],
      selectedJenisKelamin: {id: "-", label: 'Pilih Salah Satu'},

      agama: [
        {id: 1, label: 'Islam'},
        {id: 2, label: 'Kristen Protestan'},
        {id: 3, label: 'Kristen Katolik'},
        {id: 4, label: 'Hindu'},
        {id: 5, label: 'Buddha'},
        {id: 6, label: 'Khonghucu'}
      ],
      selectedAgama: {id: "-", label: 'Pilih Salah Satu'},
    }
  },
  methods: {
    cetak () {

      var content = document.getElementById('cetak').innerHTML;
      var mywindow = window.open('', 'Print', 'height=600,width=800');

      mywindow.document.write('<html><head><title>Print</title>');
      mywindow.document.write(`</head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" />
      <body >`);
      mywindow.document.write(content);
      mywindow.document.getElementById('head').innerHTML = 'Kartu Peserta PPDB 2018';
      mywindow.document.getElementById('tombol_cetak').style.display = "none";

      mywindow.document.write('</body></html>');

      mywindow.focus()

      return true;

    },

    tglLahir(){
      for(var i = 1; i <= 31; i++){
        this.tgl_lahir.push({id:i,label:`${i}`});
      }
    },

    blnLahir(){
      this.bln_lahir = [
        {id:'01',label:'Januari'},
        {id:'02',label:'Februari'},
        {id:'03',label:'Maret'},
        {id:'04',label:'April'},
        {id:'05',label:'Mei'},
        {id:'06',label:'Juni'},
        {id:'07',label:'Juli'},
        {id:'08',label:'Agustus'},
        {id:'09',label:'September'},
        {id:'10',label:'Oktober'},
        {id:'11',label:'November'},
        {id:'12',label:'Desember'},
      ]
    },

    thnLahir(){
      for(var i = 1980; i <= (new Date()).getFullYear(); i++){
        this.thn_lahir.push({id:i, label:`${i}`});
      }
    },

    tahunLulus: function(){

      for(var i = ((new Date()).getFullYear() - 10); i <= (new Date()).getFullYear(); i++)
      {
        this.tahun_lulus.push({id:i,label:`${i}`});
      }
    },
    beforeTabSwitch1: function(){
      let app = this;

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


      if (this.state_siswa.$invalid ) {
        miniToastr.error('Data Tidak Lengkap', 'ERROR')
        this.state_siswa.$submitted = true;
        return false;
      } else {
        return true;
      }
    },

    beforeTabSwitch3: function(){
      let app = this;


      if (this.state_ortu.$invalid ) {
        miniToastr.error('Data Tidak Lengkap', 'ERROR')
        this.state_ortu.$submitted = true;
        return false;
      } else {
        return true;
      }
    },

    onComplete: function() {
      let app = this;

      if (this.state_ortu.$invalid) {
        miniToastr.error('Data Orangtua Tidak Lengkap', 'ERROR');
        this.state_ortu.$submitted = true;
        return false;

      } else {
          axios.post('api/pendaftaran-wizard',{
            kegiatan_id       : this.model.kegiatan.id,
            user_id           : this.model.user.id,
            nomor_un          : this.model.nomor_un,
            nik               : this.model.nik,
            nama_siswa        : this.model.nama_siswa,
            no_kk             : this.model.no_kk,
            alamat_kk         : this.model.alamat_kk,
            province_id       : this.model.province.id,
            city_id           : this.model.city.id,
            district_id       : this.model.district.id,
            village_id        : this.model.village.id,
            tempat_lahir      : this.model.tempat_lahir,
            tgl_lahir         : this.model.thn_lahir.id + '-' + this.model.bln_lahir.id + '-' + this.model.tgl_lahir.id,
            jenis_kelamin     : this.model.jenis_kelamin.label,
            agama             : this.model.agama.label,
            nisn              : this.model.nisn,
            tahun_lulus       : this.model.tahun_lulus.id,
            sekolah_id        : this.model.sekolah.id,
            prodi_sekolah_id  : this.model.prodi_sekolah.id,
            user_id           : this.model.user.id,
            no_telp           : this.model.no_telp,
            nama_ayah         : this.model.nama_ayah,
            nama_ibu          : this.model.nama_ibu,
            pendidikan_ayah   : this.model.pendidikan_ayah,
            kerja_ayah        : this.model.kerja_ayah,
            pendidikan_ibu    : this.model.pendidikan_ibu,
            kerja_ibu         : this.model.kerja_ibu,
            alamat_ortu       : this.model.alamat_ortu
          })
          .then((response) =>{
            if(response.data.status == true){
              this.terdaftar = true;
              this.qrcode.val = window.location.origin + '/check-peserta/' + this.model.nomor_un;
              swal(
                response.data.title,
                response.data.message,
                response.data.type,
              ).then((result) => {
                if(response.data.type == 'error'){
                  return false;
                }else{
                  window.location.reload()
                }

              });
            }

          })
          .catch((response) => {
            swal(
              'Pendaftaran Gagal',
              'Telah terjadi kesalahan, mohon ulangi penginputan data.',
              'error'
            );
          })
      }
    },
    kegiatanChange() {
      this.sekolah_filter = [];
      if(this.terdaftar == false){
        this.model.sekolah = '';
        this.model.prodi_sekolah = '';
      }

      this.model.required_prodi_sekolah = true;

      if(this.model.kegiatan.id == 11 || this.model.kegiatan.id == 12){
        this.disable_prodi_sekolah = true;
        this.required_prodi_sekolah = false;
        for (var i = 0; i < this.sekolah.length; i++) {
            if (this.sekolah[i].label.includes("SMA") && this.sekolah[i].city_id.includes(this.model.no_kk.slice(0,4))) {
                this.sekolah_filter.push(this.sekolah[i]);
            }
        }
      }else if(this.model.kegiatan.id == 21 || this.model.kegiatan.id == 22){
        this.disable_prodi_sekolah = false;
        this.required_prodi_sekolah = true;
        for (var i = 0; i < this.sekolah.length; i++) {
            if (this.sekolah[i].label.includes("SMK")) {
                this.sekolah_filter.push(this.sekolah[i]);
            }
        }
      }
    },
    changeProvince() {
      if (typeof this.model.province.id === 'undefined') {
        this.model.city = "";
      } else {

        if(this.terdaftar == false){
          this.model.city = "";
        }
        axios.get('api/wilayah-indonesia/city/get/by-province/'+this.model.province.id)
          .then(response => {
            if (response.data.status == true && response.data.error == false) {
              this.city = response.data.cities;
            }
          });
      }
    },
    changeCity() {
      if (typeof this.model.city.id === 'undefined') {
        this.model.district = "";
      } else {
        if(this.terdaftar == false){
          this.model.district = "";
        }

        axios.get('api/wilayah-indonesia/district/get/by-city/'+this.model.city.id)
          .then(response => {
            if (response.data.status == true && response.data.error == false) {
              this.district = response.data.districts;
            }
          });
      }
    },
    changeDistrict() {
      if (typeof this.model.district.id === 'undefined') {
        this.model.village = "";
      } else {

        if(this.terdaftar == false){
          this.model.village = "";
        }
        axios.get('api/wilayah-indonesia/village/get/by-district/'+this.model.district.id)
          .then(response => {
            if (response.data.status == true && response.data.error == false) {
              this.village = response.data.villages;
            }
          });
      }
    },
    changeSekolah() {

      if(this.terdaftar == false){
        this.model.prodi_sekolah = '';
      }
      if (typeof this.model.sekolah.id !== "undefined") {
        axios.get('api/prodi-sekolah/get/by-sekolah/'+this.model.sekolah.id)
          .then(response => {
            if (response.data.status == true && response.data.error == false) {
              this.prodi_sekolah = response.data.prodi_sekolahs;
            }
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
      window.location = '#/dashboard';
    }
  }
}
</script>


