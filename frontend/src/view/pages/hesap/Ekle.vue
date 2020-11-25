<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("HESAP.DEFINITION") }}</h4>
            </div>
            <div class="card-body" v-if="errors">
                <error-handler v-if="errors" :datas="errors" />
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.hesap_ad"
                            :placeholder="$t('HESAP.HESAP_AD')"
                        />
                        <small class="form-text">{{
                            $t("HESAP.HESAP_AD")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.banka_ad"
                            :placeholder="$t('HESAP.BANKA_AD')"
                        />
                        <small class="form-text">{{
                            $t("HESAP.BANKA_AD")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.iban_no"
                            :placeholder="$t('HESAP.IBAN_HOLDER')"
                        />
                        <small class="form-text">{{ $t("HESAP.IBAN") }}</small>
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <ParaBirimSelect
                            :hesapYok="true"
                            v-model="form.para_birimi"
                        />
                    </div>
                    <div class="float-left form-group col-md-6 col-sm-12">
                        <input
                            type="number"
                            class="form-control"
                            value="0"
                            min="0"
                            v-model="form.baslangic_bakiye"
                        />
                        <small class="form-text">{{
                            $t("HESAP.BASLANGIC_BAKIYE")
                        }}</small>
                    </div>
                    <div class="form-group">
                        <button
                            :class="{
                                'spinner-border': isLoading,
                                'btn btn-success float-right': !isLoading
                            }"
                            @click="sendForm"
                        >
                            <span :class="{ 'sr-only': isLoading }">{{
                                $t("GENERAL.SAVE")
                            }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ADD_HESAP } from "@/core/services/store/hesap.module";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "HesapEkle",

    data() {
        return {
            form: {
                hesap_ad: "",
                banka_ad: "",
                iban_no: "",
                para_birimi: 0,
                baslangic_bakiye: 0
            },
            isLoading: false,
            errors: null
        };
    },
    methods: {
        async sendForm() {
            this.isLoading = true;
            try {
                await this.$store.dispatch(ADD_HESAP, {
                    ...this.form
                });
                this.form = {
                    hesap_ad: "",
                    banka_ad: "",
                    iban_no: "",
                    para_birimi: 0,
                    baslangic_bakiye: 0
                };
                this.isLoading = false;
            } catch (error) {
                if (error.response.status === 422)
                    this.errors = error.response.data.errors;
                this.isLoading = false;
            }
        }
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { route: "/hesaplar", title: this.$t("HESAP.HESAPLAR") },
            {
                title: this.$t("HESAP.DEFINITION")
            }
        ]);
    }
};
</script>
