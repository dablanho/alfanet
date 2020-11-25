<template>
    <div>
        <AracStandart :arac_id="$route.params.id"></AracStandart>
        <div class="card">
            <div class="card-header">
                <h4>Araç Dosya Ekle</h4>
            </div>
            <div class="card-body">
                <div class="card-header">
                    <h4>Dosya Ekle</h4>
                </div>
                <form class="form col-12" id="kt_form_2">
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <label for="ad">* Dosya Adı</label>
                        <input
                            id="ad"
                            type="text"
                            :placeholder="'Eklenecek Dosyanın Adını Giriniz...'"
                            class="form-control"
                            v-model="form.ad"
                            required
                            autofocus
                        />
                    </div>
                    <div class="form-group pt-2 col-6 col-md-6 float-left">
                        <v-file-input
                            :placeholder="'Eklenecek dosyayı seçin'"
                            v-model="dosya"
                        ></v-file-input>
                    </div>
                    <div class="float-left form-group col-6" v-if="errors">
                        <error-handler v-if="errors" :datas="errors" />
                    </div>
                    <button
                        type="button"
                        class="float-right btn btn-primary"
                        @click.prevent="submitForm"
                    >
                        Ekle
                    </button>
                </form>
            </div>
            <div class="card-body" v-if="fetchVehicleFiles.length">
                <div class="card-header">
                    <h4>Dosyalar</h4>
                </div>
                <div class="card-body">
                    <div class="col-12 col-sm-12">
                        <table
                            class="table table-striped table-hover table-border"
                        >
                            <thead>
                                <tr>
                                    <th class="col-5">Dosya Adı</th>
                                    <th class="col-4">İndir</th>
                                    <th class="col-3">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(value, key) in fetchVehicleFiles"
                                    :key="key"
                                >
                                    <td>{{ value.ad }}</td>
                                    <td>
                                        <a
                                            :href="`${apiUrl}${value.url}`"
                                            download
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                            class="btn btn-sm btn-danger"
                                            @click="deleteFile(value.id)"
                                            >Sil</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_ARAC } from "@/core/services/store/arac.module";
import {
    CREATE_DELETE_VEHICLE_FILE_ACTION,
    FETCH_VEHICLE_FILES_ACTION
} from "@/core/services/store/arac_dosya.module";
import AracStandart from "./AracStandart";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { mapActions, mapGetters } from "vuex";
import { apiUrl } from "@/constants";
export default {
    name: "DosyaEkle",
    data() {
        return {
            form: {
                ad: ""
            },
            dosya: [],
            errors: null,
            apiUrl: apiUrl
        };
    },
    components: { AracStandart },
    methods: {
        ...mapActions({
            get_arac: GET_ARAC,
            create_delete_file_action: CREATE_DELETE_VEHICLE_FILE_ACTION,
            fetch_vehicles_files_action: FETCH_VEHICLE_FILES_ACTION
        }),
        submitForm() {
            let formData = new FormData();
            formData.append("arac_id", this.$route.params.id);
            formData.append("ad", this.form.ad);
            formData.append("dosya", this.dosya);
            this.create_delete_file_action({
                url: "arac/dosyalar/create",
                data: formData,
                msgStatus: false
            })
                .then(() => {
                    this.form.ad = "";
                    this.errors && (this.errors = null);
                })
                .catch(err => {
                    if (err.response.status === 422)
                        this.errors = err.response.data.errors;
                });
        },
        deleteFile(id) {
            window.Swal.fire({
                title: this.$t("GENERAL.ARE_YOU_SURE"),
                text: this.$t("GENERAL.DELETE_PERMANENTLY"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.$t("GENERAL.YES"),
                cancelButtonText: this.$t("GENERAL.NO")
            }).then(result => {
                if (result.value) {
                    this.create_delete_file_action({
                        url: "arac/dosyalar/delete",
                        data: { id },
                        msgStatus: true
                    })
                        .then(() => {
                            this.errors && (this.errors = null);
                        })
                        .catch(err => console.log(err));
                }
            });
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/araclar", title: "Araçlar" },
            {
                title: "Araç Dosya İşlemleri"
            }
        ]);
        this.get_arac(this.$route.params.id);
        this.fetch_vehicles_files_action(this.$route.params.id);
    },
    computed: {
        ...mapGetters(["getArac", "fetchVehicleFiles"])
    }
};
</script>

<style scoped></style>
