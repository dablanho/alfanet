<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 float-left">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t("STAFF_GROUP.DEFINITION") }}</h4>
                        </div>
                        <div class="card-body" v-if="errors">
                            <error-handler v-if="errors" :datas="errors" />
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.grupAdi"
                                    aria-describedby="grupAdiHelp"
                                    :placeholder="$t('STAFF_GROUP.NAME')"
                                />
                                <small class="form-text text-muted">{{
                                    $t("STAFF_GROUP.TYPE_A_NAME")
                                }}</small>
                            </div>
                            <div class="form-group">
                                <span
                                    v-if="onSubmitForm"
                                    class="spinner-border float-right"
                                ></span>
                                <template v-else>
                                    <button
                                        ref="submit"
                                        @click="
                                            !isUpdate
                                                ? sendInsertForm()
                                                : sendUpdateForm()
                                        "
                                        :class="{
                                            'btn btn-success': !isUpdate,
                                            'btn btn-warning': isUpdate
                                        }"
                                        class="float-right ml-1"
                                    >
                                        <span
                                            :class="{ 'sr-only': onSubmitForm }"
                                            >{{
                                                !isUpdate
                                                    ? $t("GENERAL.ADD")
                                                    : $t("GENERAL.UPDATE")
                                            }}</span
                                        >
                                    </button>

                                    <button
                                        v-if="isUpdate"
                                        @click="cancelUpdate"
                                        class="btn btn-danger float-right"
                                    >
                                        <span
                                            :class="{ 'sr-only': onSubmitForm }"
                                            >{{ $t("GENERAL.CANCEL") }}</span
                                        >
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 float-left">
                    <PersonelGruplari
                        @personelGrupUpdate="setUpdateData"
                    ></PersonelGruplari>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    SET_GROUP,
    UPDATE_GROUP
} from "@/core/services/store/personel-grup.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import PersonelGruplari from "./PersonelGruplari";
export default {
    name: "personel-grup-ekle",
    components: { PersonelGruplari },
    data() {
        return {
            form: {
                grupAdi: ""
            },
            onSubmitForm: false,
            updateID: "",
            itemKey: "",
            isUpdate: false,
            errors: null
        };
    },
    methods: {
        async sendInsertForm() {
            this.onSubmitForm = true;
            try {
                await this.$store.dispatch(SET_GROUP, this.form);
                this.form.grupAdi = "";
                window.Toast.fire({
                    icon: "success",
                    title: this.$t("REQUEST_MESSAGES.ADD_MESSAGE")
                });
                this.$Progress.finish();
            } catch (error) {
                window.Toast.fire({
                    icon: "error",
                    title: this.$t("REQUEST_MESSAGES.WENT_WRONG")
                });
                this.$Progress.fail();
                this.errors = error.response.data.errors;
            }
            this.onSubmitForm = false;
        },
        setUpdateData(obj) {
            this.form.grupAdi = obj.ad;
            this.updateID = obj.id;
            this.itemKey = obj.key;
            this.isUpdate = true;
        },
        sendUpdateForm() {
            this.onSubmitForm = true;
            this.$store
                .dispatch(UPDATE_GROUP, {
                    id: this.updateID,
                    ad: this.form.grupAdi
                })
                .then(() => {
                    this.onSubmitForm = false;
                    this.isUpdate = false;
                    this.itemKey = "";
                    this.updateID = "";
                    this.form.grupAdi = "";
                })
                .catch(() => {
                    this.onSubmitForm = false;
                });
        },
        cancelUpdate() {
            this.form.grupAdi = "";
            this.updateID = "";
            this.itemKey = "";
            this.isUpdate = false;
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("STAFF_GROUP.GROUPS") }
        ]);
    }
};
</script>
