<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("PARENT_STUDENT.UPDATE") }}</h4>
            </div>
            <div class="card-body" v-if="errors">
                <error-handler v-if="errors" :datas="errors" />
            </div>
            <div class="card-body">
                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.ad"
                        placeholder="Veli Adı Soyadı..."
                    />
                    <small class="form-text">{{
                        $t("GENERAL.TYPE_A_NAME")
                    }}</small>
                </div>

                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.yakinlik"
                        :placeholder="
                            $t('PARENT_STUDENT.PARENT_PROXIMITY_PLACEHOLDER')
                        "
                    />
                    <small class="form-text">{{
                        $t("PARENT_STUDENT.PARENT_PROXIMITY")
                    }}</small>
                </div>

                <div class="float-left form-group col-6">
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.telefon"
                        placeholder="0555 555 55 55"
                    />
                    <small class="form-text">{{
                        $t("GENERAL.TYPE_PHONE")
                    }}</small>
                </div>
                <div class="float-left form-group col-6">
                    <multiselect
                        v-model="form.ogrenciler"
                        :options="[...getOgrencilerSelect]"
                        :multiple="true"
                        :close-on-select="false"
                        :clear-on-select="false"
                        :preserve-search="true"
                        :placeholder="$t('GENERAL.SELECT')"
                        label="name"
                        track-by="name"
                        :preselect-first="false"
                    >
                        <template
                            slot="selection"
                            slot-scope="{ values, search, isOpen }"
                        >
                            <span
                                class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen"
                            >
                                {{
                                    $t("GENERAL.SELECTED_VALUES_LENGTH", {
                                        values_length: values.length
                                    })
                                }}</span
                            >
                        </template>
                    </multiselect>
                    <small class="form-text">{{
                        $t("PARENT_STUDENT.STUDENTS")
                    }}</small>
                </div>

                <div class="form-group">
                    <button
                        :class="{
                            'spinner-border': isLoading,
                            'btn btn-success': !isLoading
                        }"
                        @click="sendForm"
                        class="float-right"
                    >
                        <span :class="{ 'sr-only': isLoading }">{{
                            $t("GENERAL.SAVE")
                        }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_SELECT } from "@/core/services/store/ogrenci.module";
import Multiselect from "vue-multiselect";
import { UPDATE_VELI, GET_VELI } from "@/core/services/store/veli.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "VeliDuzenle",
    components: {
        Multiselect
    },
    data() {
        return {
            form: {
                ad: "",
                telefon: "",
                yakinlik: "",
                ogrenciler: []
            },
            isLoading: false,
            errors: null
        };
    },
    methods: {
        ...mapActions({
            get_select: GET_SELECT,
            set_breadcrumb: SET_BREADCRUMB,
            get_veli: GET_VELI,
            update_veli: UPDATE_VELI
        }),
        sendForm() {
            this.isLoading = true;
            this.update_veli({
                ...this.form,
                id: this.$route.params.id
            })
                .then(() => {
                    this.isLoading = false;
                })
                .catch(error => {
                    this.isLoading = false;
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors;
                });
        },
        setToUpdate(veli) {
            this.form.ad = veli.ad;
            this.form.telefon = veli.telefon;
            this.form.yakinlik = veli.yakinlik;
            veli.ogrenciler.map(cur => {
                this.form.ogrenciler.push({ id: cur.id, name: cur.name });
            });
        }
    },
    mounted() {
        this.get_veli(this.$route.params.id).then(() =>
            this.setToUpdate(this.getVeli)
        );
        this.set_breadcrumb([
            { route: "/veliler", title: this.$t("PARENT_STUDENT.PARENTS") },
            { title: this.$t("PARENT_STUDENT.UPDATE") }
        ]);
        this.get_select();
    },
    computed: {
        ...mapGetters(["getOgrencilerSelect", "getVeli"])
    }
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
