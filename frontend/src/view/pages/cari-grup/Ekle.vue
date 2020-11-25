<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 float-left">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t("CARI_GRUP.DEFINITION") }}</h4>
                        </div>
                        <div class="card-body" v-if="errors">
                            <error-handler v-if="errors" :datas="errors" />
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.ad"
                                    :placeholder="$t('CARI_GRUP.NAME')"
                                />
                                <small class="form-text text-muted">{{
                                    $t("CARI_GRUP.TYPE_A_NAME")
                                }}</small>
                            </div>
                            <div class="form-group">
                                <span
                                    v-if="onSubmitForm"
                                    class="spinner-border float-right"
                                ></span>
                                <button
                                    ref="submit"
                                    v-else
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 float-left">
                    <CariGruplari
                        @cariGruplariUpdate="setUpdateData"
                    ></CariGruplari>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_CARIGRUP } from "@/core/services/store/carigrup.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import CariGruplari from "./Liste";
export default {
    name: "CariGrupEkle",
    components: { CariGruplari },
    data() {
        return {
            form: {
                ad: ""
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
                await this.$store.dispatch(ADD_CARIGRUP, this.form);
                this.form.ad = "";
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
            this.form.ad = obj.ad;
            this.updateID = obj.id;
            this.itemKey = obj.key;
            this.isUpdate = true;
        },
        sendUpdateForm() {
            /*this.onSubmitForm = true;
            this.$store
                .dispatch(UPDATE_, {
                    id: this.updateID,
                    ad: this.form.ad
                })
                .then(() => {
                    this.onSubmitForm = false;
                    this.isUpdate = false;
                    this.itemKey = "";
                    this.updateID = "";
                    this.form.ad = "";
                })
                .catch(() => {
                    this.onSubmitForm = false;
                });*/ console.log(
                "update"
            );
        },
        cancelUpdate() {
            this.form.ad = "";
            this.updateID = "";
            this.itemKey = "";
            this.isUpdate = false;
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("CARI_GRUP.GROUPS") }
        ]);
    }
};
</script>
