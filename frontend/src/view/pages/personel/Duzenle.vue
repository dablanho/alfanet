<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h4>{{ $t("STAFF.UPDATE") }}</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.ad"
                            :placeholder="$t('GENERAL.FIRST_NAME_LAST_NAME')"
                        />
                        <small id="emailHelp" class="form-text text-muted">{{
                            $t("GENERAL.TYPE_A_NAME")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <select class="form-control" v-model="form.grup">
                            <option value="0">{{
                                $t("GENERAL.SELECT")
                            }}</option>
                            <option
                                v-for="(value, key) in getGroups"
                                :key="key"
                                :value="value.id"
                                >{{ value.ad }}</option
                            >
                        </select>
                        <small class="form-text text-muted">{{
                            $t("STAFF.CHOOSE_A_GROUP")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="email"
                            class="form-control"
                            v-model="form.email"
                            placeholder="abcd@mail.com..."
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_EMAIL")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="password"
                            class="form-control"
                            v-model="form.password"
                            placeholder="******"
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.UPDATE_PASSWORD")
                        }}</small>
                    </div>
                    <div class="float-left form-group col-6">
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.telefon"
                            placeholder="0555 555 55 55"
                        />
                        <small class="form-text text-muted">{{
                            $t("GENERAL.TYPE_PHONE")
                        }}</small>
                    </div>

                    <AdressSelect
                        v-model="selectedItems"
                        :is-update="true"
                    ></AdressSelect>
                    <div class="form-group">
                        <button
                            ref="submit"
                            @click="sendUpdateForm"
                            class="btn btn-warning float-right"
                        >
                            {{ $t("GENERAL.UPDATE") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_GROUPS } from "@/core/services/store/personel-grup.module";
import { UPDATE_STAFF, GET_STAFF } from "@/core/services/store/personel.module";
import { mapGetters, mapActions } from "vuex";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "PersonelDuzenle",
    data() {
        return {
            form: {
                ad: "",
                email: "",
                telefon: "",
                password: "",
                grup: 0,
                okullar: []
            },
            selectedItems: {
                country: 0,
                city: 0,
                distritc: "",
                distritcAndStreet: 0
            }
        };
    },

    methods: {
        ...mapActions({
            update_staff: UPDATE_STAFF,
            set_breadcrumb: SET_BREADCRUMB,
            get_groups: GET_GROUPS,
            get_staff: GET_STAFF
        }),
        spinnerOperation(button, type) {
            button.classList[type]("spinner", "spinner-light", "spinner-right");
        },
        sendUpdateForm() {
            const submitButton = this.$refs["submit"];
            this.spinnerOperation(submitButton, "add");
            this.update_staff({
                ...this.form,
                ...this.selectedItems,
                id: this.$route.params.id
            })
                .then(() => this.spinnerOperation(submitButton, "remove"))
                .catch(() => this.spinnerOperation(submitButton, "remove"));
        },
        setStaffToUpdate(staff) {
            let selectedItems = {
                country: staff.country ? staff.country.id : 0,
                city: staff.city ? staff.city.id : 0,
                district: staff.district ? staff.district.ilce : "",
                districtAndStreet: staff.district ? staff.district.id : 0
            };
            window.Fire.$emit("setAddressInfos", selectedItems);
            this.selectedItems = selectedItems;
            this.form.ad = staff.ad;
            this.form.email = staff.email;
            this.form.telefon = staff.telefon;
            this.form.grup = staff.grup.id;
        }
    },
    mounted() {
        this.get_staff(this.$route.params.id).then(() =>
            this.setStaffToUpdate(this.getStaff)
        );
        this.set_breadcrumb([
            { route: "/personeller", title: this.$t("STAFF.STAFFS") },
            { title: this.$t("STAFF.UPDATE") }
        ]);
        this.get_groups();
    },
    computed: {
        ...mapGetters(["getGroups", "getStaff"])
    }
};
</script>
