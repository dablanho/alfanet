<template>
    <div>
        <div class="col-12 float-left p-0 d-block">
            <div v-if="filteredList" class="float-left p-0 form-group col-12">
                <select
                    @input="$emit('input', $event.target.value)"
                    class="form-control"
                    @change="
                        $emit(
                            'hesap-change',
                            filteredList.find(
                                cur => cur.id == $event.target.value
                            )
                        )
                    "
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in filteredList"
                        :key="key"
                        :value="value.id"
                        >{{ value.ad }}</option
                    >
                </select>
                <small id="emailHelp" class="form-text ">
                    {{ $t(selectText) }}
                </small>
            </div>
        </div>
    </div>
</template>

<script>
import { HESAP_SELECT } from "@/core/services/store/hesap.module";
import { mapGetters } from "vuex";
export default {
    name: "HesapSelect",
    props: {
        selectText: {
            type: String,
            default: ""
        },
        para_birimi: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            filteredList: []
        };
    },
    mounted() {
        this.$store.dispatch(HESAP_SELECT).then(() => {
            if (this.para_birimi !== 0) {
                this.filteredList = this.getHesaplarSelect.filter(
                    curr => +curr.para_birimi_id === this.para_birimi
                );
            } else {
                this.filteredList = this.getHesaplarSelect;
            }
        });
    },
    computed: {
        ...mapGetters(["getHesaplarSelect"])
    }
};
</script>
