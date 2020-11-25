<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 float-left">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $t("FIYATLANDIRMA.DEFINITION") }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="form.ad"
                                    :placeholder="$t('FIYATLANDIRMA.NAME')"
                                />
                                <small class="form-text text-muted">{{
                                    $t("FIYATLANDIRMA.TYPE_A_NAME")
                                }}</small>
                            </div>
                            <div class="form-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="form.oran"
                                    :placeholder="$t('FIYATLANDIRMA.ORAN')"
                                />
                                <small class="form-text text-muted">{{
                                    $t("FIYATLANDIRMA.TYPE_A_ORAN")
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
                                        >
                                            {{
                                                !isUpdate
                                                    ? $t("GENERAL.ADD")
                                                    : $t("GENERAL.UPDATE")
                                            }}
                                        </span>
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
                    <Fiyatlandirmalar
                        @vergiGrupUpdate="setUpdateData"
                    ></Fiyatlandirmalar>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_FIYATLANDIRMA } from "@/core/services/store/fiyatlandirma.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import Fiyatlandirmalar from "./Fiyatlandirmalar";
export default {
    name: "VergiGrupEkle",
    components: { Fiyatlandirmalar },
    data() {
        return {
            form: {
                ad: "",
                oran: 0
            },
            onSubmitForm: false,
            updateID: "",
            itemKey: "",
            isUpdate: false
        };
    },
    methods: {
        async sendInsertForm() {
            const submitButton = this.$refs["submit"];
            console.log(submitButton);
            this.onSubmitForm = true;
            try {
                await this.$store.dispatch(ADD_FIYATLANDIRMA, this.form);
                this.form = {
                    ad: "",
                    oran: 0
                };
                window.Toast.fire({
                    icon: "success",
                    title: this.$t("REQUEST_MESSAGES.ADD_MESSAGE")
                });
                this.$Progress.finish();
            } catch (error) {
                console.log(error.response);
                window.Toast.fire({
                    icon: "error",
                    title: this.$t("REQUEST_MESSAGES.WENT_WRONG")
                });
                this.$Progress.fail();
            }
            this.onSubmitForm = false;
        },
        setUpdateData(obj) {
            this.form.grupAdi = obj.ad;
            this.updateID = obj.id;
            this.itemKey = obj.key;
            this.isUpdate = true;
        },
        /*sendUpdateForm() {
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
    },*/
        cancelUpdate() {
            this.form.grupAdi = "";
            this.updateID = "";
            this.itemKey = "";
            this.isUpdate = false;
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: this.$t("FIYATLANDIRMA.FIYATLANDIRMALAR") }
        ]);
    }
};
</script>
