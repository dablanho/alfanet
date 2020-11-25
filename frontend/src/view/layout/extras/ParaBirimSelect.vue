<template>
    <div>
        <div class="col-12 float-left p-0 d-block">
            <div class="float-left p-0 form-group col-12">
                <select
                    @input="$emit('input', $event.target.value)"
                    class="form-control"
                    v-model="selectedItem"
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in filteredList"
                        :key="key"
                        :value="value.id"
                        >{{ value.kod }}</option
                    >
                </select>
                <small id="emailHelp" class="form-text">{{
                    $t("GENERAL.SELECT_CURRENCY")
                }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import { GET_CURRENCIES } from "@/core/services/store/para-birim.module";
import { mapGetters } from "vuex";
export default {
    name: "ParaBirimSelect",
    props: ["hesapYok", "selected"],
    data() {
        return {
            filteredList: [],
            selectedItem: 0
        };
    },
    method: {},
    mounted() {
        this.$store.dispatch(GET_CURRENCIES).then(() => {
            !this.hesapYok
                ? window.Fire.$on(
                      "currency-change",
                      hesap =>
                          (this.filteredList = [...this.getCurrencies].filter(
                              cur => cur.id === +hesap.para_birimi_id
                          ))
                  )
                : (this.filteredList = this.getCurrencies);
        });
    },
    computed: {
        ...mapGetters(["getCurrencies"])
    },
    watch: {
        selected: {
            handler(val) {
                if (val) {
                    this.selectedItem = val;
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
